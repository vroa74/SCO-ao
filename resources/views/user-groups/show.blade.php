<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles del Grupo') }}: {{ $userGroup->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <!-- Información del grupo -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Nombre del Grupo') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $userGroup->name }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Estado') }}</dt>
                            <dd class="mt-1">
                                <span
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full
                                    @if ($userGroup->is_active) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                    {{ $userGroup->is_active ? __('Activo') : __('Inactivo') }}
                                </span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Creado por') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $userGroup->creator->nombre }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('Fecha de creación') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $userGroup->created_at->format('d/m/Y H:i') }}
                            </dd>
                        </div>
                    </div>

                    <!-- Descripción -->
                    @if ($userGroup->description)
                        <div class="mb-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Descripción') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 whitespace-pre-line">
                                {{ $userGroup->description }}
                            </dd>
                        </div>
                    @endif

                    <!-- Miembros del grupo -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Miembros del Grupo') }} ({{ $userGroup->members_count }})
                            </h3>
                            @if ($userGroup->created_by === auth()->id())
                                <button onclick="openAddMemberModal()"
                                    class="inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-violet-600 hover:bg-violet-700 rounded-md transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    {{ __('Agregar Miembro') }}
                                </button>
                            @endif
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Usuario') }}
                                        </th>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Cargo') }}
                                        </th>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Rol') }}
                                        </th>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Fecha de ingreso') }}
                                        </th>
                                        @if ($userGroup->created_by === auth()->id())
                                            <th
                                                class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                {{ __('Acciones') }}
                                            </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($userGroup->activeGroupMembers as $member)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-3 py-2 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $member->user->nombre }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $member->user->email }}
                                                </div>
                                            </td>
                                            <td class="px-3 py-2 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $member->user->cargo ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-3 py-2 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full
                                                    @if ($member->role === 'admin') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                                    @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 @endif">
                                                    {{ $member->role === 'admin' ? __('Administrador') : __('Miembro') }}
                                                </span>
                                            </td>
                                            <td
                                                class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $member->created_at->format('d/m/Y') }}
                                            </td>
                                            @if ($userGroup->created_by === auth()->id())
                                                <td class="px-3 py-2 whitespace-nowrap text-sm font-medium">
                                                    <div class="flex space-x-1">
                                                        @if ($member->user_id !== auth()->id())
                                                            <!-- Cambiar rol -->
                                                            <button
                                                                onclick="changeRole({{ $member->id }}, '{{ $member->role }}')"
                                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30 rounded-md transition-colors"
                                                                title="{{ __('Cambiar Rol') }}">
                                                                <svg class="w-3 h-3" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4">
                                                                    </path>
                                                                </svg>
                                                            </button>

                                                            <!-- Remover miembro -->
                                                            <button
                                                                onclick="removeMember({{ $member->id }}, '{{ $member->user->nombre }}')"
                                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30 rounded-md transition-colors"
                                                                title="{{ __('Remover') }}">
                                                                <svg class="w-3 h-3" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('user-groups.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:bg-gray-400 dark:focus:bg-gray-500 active:bg-gray-500 dark:active:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Volver') }}
                        </a>
                        @if ($userGroup->created_by === auth()->id())
                            <a href="{{ route('user-groups.edit', $userGroup) }}"
                                class="inline-flex items-center px-4 py-2 bg-violet-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-violet-700 focus:bg-violet-700 active:bg-violet-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Editar Grupo') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar miembro -->
    <div id="addMemberModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Agregar Miembro') }}
                </h3>
                <form id="addMemberForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Seleccionar Usuario') }}
                        </label>
                        <select id="user_id" name="user_id" required
                            class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-violet-500 dark:focus:border-violet-600 focus:ring-violet-500 dark:focus:ring-violet-600 rounded-md shadow-sm">
                            <option value="">{{ __('Seleccionar...') }}</option>
                            <!-- Los usuarios se cargarán dinámicamente -->
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Rol') }}
                        </label>
                        <select id="role" name="role" required
                            class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-violet-500 dark:focus:border-violet-600 focus:ring-violet-500 dark:focus:ring-violet-600 rounded-md shadow-sm">
                            <option value="member">{{ __('Miembro') }}</option>
                            <option value="admin">{{ __('Administrador') }}</option>
                        </select>
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" onclick="closeAddMemberModal()"
                            class="flex-1 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md transition-colors">
                            {{ __('Cancelar') }}
                        </button>
                        <button type="submit"
                            class="flex-1 px-3 py-2 text-sm font-medium text-white bg-violet-600 hover:bg-violet-700 rounded-md transition-colors">
                            {{ __('Agregar') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openAddMemberModal() {
            document.getElementById('addMemberForm').action = '{{ route('user-groups.add-member', $userGroup) }}';
            document.getElementById('addMemberModal').classList.remove('hidden');
        }

        function closeAddMemberModal() {
            document.getElementById('addMemberModal').classList.add('hidden');
        }

        function changeRole(memberId, currentRole) {
            const newRole = currentRole === 'admin' ? 'member' : 'admin';
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('user-groups.update-member-role', $userGroup) }}';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';

            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PATCH';

            const userIdField = document.createElement('input');
            userIdField.type = 'hidden';
            userIdField.name = 'user_id';
            userIdField.value = memberId;

            const roleField = document.createElement('input');
            roleField.type = 'hidden';
            roleField.name = 'role';
            roleField.value = newRole;

            form.appendChild(csrfToken);
            form.appendChild(methodField);
            form.appendChild(userIdField);
            form.appendChild(roleField);

            document.body.appendChild(form);
            form.submit();
        }

        function removeMember(memberId, memberName) {
            if (confirm('¿Estás seguro de que quieres remover a ' + memberName + ' del grupo?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('user-groups.remove-member', $userGroup) }}';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                const userIdField = document.createElement('input');
                userIdField.type = 'hidden';
                userIdField.name = 'user_id';
                userIdField.value = memberId;

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                form.appendChild(userIdField);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</x-app-layout>
