<?php

namespace App\Livewire\Catalogo;

use Livewire\Component;
use App\Models\Nc;

class NcComponent extends Component
{
    public $ncs; // Lista de nc
    public $newNc = ''; // Input para la nueva nc
    public $editingId = null; // ID del elemento que se está editando
    public $temp;

    public function mount()
    {
        $this->loadNcs();
    }

    public function loadNcs()
    {
        $this->ncs = Nc::orderBy('id', 'desc')->get();
    }

    public function addNc()
    {
        // Validar el input
        $this->validate([
            'newNc' => 'required|string|max:40',
        ]);
        
        // Verificar duplicados
        if (Nc::where('nc', $this->newNc)->exists()) {
            session()->flash('error', 'El registro ya existe.');
            return;
        }

        // Guardar en la base de datos
        Nc::create(['nc' => $this->newNc]);

        // Recargar la lista
        $this->loadNcs();

        // Limpiar el input
        $this->newNc = '';
        session()->flash('success', 'Registro agregado correctamente.');
    }

    public function startEdit($id)
    {
        $this->editingId = $id;
        $this->temp = Nc::find($id)->nc; // Guardar el valor actual en temp
        $this->newNc = $this->temp; // Establecer el valor para editar
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->newNc = '';
        $this->temp = null;
    }

    public function saveEdit()
    {
        $this->validate([
            'newNc' => 'required|string|max:40',
        ]);

        // Verificar que el ID en edición exista
        $nc = Nc::find($this->editingId);
        if (!$nc) {
            session()->flash('error', 'Registro no encontrado.');
            return;
        }

        // Verificar duplicados (excepto el actual)
        if (Nc::where('nc', $this->newNc)
            ->where('id', '!=', $this->editingId)
            ->exists()) {
            session()->flash('error', 'El registro ya existe.');
            return;
        }

        // Actualizar el registro
        $nc->update(['nc' => $this->newNc]);

        // Limpiar el estado de edición
        $this->newNc = '';
        $this->editingId = null;
        $this->temp = null;
        $this->loadNcs();

        session()->flash('success', 'Registro actualizado correctamente.');
    }

    public function confirmDelete($id)
    {
        $this->deleteNc($id);
    }

    public function deleteNc($id)
    {
        $nc = Nc::find($id);
        if (!$nc) {
            session()->flash('error', 'Registro no encontrado.');
            return;
        }

        $nc->delete();
        $this->loadNcs();
        session()->flash('success', 'Registro eliminado correctamente.');
    }

    public function render()
    {
        return view('livewire.catalogo.nc-component');
    }
}
