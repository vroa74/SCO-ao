<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Agenda::with('usuario')
            ->delUsuario(Auth::id())
            ->orderBy('fecha', 'desc')
            ->orderBy('hora_inicio', 'asc');

        // Filtros
        if ($request->filled('fecha')) {
            $query->porFecha($request->fecha);
        }

        if ($request->filled('tipo')) {
            $query->porTipo($request->tipo);
        }

        if ($request->filled('prioridad')) {
            $query->porPrioridad($request->prioridad);
        }

        if ($request->filled('estado')) {
            $query->porEstado($request->estado);
        }

        $agendas = $query->paginate(10);

        return view('agenda.index', compact('agendas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::where('estatus', true)
            ->where('id', '!=', Auth::id())
            ->orderBy('nombre')
            ->get();

        return view('agenda.create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i|after:hora_inicio',
            'tipo' => 'required|in:reunion,evento,tarea,recordatorio',
            'prioridad' => 'required|in:baja,media,alta,urgente',
            'estado' => 'required|in:pendiente,en_progreso,completado,cancelado',
            'ubicacion' => 'nullable|string|max:255',
            'participantes' => 'nullable|array',
            'participantes.*' => 'exists:users,id',
            'recordatorio' => 'boolean',
            'minutos_antes' => 'nullable|integer|min:1|max:1440',
        ]);

        $agendaData = $request->all();
        $agendaData['usuario_id'] = Auth::id();

        // Convertir participantes a array si viene como string
        if ($request->has('participantes') && is_string($request->participantes)) {
            $agendaData['participantes'] = json_decode($request->participantes, true);
        }

        Agenda::create($agendaData);

        return redirect()->route('agenda.index')->with('success', 'Evento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Agenda $agenda)
    {
        // Verificar que el usuario sea el propietario del evento
        if ($agenda->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permisos para ver este evento.');
        }

        $agenda->load('usuario');

        return view('agenda.show', compact('agenda'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agenda $agenda)
    {
        // Verificar que el usuario sea el propietario del evento
        if ($agenda->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permisos para editar este evento.');
        }

        $usuarios = User::where('estatus', true)
            ->where('id', '!=', Auth::id())
            ->orderBy('nombre')
            ->get();

        return view('agenda.edit', compact('agenda', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agenda $agenda)
    {
        // Verificar que el usuario sea el propietario del evento
        if ($agenda->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permisos para editar este evento.');
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i|after:hora_inicio',
            'tipo' => 'required|in:reunion,evento,tarea,recordatorio',
            'prioridad' => 'required|in:baja,media,alta,urgente',
            'estado' => 'required|in:pendiente,en_progreso,completado,cancelado',
            'ubicacion' => 'nullable|string|max:255',
            'participantes' => 'nullable|array',
            'participantes.*' => 'exists:users,id',
            'recordatorio' => 'boolean',
            'minutos_antes' => 'nullable|integer|min:1|max:1440',
        ]);

        $agendaData = $request->all();

        // Convertir participantes a array si viene como string
        if ($request->has('participantes') && is_string($request->participantes)) {
            $agendaData['participantes'] = json_decode($request->participantes, true);
        }

        $agenda->update($agendaData);

        return redirect()->route('agenda.index')->with('success', 'Evento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agenda $agenda)
    {
        // Verificar que el usuario sea el propietario del evento
        if ($agenda->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permisos para eliminar este evento.');
        }

        $agenda->delete();

        return redirect()->route('agenda.index')->with('success', 'Evento eliminado exitosamente.');
    }
}
