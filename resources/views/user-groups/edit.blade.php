<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Grupo de Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <form method="POST" action="{{ route('user-groups.update', $userGroup) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nombre del grupo -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Nombre del Grupo') }}
                            </label>
                            <input id="name"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-violet-500 focus:ring-violet-500 rounded-md shadow-sm"
                                type="text" name="name" value="{{ old('name', $userGroup->name) }}" required
                                autofocus />
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('El nombre debe ser único y descriptivo.') }}
                            </p>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Descripción') }}
                            </label>
                            <textarea id="description"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-violet-500 focus:ring-violet-500 rounded-md shadow-sm"
                                name="description" rows="3">{{ old('description', $userGroup->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Descripción opcional del propósito del grupo.') }}
                            </p>
                        </div>

                        <!-- Estado del grupo -->
                        <div class="mb-6">
                            <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Estado del Grupo') }}
                            </label>
                            <div class="mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="is_active" value="1"
                                        {{ old('is_active', $userGroup->is_active) ? 'checked' : '' }}
                                        class="h-4 w-4 text-violet-600 focus:ring-violet-500 border-gray-300 dark:border-gray-600">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        {{ __('Activo') }}
                                    </span>
                                </label>
                                <label class="inline-flex items-center ml-6">
                                    <input type="radio" name="is_active" value="0"
                                        {{ !old('is_active', $userGroup->is_active) ? 'checked' : '' }}
                                        class="h-4 w-4 text-violet-600 focus:ring-violet-500 border-gray-300 dark:border-gray-600">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        {{ __('Inactivo') }}
                                    </span>
                                </label>
                            </div>
                            @error('is_active')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Los grupos inactivos no pueden recibir nuevos miembros.') }}
                            </p>
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex items-center justify-end space-x-3 mb-6">
                            <a href="{{ route('user-groups.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:bg-gray-400 dark:focus:bg-gray-500 active:bg-gray-500 dark:active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Cancelar') }}
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-violet-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-violet-700 focus:bg-violet-700 active:bg-violet-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Actualizar Grupo') }}
                            </button>
                        </div>

                        <!-- Selección de usuarios con checkboxes -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                {{ __('Miembros del Grupo') }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                {{ __('Selecciona los usuarios que formarán parte del grupo. El grupo debe tener mínimo 2 integrantes (incluyendo al creador).') }}
                            </p>

                            <!-- Buscador -->
                            <div class="mb-4">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" id="user-search"
                                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500"
                                        placeholder="{{ __('Buscar por nombre, cargo o dirección...') }}">
                                </div>
                            </div>

                            <!-- Lista de usuarios en múltiples columnas -->
                            <div
                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-96 overflow-y-auto border border-gray-200 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700">
                                @foreach ($users as $user)
                                    <div class="user-card bg-white dark:bg-gray-600 border border-gray-200 dark:border-gray-500 rounded-lg p-3 hover:bg-gray-50 dark:hover:bg-gray-500 transition-colors"
                                        data-user-id="{{ $user->id }}"
                                        data-user-name="{{ strtolower($user->nombre) }}"
                                        data-user-cargo="{{ strtolower($user->cargo ?? 'sin cargo') }}"
                                        data-user-direccion="{{ strtolower($user->direccion ?? 'sin dirección') }}">
                                        <label class="flex items-start space-x-3 cursor-pointer">
                                            <input type="checkbox" name="members[]" value="{{ $user->id }}"
                                                {{ in_array($user->id, $currentMembers) ? 'checked' : '' }}
                                                class="mt-1 h-4 w-4 text-violet-600 focus:ring-violet-500 border-gray-300 dark:border-gray-600 rounded">
                                            <div class="flex-1 min-w-0">
                                                <div class="font-medium text-gray-900 dark:text-gray-100 text-sm">
                                                    {{ $user->nombre }}
                                                </div>
                                                <div class="text-xs text-gray-600 dark:text-gray-300 mt-1">
                                                    <strong>{{ __('Cargo') }}:</strong>
                                                    {{ $user->cargo ?? 'Sin cargo' }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    <strong>{{ __('Dirección') }}:</strong>
                                                    {{ $user->direccion ?? 'Sin dirección' }}
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Contador de miembros seleccionados -->
                            <div class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                                <span id="selected-count">0</span> {{ __('miembros seleccionados') }}
                            </div>

                            @error('members')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Información importante -->
                        <div
                            class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                        {{ __('Información importante') }}
                                    </h3>
                                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>{{ __('Serás automáticamente agregado como administrador del grupo.') }}
                                            </li>
                                            <li>{{ __('El grupo debe tener mínimo 2 integrantes.') }}</li>
                                            <li>{{ __('Los miembros no pueden repetirse en el mismo grupo.') }}</li>
                                            <li>{{ __('Los grupos se pueden usar para enviar y recibir documentación.') }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userSearch = document.getElementById('user-search');
            const userCards = document.querySelectorAll('.user-card');
            const selectedCount = document.getElementById('selected-count');
            const checkboxes = document.querySelectorAll('input[name="members[]"]');

            // Función para actualizar el contador
            function updateSelectedCount() {
                const checkedBoxes = document.querySelectorAll('input[name="members[]"]:checked');
                selectedCount.textContent = checkedBoxes.length;
            }

            // Función para filtrar usuarios
            function filterUsers() {
                const searchTerm = userSearch.value.toLowerCase();

                userCards.forEach(card => {
                    const userName = card.dataset.userName;
                    const userCargo = card.dataset.userCargo;
                    const userDireccion = card.dataset.userDireccion;

                    const isVisible = userName.includes(searchTerm) ||
                        userCargo.includes(searchTerm) ||
                        userDireccion.includes(searchTerm);

                    card.style.display = isVisible ? 'block' : 'none';
                });
            }

            // Event listeners
            userSearch.addEventListener('input', filterUsers);

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedCount);
            });

            // Inicializar contador
            updateSelectedCount();
        });
    </script>
</x-app-layout>
