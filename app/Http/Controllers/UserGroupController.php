<?php

namespace App\Http\Controllers;

use App\Models\UserGroup;
use App\Models\User;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = UserGroup::with(['creator', 'activeMembers']);

        // Búsqueda por nombre
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Filtro por grupos del usuario actual
        if ($request->filled('my_groups') && $request->my_groups === 'true') {
            $query->whereHas('activeMembers', function($q) {
                $q->where('user_id', Auth::id());
            });
        }

        $userGroups = $query->with(['creator'])
                           ->withCount('activeMembers as members_count')
                           ->orderBy('id', 'asc')
                           ->paginate(15);

        return view('user-groups.index', compact('userGroups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $users = User::where('estatus', true)
            ->where('id', '!=', Auth::id())
            ->orderBy('nombre')
            ->get();

        return view('user-groups.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Debug: mostrar datos recibidos
        \Log::info('Datos recibidos en store:', [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'members' => $request->input('members'),
            'members_count' => count($request->input('members', [])),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:user_groups,name',
            'description' => 'nullable|string',
            'members' => 'required|array|min:1',
            'members.*' => 'exists:users,id',
        ], [
            'name.required' => 'El nombre del grupo es obligatorio.',
            'name.unique' => 'Ya existe un grupo con este nombre.',
            'members.required' => 'Debe seleccionar al menos un miembro.',
            'members.min' => 'Debe seleccionar al menos un miembro.',
            'members.*.exists' => 'Uno de los usuarios seleccionados no existe.',
        ]);

        // Debug: mostrar datos validados
        \Log::info('Datos validados:', [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'members' => $validated['members'],
            'members_count' => count($validated['members']),
        ]);

        // Verificar que no se repitan los miembros
        $members = array_unique($validated['members']);
        if (count($members) !== count($validated['members'])) {
            return back()->withErrors(['members' => 'No se pueden repetir los miembros.'])->withInput();
        }

        // Verificar que el usuario actual no esté en los miembros
        if (in_array(Auth::id(), $members)) {
            return back()->withErrors(['members' => 'No puedes agregarte a ti mismo como miembro.'])->withInput();
        }

        DB::beginTransaction();
        try {
            // Crear el grupo
            $userGroup = UserGroup::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'created_by' => Auth::id(),
                'is_active' => true,
            ]);

            // El creador no se agrega como miembro activo, solo como creador

            // Agregar los miembros seleccionados
            foreach ($members as $memberId) {
                $userGroup->addMember($memberId, 'member');
            }

            DB::commit();

            // Debug: confirmar creación
            \Log::info('Grupo creado exitosamente:', [
                'group_id' => $userGroup->id,
                'group_name' => $userGroup->name,
                'members_count' => $userGroup->activeMembers()->count(),
                'creator_id' => $userGroup->created_by,
            ]);

            return redirect()->route('user-groups.index')
                ->with('success', 'Grupo creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Error al crear el grupo. Inténtalo de nuevo.'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UserGroup $userGroup): View
    {
        $userGroup->load(['creator', 'activeMembers', 'activeGroupMembers.user']);
        
        return view('user-groups.show', compact('userGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserGroup $userGroup): View
    {
        // Solo el creador puede editar el grupo
        if ($userGroup->created_by !== Auth::id()) {
            abort(403, 'No tienes permisos para editar este grupo.');
        }

        $users = User::where('estatus', true)
            ->where('id', '!=', Auth::id())
            ->orderBy('nombre')
            ->get();

        $currentMembers = $userGroup->activeMembers()->pluck('users.id')->toArray();

        return view('user-groups.edit', compact('userGroup', 'users', 'currentMembers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserGroup $userGroup): RedirectResponse
    {
        // Solo el creador puede editar el grupo
        if ($userGroup->created_by !== Auth::id()) {
            abort(403, 'No tienes permisos para editar este grupo.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:user_groups,name,' . $userGroup->id,
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
            'members' => 'required|array|min:1',
            'members.*' => 'exists:users,id',
        ], [
            'name.required' => 'El nombre del grupo es obligatorio.',
            'name.unique' => 'Ya existe un grupo con este nombre.',
            'is_active.required' => 'Debe seleccionar el estado del grupo.',
            'is_active.boolean' => 'El estado del grupo debe ser válido.',
            'members.required' => 'Debe seleccionar al menos un miembro.',
            'members.min' => 'Debe seleccionar al menos un miembro.',
            'members.*.exists' => 'Uno de los usuarios seleccionados no existe.',
        ]);

        // Verificar que no se repitan los miembros
        $members = array_unique($validated['members']);
        if (count($members) !== count($validated['members'])) {
            return back()->withErrors(['members' => 'No se pueden repetir los miembros.'])->withInput();
        }

        // Verificar que el usuario actual no esté en los miembros
        if (in_array(Auth::id(), $members)) {
            return back()->withErrors(['members' => 'No puedes agregarte a ti mismo como miembro.'])->withInput();
        }

        DB::beginTransaction();
        try {
            // Actualizar el grupo
            $userGroup->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'is_active' => (bool) $validated['is_active'],
            ]);

            // Obtener miembros actuales
            $currentMembers = $userGroup->activeMembers->pluck('id')->toArray();
            $newMembers = $members;

            // Remover miembros que ya no están
            $membersToRemove = array_diff($currentMembers, $newMembers);
            foreach ($membersToRemove as $memberId) {
                if ($memberId !== Auth::id()) { // No remover al creador
                    $userGroup->removeMember($memberId);
                }
            }

            // Agregar nuevos miembros
            $membersToAdd = array_diff($newMembers, $currentMembers);
            foreach ($membersToAdd as $memberId) {
                $userGroup->addMember($memberId, 'member');
            }

            DB::commit();

            return redirect()->route('user-groups.show', $userGroup)
                ->with('success', 'Grupo actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Error al actualizar el grupo. Inténtalo de nuevo.'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserGroup $userGroup): RedirectResponse
    {
        // Solo el creador puede eliminar el grupo
        if ($userGroup->created_by !== Auth::id()) {
            abort(403, 'No tienes permisos para eliminar este grupo.');
        }

        $userGroup->update(['is_active' => false]);

        return redirect()->route('user-groups.index')
            ->with('success', 'Grupo desactivado exitosamente.');
    }

    /**
     * Add a member to the group.
     */
    public function addMember(Request $request, UserGroup $userGroup): RedirectResponse
    {
        // Solo el creador puede agregar miembros
        if ($userGroup->created_by !== Auth::id()) {
            abort(403, 'No tienes permisos para agregar miembros a este grupo.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:member,admin',
        ]);

        if ($userGroup->addMember($validated['user_id'], $validated['role'])) {
            return back()->with('success', 'Miembro agregado exitosamente.');
        }

        return back()->withErrors(['error' => 'El usuario ya es miembro del grupo.']);
    }

    /**
     * Remove a member from the group.
     */
    public function removeMember(Request $request, UserGroup $userGroup): RedirectResponse
    {
        // Solo el creador puede remover miembros
        if ($userGroup->created_by !== Auth::id()) {
            abort(403, 'No tienes permisos para remover miembros de este grupo.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // No permitir remover al creador
        if ($validated['user_id'] === Auth::id()) {
            return back()->withErrors(['error' => 'No puedes removerte a ti mismo del grupo.']);
        }

        if ($userGroup->removeMember($validated['user_id'])) {
            return back()->with('success', 'Miembro removido exitosamente.');
        }

        return back()->withErrors(['error' => 'El usuario no es miembro del grupo.']);
    }

    /**
     * Update member role.
     */
    public function updateMemberRole(Request $request, UserGroup $userGroup): RedirectResponse
    {
        // Solo el creador puede cambiar roles
        if ($userGroup->created_by !== Auth::id()) {
            abort(403, 'No tienes permisos para cambiar roles en este grupo.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:member,admin',
        ]);

        // No permitir cambiar el rol del creador
        if ($validated['user_id'] === Auth::id()) {
            return back()->withErrors(['error' => 'No puedes cambiar tu propio rol.']);
        }

        if ($userGroup->updateMemberRole($validated['user_id'], $validated['role'])) {
            return back()->with('success', 'Rol actualizado exitosamente.');
        }

        return back()->withErrors(['error' => 'Error al actualizar el rol.']);
    }
}