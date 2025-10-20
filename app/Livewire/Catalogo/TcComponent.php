<?php

namespace App\Livewire\Catalogo;

use Livewire\Component;
use App\Models\Tc;

class TcComponent extends Component
{
    public $tcs; // Lista de tc
    public $newTc = ''; // Input para la nueva tc
    public $editingId = null; // ID del elemento que se está editando
    public $temp;

    public function mount()
    {
        $this->loadTcs();
    }

    public function loadTcs()
    {
        $this->tcs = Tc::orderBy('id', 'desc')->get();
    }

    public function addTc()
    {
        // Validar el input
        $this->validate([
            'newTc' => 'required|string|max:40',
        ]);
        
        // Verificar duplicados
        if (Tc::where('tc', $this->newTc)->exists()) {
            session()->flash('error', 'El registro ya existe.');
            return;
        }

        // Guardar en la base de datos
        Tc::create(['tc' => $this->newTc]);

        // Recargar la lista
        $this->loadTcs();

        // Limpiar el input
        $this->newTc = '';
        session()->flash('success', 'Registro agregado correctamente.');
    }

    public function startEdit($id)
    {
        $this->editingId = $id;
        $this->temp = Tc::find($id)->tc; // Guardar el valor actual en temp
        $this->newTc = $this->temp; // Establecer el valor para editar
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->newTc = '';
        $this->temp = null;
    }

    public function saveEdit()
    {
        $this->validate([
            'newTc' => 'required|string|max:40',
        ]);

        // Verificar que el ID en edición exista
        $tc = Tc::find($this->editingId);
        if (!$tc) {
            session()->flash('error', 'Registro no encontrado.');
            return;
        }

        // Verificar duplicados (excepto el actual)
        if (Tc::where('tc', $this->newTc)
            ->where('id', '!=', $this->editingId)
            ->exists()) {
            session()->flash('error', 'El registro ya existe.');
            return;
        }

        // Actualizar el registro
        $tc->update(['tc' => $this->newTc]);

        // Limpiar el estado de edición
        $this->newTc = '';
        $this->editingId = null;
        $this->temp = null;
        $this->loadTcs();

        session()->flash('success', 'Registro actualizado correctamente.');
    }

    public function confirmDelete($id)
    {
        $this->deleteTc($id);
    }

    public function deleteTc($id)
    {
        $tc = Tc::find($id);
        if (!$tc) {
            session()->flash('error', 'Registro no encontrado.');
            return;
        }

        $tc->delete();
        $this->loadTcs();
        session()->flash('success', 'Registro eliminado correctamente.');
    }

    public function render()
    {
        return view('livewire.catalogo.tc-component');
    }
}
