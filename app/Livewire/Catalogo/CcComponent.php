<?php

namespace App\Livewire\Catalogo;

use Livewire\Component;
use App\Models\Cc;
use App\Models\Tc;

class CcComponent extends Component
{
    public $ccs; // Lista de cc
    public $newCc = ''; // Input para la nueva cc
    public $selectedTcId = ''; // TC seleccionado
    public $editingId = null; // ID del elemento que se está editando
    public $temp;

    public function mount()
    {
        $this->loadCcs();
    }

    public function loadCcs()
    {
        $this->ccs = Cc::with('tc')->orderBy('id', 'desc')->get();
    }

    public function addCc()
    {
        // Validar el input
        $this->validate([
            'newCc' => 'required|string|max:100',
            'selectedTcId' => 'required|exists:tc,id',
        ]);
        
        // Verificar duplicados
        if (Cc::where('ccor', $this->newCc)->where('tc_id', $this->selectedTcId)->exists()) {
            session()->flash('error', 'El registro ya existe para este TC.');
            return;
        }

        // Guardar en la base de datos
        Cc::create([
            'tc_id' => $this->selectedTcId,
            'ccor' => $this->newCc
        ]);

        // Recargar la lista
        $this->loadCcs();

        // Limpiar el input
        $this->newCc = '';
        $this->selectedTcId = '';
        session()->flash('success', 'Registro agregado correctamente.');
    }

    public function startEdit($id)
    {
        $cc = Cc::find($id);
        $this->editingId = $id;
        $this->temp = $cc->ccor; // Guardar el valor actual en temp
        $this->newCc = $this->temp; // Establecer el valor para editar
        $this->selectedTcId = $cc->tc_id;
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->newCc = '';
        $this->selectedTcId = '';
        $this->temp = null;
    }

    public function saveEdit()
    {
        $this->validate([
            'newCc' => 'required|string|max:100',
            'selectedTcId' => 'required|exists:tc,id',
        ]);

        // Verificar que el ID en edición exista
        $cc = Cc::find($this->editingId);
        if (!$cc) {
            session()->flash('error', 'Registro no encontrado.');
            return;
        }

        // Verificar duplicados (excepto el actual)
        if (Cc::where('ccor', $this->newCc)
            ->where('tc_id', $this->selectedTcId)
            ->where('id', '!=', $this->editingId)
            ->exists()) {
            session()->flash('error', 'El registro ya existe para este TC.');
            return;
        }

        // Actualizar el registro
        $cc->update([
            'tc_id' => $this->selectedTcId,
            'ccor' => $this->newCc
        ]);

        // Limpiar el estado de edición
        $this->newCc = '';
        $this->selectedTcId = '';
        $this->editingId = null;
        $this->temp = null;
        $this->loadCcs();

        session()->flash('success', 'Registro actualizado correctamente.');
    }

    public function confirmDelete($id)
    {
        $this->deleteCc($id);
    }

    public function deleteCc($id)
    {
        $cc = Cc::find($id);
        if (!$cc) {
            session()->flash('error', 'Registro no encontrado.');
            return;
        }

        $cc->delete();
        $this->loadCcs();
        session()->flash('success', 'Registro eliminado correctamente.');
    }

    public function render()
    {
        return view('livewire.catalogo.cc-component', [
            'tcs' => Tc::orderBy('tc')->get()
        ]);
    }
}
