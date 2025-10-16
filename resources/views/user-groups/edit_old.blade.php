<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Grupo de Usuarios') }}: {{ $userGroup->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <form method="POST" action="{{ route('user-groups.update', $userGroup) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nombre del grupo -->
                        <div>
                            <x-label for="name" value="{{ __('Nombre del Grupo') }}" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                value="{{ old('name', $userGroup->name) }}" maxlength="100" required />
                            <x-input-error for="name" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('El nombre debe ser único y descriptivo.') }}
                            </p>
                        </div>

                        <!-- Descripción -->
                        <div>
                            <x-label for="description" value="{{ __('Descripción') }}" />
                            <textarea id="description" name="description" rows="3"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-violet-500 dark:focus:border-violet-600 focus:ring-violet-500 dark:focus:ring-violet-600 rounded-md shadow-sm">{{ old('description', $userGroup->description) }}</textarea>
                            <x-input-error for="description" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Descripción opcional del propósito del grupo.') }}
                            </p>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('user-groups.show', $userGroup) }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:bg-gray-400 dark:focus:bg-gray-500 active:bg-gray-500 dark:active:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Cancelar') }}
                            </a>
                            <x-button class="ml-3">
                                {{ __('Actualizar Grupo') }}
                            </x-button>
                        </div>

                        <!-- Selección de miembros con Drag & Drop - Diseño de dos columnas -->
                        <div>
                            <x-label for="members" value="{{ __('Miembros del Grupo') }}" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 mb-4">
                                {{ __('Arrastra usuarios desde la lista disponible al grupo. El grupo debe tener mínimo 2 integrantes (incluyendo al creador).') }}
                            </p>

                            <!-- Diseño de dos columnas -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Columna izquierda: Usuarios disponibles -->
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ __('Usuarios Disponibles') }}
                                        </h4>
                                        <span class="text-xs text-gray-500 dark:text-gray-400"
                                            id="available-count">{{ count($users) - count($currentMembers) }}</span>
                                    </div>

                                    <!-- Filtro de búsqueda -->
                                    <div class="relative">
                                        <input type="text" id="user-search"
                                            placeholder="{{ __('Buscar por nombre...') }}"
                                            class="w-full pl-8 pr-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500 dark:bg-gray-700 dark:text-white">
                                        <svg class="absolute left-2 top-2.5 w-4 h-4 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>

                                    <!-- Lista de usuarios -->
                                    <div
                                        class="h-80 overflow-y-auto border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800">
                                        <div id="users-list" class="p-2 space-y-2">
                                            @foreach ($users as $user)
                                                @if (!in_array($user->id, $currentMembers))
                                                    <div class="user-card bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 cursor-move hover:shadow-md hover:bg-gray-100 dark:hover:bg-gray-600 transition-all"
                                                        draggable="true" data-user-id="{{ $user->id }}"
                                                        data-user-name="{{ $user->nombre }}"
                                                        data-user-cargo="{{ $user->cargo ?? 'Sin cargo' }}"
                                                        data-user-direccion="{{ $user->direccion ?? 'Sin dirección' }}">
                                                        <div class="flex items-center justify-between">
                                                            <div class="flex-1 min-w-0">
                                                                <div
                                                                    class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                                                    {{ $user->nombre }}
                                                                </div>
                                                                <div
                                                                    class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                                                    {{ $user->cargo ?? 'Sin cargo' }}
                                                                </div>
                                                                <div
                                                                    class="text-xs text-gray-400 dark:text-gray-500 truncate">
                                                                    {{ $user->direccion ?? 'Sin dirección' }}
                                                                </div>
                                                            </div>
                                                            <svg class="w-3 h-3 text-gray-400 ml-2 flex-shrink-0"
                                                                fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M4 8h16M4 16h16"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna derecha: Miembros del grupo -->
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ __('Miembros del Grupo') }}
                                        </h4>
                                        <span class="text-xs text-gray-500 dark:text-gray-400"
                                            id="member-count">{{ count($currentMembers) }}</span>
                                    </div>

                                    <!-- Zona de drop -->
                                    <div id="selected-members"
                                        class="h-80 border-2 border-dashed border-violet-300 dark:border-violet-600 rounded-lg p-3 bg-violet-50 dark:bg-violet-900/20 overflow-y-auto">
                                        @if (count($currentMembers) > 0)
                                            @foreach ($users->whereIn('id', $currentMembers) as $user)
                                                <div class="bg-white dark:bg-gray-600 border border-gray-200 dark:border-gray-500 rounded-lg p-2 mb-2 flex items-center justify-between"
                                                    data-user-id="{{ $user->id }}">
                                                    <div class="flex-1 min-w-0">
                                                        <div
                                                            class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                                            {{ $user->nombre }}
                                                        </div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                                            {{ $user->cargo ?? 'Sin cargo' }}
                                                        </div>
                                                        <div class="text-xs text-gray-400 dark:text-gray-500 truncate">
                                                            {{ $user->direccion ?? 'Sin dirección' }}
                                                        </div>
                                                    </div>
                                                    <button type="button"
                                                        onclick="removeMember('{{ $user->id }}')"
                                                        class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 ml-2 flex-shrink-0">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div
                                                class="text-center text-gray-500 dark:text-gray-400 text-sm h-full flex items-center justify-center">
                                                {{ __('Arrastra usuarios aquí para agregarlos al grupo') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Los inputs de miembros se generan dinámicamente -->
                            <x-input-error for="members" class="mt-2" />
                        </div>

                        <!-- Información adicional -->
                        <div
                            class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-md p-4">
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
                                            <li>{{ __('Los cambios se aplicarán inmediatamente.') }}</li>
                                            <li>{{ __('Los miembros removidos perderán acceso al grupo.') }}</li>
                                            <li>{{ __('Los nuevos miembros serán agregados como miembros regulares.') }}
                                            </li>
                                            <li>{{ __('El grupo debe mantener mínimo 2 integrantes.') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Miembros actuales -->
                        <div
                            class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md p-4">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">
                                {{ __('Miembros Actuales') }}
                            </h4>
                            <div class="space-y-1">
                                @foreach ($userGroup->activeMembers as $member)
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-900 dark:text-gray-100">
                                            {{ $member->nombre }}
                                            @if ($member->pivot->role === 'admin')
                                                <span
                                                    class="text-purple-600 dark:text-purple-400">({{ __('Admin') }})</span>
                                            @endif
                                        </span>
                                        @if ($member->id === auth()->id())
                                            <span
                                                class="text-gray-500 dark:text-gray-400 text-xs">({{ __('Creador') }})</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectedMembers = document.getElementById('selected-members');
            const memberCount = document.getElementById('member-count');
            const availableCount = document.getElementById('available-count');
            const userSearch = document.getElementById('user-search');
            const usersList = document.getElementById('users-list');
            let selectedUserIds = {{ count($currentMembers) > 0 ? json_encode($currentMembers) : '[]' }};
            let allUserCards = [];

            // Inicializar tarjetas de usuario
            function initializeUserCards() {
                allUserCards = Array.from(document.querySelectorAll('.user-card'));
                setupDragAndDrop();
            }

            // Configurar drag and drop para cada tarjeta de usuario
            function setupDragAndDrop() {
                allUserCards.forEach(card => {
                    card.addEventListener('dragstart', function(e) {
                        e.dataTransfer.setData('text/plain', '');
                        e.dataTransfer.effectAllowed = 'move';
                        this.style.opacity = '0.5';
                    });

                    card.addEventListener('dragend', function(e) {
                        this.style.opacity = '1';
                    });

                    card.addEventListener('click', function() {
                        const userId = this.dataset.userId;
                        const userName = this.dataset.userName;
                        const userCargo = this.dataset.userCargo;
                        const userDireccion = this.dataset.userDireccion;

                        if (!selectedUserIds.includes(userId)) {
                            addMemberToGroup(userId, userName, userCargo, userDireccion);
                            this.style.display = 'none';
                            updateAvailableCount();
                        }
                    });
                });
            }

            // Configurar zona de drop
            selectedMembers.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
                this.classList.add('border-violet-500', 'bg-violet-100', 'dark:bg-violet-800');
            });

            selectedMembers.addEventListener('dragleave', function(e) {
                this.classList.remove('border-violet-500', 'bg-violet-100', 'dark:bg-violet-800');
            });

            selectedMembers.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('border-violet-500', 'bg-violet-100', 'dark:bg-violet-800');

                // Encontrar la tarjeta que se está arrastrando
                const draggedCard = document.querySelector('.user-card[draggable="true"]:hover');
                if (draggedCard) {
                    const userId = draggedCard.dataset.userId;
                    const userName = draggedCard.dataset.userName;
                    const userCargo = draggedCard.dataset.userCargo;
                    const userDireccion = draggedCard.dataset.userDireccion;

                    if (!selectedUserIds.includes(userId)) {
                        addMemberToGroup(userId, userName, userCargo, userDireccion);
                        draggedCard.style.display = 'none';
                        updateAvailableCount();
                    }
                }
            });

            // Función de búsqueda
            userSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                let visibleCount = 0;

                allUserCards.forEach(card => {
                    const userName = card.dataset.userName.toLowerCase();
                    const userCargo = card.dataset.userCargo.toLowerCase();
                    const userDireccion = card.dataset.userDireccion.toLowerCase();

                    const isVisible = userName.includes(searchTerm) ||
                        userCargo.includes(searchTerm) ||
                        userDireccion.includes(searchTerm);

                    if (isVisible && !selectedUserIds.includes(card.dataset.userId)) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else if (!selectedUserIds.includes(card.dataset.userId)) {
                        card.style.display = 'none';
                    }
                });

                availableCount.textContent = visibleCount;
            });

            function addMemberToGroup(userId, userName, userCargo, userDireccion) {
                selectedUserIds.push(userId);

                const memberCard = document.createElement('div');
                memberCard.className =
                    'bg-white dark:bg-gray-600 border border-gray-200 dark:border-gray-500 rounded-lg p-2 mb-2 flex items-center justify-between';
                memberCard.dataset.userId = userId;

                memberCard.innerHTML = `
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                            ${userName}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 truncate">
                            ${userCargo}
                        </div>
                        <div class="text-xs text-gray-400 dark:text-gray-500 truncate">
                            ${userDireccion}
                        </div>
                    </div>
                    <button type="button" onclick="removeMember('${userId}')" 
                        class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 ml-2 flex-shrink-0">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                `;

                // Limpiar el mensaje de placeholder si es la primera vez
                if (selectedUserIds.length === 1) {
                    selectedMembers.innerHTML = '';
                }

                selectedMembers.appendChild(memberCard);
                updateMemberCount();
                updateMembersInput();
            }

            window.removeMember = function(userId) {
                selectedUserIds = selectedUserIds.filter(id => id !== userId);

                // Remover la tarjeta del DOM
                const memberCard = document.querySelector(`[data-user-id="${userId}"]`);
                if (memberCard) {
                    memberCard.remove();
                }

                // Mostrar la tarjeta en la lista de disponibles
                const userCard = document.querySelector(`.user-card[data-user-id="${userId}"]`);
                if (userCard) {
                    userCard.style.display = 'block';
                }

                // Mostrar mensaje de placeholder si no hay miembros
                if (selectedUserIds.length === 0) {
                    selectedMembers.innerHTML =
                        '<div class="text-center text-gray-500 dark:text-gray-400 text-sm h-full flex items-center justify-center">Arrastra usuarios aquí para agregarlos al grupo</div>';
                }

                updateMemberCount();
                updateAvailableCount();
                updateMembersInput();
            };

            function updateMemberCount() {
                memberCount.textContent = selectedUserIds.length;
            }

            function updateAvailableCount() {
                const visibleCards = allUserCards.filter(card =>
                    card.style.display !== 'none' && !selectedUserIds.includes(card.dataset.userId)
                );
                availableCount.textContent = visibleCards.length;
            }

            function updateMembersInput() {
                // Crear inputs ocultos para cada miembro
                const existingInputs = document.querySelectorAll('input[name="members[]"]');
                existingInputs.forEach(input => input.remove());

                selectedUserIds.forEach(userId => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'members[]';
                    input.value = userId;
                    document.querySelector('form').appendChild(input);
                });
            }

            // Validación del formulario
            document.querySelector('form').addEventListener('submit', function(e) {
                // Actualizar los inputs antes de enviar
                updateMembersInput();

                if (selectedUserIds.length === 0) {
                    e.preventDefault();
                    alert('Debe seleccionar al menos un miembro para el grupo.');
                    return false;
                }

                // Mostrar información de debug
                console.log('Enviando miembros:', selectedUserIds);
                console.log('Inputs ocultos:', document.querySelectorAll('input[name="members[]"]').length);
            });

            // Inicializar
            initializeUserCards();

            // Crear inputs iniciales para miembros existentes
            updateMembersInput();

            // Actualizar contadores iniciales
            updateMemberCount();
            updateAvailableCount();
        });
    </script>
</x-app-layout>
