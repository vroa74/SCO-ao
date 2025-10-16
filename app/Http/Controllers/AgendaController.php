<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Agenda::query();

        // Búsqueda
        if ($request->filled('search')) {
            $query->buscar($request->search);
        }

        // Filtros específicos
        if ($request->filled('titulo')) {
            $query->porTitulo($request->titulo);
        }

        if ($request->filled('nombre')) {
            $query->porNombre($request->nombre);
        }

        if ($request->filled('cargo')) {
            $query->porCargo($request->cargo);
        }

        if ($request->filled('deporg')) {
            $query->porDeporg($request->deporg);
        }

        if ($request->filled('email')) {
            $query->porEmail($request->email);
        }

        $agendas = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('agenda.index', compact('agendas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('agenda.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titulo' => 'nullable|string|max:5',
            'nombre' => 'nullable|string|max:30',
            'apaterno' => 'nullable|string|max:30',
            'amaterno' => 'nullable|string|max:30',
            'cargo' => 'nullable|string|max:30',
            'deporg' => 'nullable|string|max:60',
            'telefono' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'dir' => 'nullable|string',
            'modifico' => 'nullable|string|max:20',
        ]);

        $validated['modifico'] = Auth::user()->name ?? 'Sistema';

        Agenda::create($validated);

        return redirect()->route('agenda.index')
            ->with('success', 'Registro de agenda creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Agenda $agenda): View
    {
        return view('agenda.show', compact('agenda'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agenda $agenda): View
    {
        return view('agenda.edit', compact('agenda'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agenda $agenda): RedirectResponse
    {
        $validated = $request->validate([
            'titulo' => 'nullable|string|max:5',
            'nombre' => 'nullable|string|max:30',
            'apaterno' => 'nullable|string|max:30',
            'amaterno' => 'nullable|string|max:30',
            'cargo' => 'nullable|string|max:30',
            'deporg' => 'nullable|string|max:60',
            'telefono' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'dir' => 'nullable|string',
            'modifico' => 'nullable|string|max:20',
        ]);

        $validated['modifico'] = Auth::user()->name ?? 'Sistema';

        $agenda->update($validated);

        return redirect()->route('agenda.index')
            ->with('success', 'Registro de agenda actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agenda $agenda): RedirectResponse
    {
        $agenda->delete();

        return redirect()->route('agenda.index')
            ->with('success', 'Registro de agenda eliminado exitosamente.');
    }
}