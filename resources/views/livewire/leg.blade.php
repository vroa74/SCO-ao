<div class="text-white">
    <!-- Título responsivo -->
    <h3 class="text-center text-sm md:text-base font-semibold mb-2 md:mb-3">Legislatura</h3>

    <!-- Selector de Legislatura Actual -->
    <div class="mb-3 md:mb-4">
        <label for="legislatura" class="block mb-1 text-xs md:text-sm font-medium text-white">Seleccionar Legislatura
            Actual</label>
        <select id="legislatura"
            class="w-full p-1.5 md:p-2 text-xs md:text-sm bg-gray-700 border border-gray-600 text-white rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors"
            wire:change="setActual($event.target.value)">
            <option selected>Seleccione una opción</option>
            @foreach ($legis as $item)
                <option value="{{ $item->id }}" @if ($item->actual) selected @endif>
                    {{ $item->legislatura }}</option>
            @endforeach
        </select>
    </div>

    <!-- Formulario de Agregar/Editar -->
    <div class="mb-2">
        <div class="flex flex-col space-y-1">
            <input type="text" id="legislatura-input" name="legislatura" wire:model.defer="newLegislatura"
                placeholder="Ingrese legislatura"
                class="w-full p-1 text-xs text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500">

            <div class="flex space-x-1">
                @if ($editingId)
                    <button wire:click="saveEdit"
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-1 px-2 rounded text-xs">
                        <i class="fa-solid fa-save mr-1"></i>Guardar
                    </button>
                    <button wire:click="cancelEdit"
                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-1 px-2 rounded text-xs">
                        <i class="fa-solid fa-times mr-1"></i>Cancelar
                    </button>
                @else
                    <button wire:click="addLegislatura"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-1 px-2 rounded text-xs">
                        <i class="fa-solid fa-plus mr-1"></i>Agregar
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Mensajes de Estado -->
    @if (session()->has('success'))
        <div class="mb-3 p-2 bg-green-600 text-white text-xs md:text-sm rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-3 p-2 bg-red-600 text-white text-xs md:text-sm rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Errores de validación -->
    @error('newLegislatura')
        <div class="mb-3 p-2 bg-red-600 text-white text-xs md:text-sm rounded-lg">
            {{ $message }}
        </div>
    @enderror

    <!-- Lista de Legislaturas -->
    <div class="space-y-1 md:space-y-2">
        <h4 class="text-xs md:text-sm font-medium text-gray-300 mb-1 md:mb-2">Legislaturas Registradas:</h4>
        @foreach ($legis as $items)
            <div class="flex justify-between items-center p-1 bg-gray-800 rounded hover:bg-gray-750 transition-colors">
                <span
                    class="@if ($items->actual) font-bold text-green-400 @else text-white @endif text-xs">
                    {{ $items->legislatura }}
                    @if ($items->actual)
                        <span class="ml-1 text-xs bg-green-600 px-1 py-0.5 rounded-full">Actual</span>
                    @endif
                </span>
                <div class="flex space-x-1">
                    <button wire:click="startEdit({{ $items->id }})"
                        class="p-1 bg-yellow-600 hover:bg-yellow-700 text-white rounded transition-colors"
                        title="Editar">
                        <i class="fa-solid fa-pencil text-xs"></i>
                    </button>
                    <button wire:click="confirmDelete({{ $items->id }})"
                        class="p-1 bg-red-600 hover:bg-red-700 text-white rounded transition-colors" title="Eliminar">
                        <i class="fa-solid fa-trash-can text-xs"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

</div>
