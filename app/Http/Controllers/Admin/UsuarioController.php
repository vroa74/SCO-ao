<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filtro por nombre
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', "%{$request->nombre}%");
        }

        // Filtro por dirección
        if ($request->filled('direccion')) {
            $query->where('direccion', 'like', "%{$request->direccion}%");
        }

        // Filtro por puesto/cargo
        if ($request->filled('cargo')) {
            $query->where('cargo', 'like', "%{$request->cargo}%");
        }

        $usuarios = $query->orderBy('id', 'asc')->paginate(10);
        
        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'rfc' => 'nullable|string|max:13|unique:users,rfc',
            'curp' => 'nullable|string|max:20|unique:users,curp',
            'direccion' => 'nullable|string|max:250',
            'cargo' => 'nullable|string|max:35',
            'sexo' => 'nullable|in:masculino,femenino',
            'lvl' => 'nullable|string|max:10',
            'tipo' => 'required|integer|min:1|max:5',
            'estatus' => 'nullable|boolean',
            'theme' => 'nullable|in:light,dark',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        $userData = $request->except(['password_confirmation', 'photo']);
        $userData['password'] = Hash::make($request->password);
        $userData['tipo'] = $userData['tipo'] ?? 3;
        $userData['estatus'] = $userData['estatus'] ?? true;
        $userData['theme'] = $userData['theme'] ?? 'dark';

        if ($request->hasFile('photo')) {
            $filename = 'profile_' . time() . '.' . $request->photo->getClientOriginalExtension();
            $request->photo->storeAs('images/profiles', $filename, 'public');
            $userData['profile_photo_path'] = 'images/profiles/' . $filename;
        }

        User::create($userData);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $usuario)
    {
        return view('admin.usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
            'rfc' => 'nullable|string|max:13|unique:users,rfc,' . $usuario->id,
            'curp' => 'nullable|string|max:20|unique:users,curp,' . $usuario->id,
            'direccion' => 'nullable|string|max:250',
            'cargo' => 'nullable|string|max:35',
            'sexo' => 'nullable|in:masculino,femenino',
            'lvl' => 'nullable|string|max:10',
            'tipo' => 'required|integer|min:1|max:5',
            'estatus' => 'nullable|boolean',
            'theme' => 'nullable|in:light,dark',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        $userData = $request->except(['password_confirmation', 'photo']);

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        } else {
            unset($userData['password']);
        }

        if ($request->hasFile('photo')) {
            // Eliminar foto anterior si existe
            if ($usuario->profile_photo_path && file_exists(public_path($usuario->profile_photo_path))) {
                unlink(public_path($usuario->profile_photo_path));
            }

            $filename = 'profile_' . $usuario->id . '_' . time() . '.' . $request->photo->getClientOriginalExtension();
            $request->photo->storeAs('images/profiles', $filename, 'public');
            $userData['profile_photo_path'] = 'images/profiles/' . $filename;
        }

        $usuario->update($userData);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usuario)
    {
        // Eliminar foto si existe
        if ($usuario->profile_photo_path && file_exists(public_path($usuario->profile_photo_path))) {
            unlink(public_path($usuario->profile_photo_path));
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}