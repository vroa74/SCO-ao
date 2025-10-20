<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Legislatura;

class Leg extends Component
{
    public $legis; // Lista de legislaturas
    public $newLegislatura = ''; // Input para la nueva legislatura
    public $editingId = null; // ID del elemento que se está editando
    public $temp;

    public function mount()
    {
        $this->loadLegislaturas();
    }

    public function loadLegislaturas()
    {
        $this->legis = Legislatura::orderBy('id', 'desc')->get();
    }

    public function addLegislatura()
    {
        // Validar el input
        $this->validate([
            'newLegislatura' => 'required|string|max:15|alpha_dash',
        ]);
        // Convertir a uppercase
        $this->newLegislatura = strtoupper($this->newLegislatura);
        // Verificar duplicados
        if (Legislatura::where('legislatura', $this->newLegislatura)->exists()) {
            session()->flash('error', 'La legislatura ya existe.');
            return;
        }

        // Guardar en la base de datos
        Legislatura::create(['legislatura' => $this->newLegislatura, 'actual' => false]);

        // Recargar la lista
        $this->loadLegislaturas();

        // Limpiar el input
        $this->newLegislatura = '';
        session()->flash('success', 'Legislatura agregada correctamente.');
    }

    public function startEdit($id)
    {
        $this->editingId = $id;
        $this->temp = Legislatura::find($id)->legislatura; // Guardar el valor actual en temp
        $this->newLegislatura = $this->temp; // Establecer el valor para editar
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->newLegislatura = '';
        $this->temp = null;
    }

    public function saveEdit()
    {
        $this->validate([
            'newLegislatura' => 'required|string|max:15|alpha_dash',
        ]);
        $this->newLegislatura = strtoupper($this->newLegislatura);

        // Verificar que el ID en edición exista
        $legislatura = Legislatura::find($this->editingId);
        if (!$legislatura) {
            session()->flash('error', 'Legislatura no encontrada.');
            return;
        }

        // Verificar duplicados (excepto el actual)
        if (Legislatura::where('legislatura', $this->newLegislatura)
            ->where('id', '!=', $this->editingId)
            ->exists()) {
            session()->flash('error', 'La legislatura ya existe.');
            return;
        }

        // Actualizar el registro
        $legislatura->update(['legislatura' => $this->newLegislatura]);

        // Limpiar el estado de edición
        $this->newLegislatura = '';
        $this->editingId = null;
        $this->temp = null;
        $this->loadLegislaturas();

        session()->flash('success', 'Legislatura actualizada correctamente.');
    }

    public function confirmDelete($id)
    {
        $this->deleteLegislatura($id);
    }

    public function deleteLegislatura($id)
    {
        $legislatura = Legislatura::find($id);
        if (!$legislatura) {
            session()->flash('error', 'Legislatura no encontrada.');
            return;
        }

        // Verificar si es la última legislatura
        if (Legislatura::count() <= 1) {
            session()->flash('error', 'No se puede eliminar la última legislatura.');
            return;
        }

        $legislatura->delete();
        $this->loadLegislaturas();
        session()->flash('success', 'Legislatura eliminada correctamente.');
    }

    public function setActual($id)
    {
        // Establecer el elemento seleccionado como actual y los demás como falso
        Legislatura::query()->update(['actual' => false]);
        Legislatura::where('id', $id)->update(['actual' => true]);

        $this->loadLegislaturas();
    }

    public function render()
    {
        return view('livewire.leg');
    }
}
