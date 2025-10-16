<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Contacto de Agenda') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <form method="POST" action="{{ route('agenda.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Título -->
                            <div>
                                <x-label for="titulo" value="{{ __('Título') }}" />
                                <x-input id="titulo" class="block mt-1 w-full" type="text" name="titulo"
                                    value="{{ old('titulo') }}" maxlength="5" />
                                <x-input-error for="titulo" class="mt-2" />
                            </div>

                            <!-- Nombre -->
                            <div>
                                <x-label for="nombre" value="{{ __('Nombre') }}" />
                                <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre"
                                    value="{{ old('nombre') }}" maxlength="30" />
                                <x-input-error for="nombre" class="mt-2" />
                            </div>

                            <!-- Apellido Paterno -->
                            <div>
                                <x-label for="apaterno" value="{{ __('Apellido Paterno') }}" />
                                <x-input id="apaterno" class="block mt-1 w-full" type="text" name="apaterno"
                                    value="{{ old('apaterno') }}" maxlength="30" />
                                <x-input-error for="apaterno" class="mt-2" />
                            </div>

                            <!-- Apellido Materno -->
                            <div>
                                <x-label for="amaterno" value="{{ __('Apellido Materno') }}" />
                                <x-input id="amaterno" class="block mt-1 w-full" type="text" name="amaterno"
                                    value="{{ old('amaterno') }}" maxlength="30" />
                                <x-input-error for="amaterno" class="mt-2" />
                            </div>

                            <!-- Cargo -->
                            <div>
                                <x-label for="cargo" value="{{ __('Cargo') }}" />
                                <x-input id="cargo" class="block mt-1 w-full" type="text" name="cargo"
                                    value="{{ old('cargo') }}" maxlength="30" />
                                <x-input-error for="cargo" class="mt-2" />
                            </div>

                            <!-- Departamento/Organización -->
                            <div>
                                <x-label for="deporg" value="{{ __('Departamento/Organización') }}" />
                                <x-input id="deporg" class="block mt-1 w-full" type="text" name="deporg"
                                    value="{{ old('deporg') }}" maxlength="60" />
                                <x-input-error for="deporg" class="mt-2" />
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <x-label for="telefono" value="{{ __('Teléfono') }}" />
                                <x-input id="telefono" class="block mt-1 w-full" type="text" name="telefono"
                                    value="{{ old('telefono') }}" maxlength="255" />
                                <x-input-error for="telefono" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-label for="email" value="{{ __('Email') }}" />
                                <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    value="{{ old('email') }}" maxlength="255" />
                                <x-input-error for="email" class="mt-2" />
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div>
                            <x-label for="dir" value="{{ __('Dirección') }}" />
                            <textarea id="dir" name="dir" rows="3"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-violet-500 dark:focus:border-violet-600 focus:ring-violet-500 dark:focus:ring-violet-600 rounded-md shadow-sm">{{ old('dir') }}</textarea>
                            <x-input-error for="dir" class="mt-2" />
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('agenda.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:bg-gray-400 dark:focus:bg-gray-500 active:bg-gray-500 dark:active:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Cancelar') }}
                            </a>
                            <x-button class="ml-3">
                                {{ __('Crear Contacto') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
