<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ver Contacto de Agenda') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <!-- Información del contacto -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Título -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Título') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $agenda->titulo ?? '-' }}
                            </dd>
                        </div>

                        <!-- Nombre Completo -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Nombre Completo') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ trim($agenda->nombre . ' ' . $agenda->apaterno . ' ' . $agenda->amaterno) ?: '-' }}
                            </dd>
                        </div>

                        <!-- Cargo -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Cargo') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $agenda->cargo ?? '-' }}
                            </dd>
                        </div>

                        <!-- Departamento/Organización -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('Departamento/Organización') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $agenda->deporg ?? '-' }}
                            </dd>
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Teléfono') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                @if ($agenda->telefono)
                                    <a href="tel:{{ $agenda->telefono }}"
                                        class="text-violet-600 hover:text-violet-500">
                                        {{ $agenda->telefono }}
                                    </a>
                                @else
                                    -
                                @endif
                            </dd>
                        </div>

                        <!-- Email -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Email') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                @if ($agenda->email)
                                    <a href="mailto:{{ $agenda->email }}"
                                        class="text-violet-600 hover:text-violet-500">
                                        {{ $agenda->email }}
                                    </a>
                                @else
                                    -
                                @endif
                            </dd>
                        </div>

                        <!-- Modificado por -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Modificado por') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $agenda->modifico ?? '-' }}
                            </dd>
                        </div>

                        <!-- Fecha de creación -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('Fecha de creación') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $agenda->created_at->format('d/m/Y H:i') }}
                            </dd>
                        </div>
                    </div>

                    <!-- Dirección -->
                    @if ($agenda->dir)
                        <div class="mt-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Dirección') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 whitespace-pre-line">
                                {{ $agenda->dir }}
                            </dd>
                        </div>
                    @endif

                    <!-- Botones de acción -->
                    <div class="flex items-center justify-end space-x-3 mt-8">
                        <a href="{{ route('agenda.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:bg-gray-400 dark:focus:bg-gray-500 active:bg-gray-500 dark:active:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Volver') }}
                        </a>
                        <a href="{{ route('agenda.edit', $agenda) }}"
                            class="inline-flex items-center px-4 py-2 bg-violet-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-violet-700 focus:bg-violet-700 active:bg-violet-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Editar') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
