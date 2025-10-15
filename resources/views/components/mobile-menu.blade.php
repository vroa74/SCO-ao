<!-- Menú Móvil Dropdown -->
<div class="lg:hidden" x-data="{ mobileMenuOpen: false }">
    <!-- Botón Hamburguesa -->
    <button @click="mobileMenuOpen = !mobileMenuOpen"
        class="text-gray-500 hover:text-gray-600 dark:hover:text-gray-400 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"
        aria-expanded="false" :aria-expanded="mobileMenuOpen">
        <span class="sr-only">Abrir menú</span>
        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <rect x="4" y="5" width="16" height="2" />
            <rect x="4" y="11" width="16" height="2" />
            <rect x="4" y="17" width="16" height="2" />
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        class="absolute top-full left-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50"
        x-cloak>
        <!-- Logo en el menú móvil -->
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                <div
                    class="w-8 h-8 bg-gradient-to-br from-violet-500 to-violet-600 rounded-lg flex items-center justify-center p-1">
                    <svg class="fill-red-400 dark:fill-green-300 w-full h-full" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 32 32">
                        <path
                            d="M31.956 14.8C31.372 6.92 25.08.628 17.2.044V5.76a9.04 9.04 0 0 0 9.04 9.04h5.716ZM14.8 26.24v5.716C6.92 31.372.63 25.08.044 17.2H5.76a9.04 9.04 0 0 1 9.04 9.04Zm11.44-9.04h5.716c-.584 7.88-6.876 14.172-14.756 14.756V26.24a9.04 9.04 0 0 1 9.04-9.04ZM.044 14.8C.63 6.92 6.92.628 14.8.044V5.76a9.04 9.04 0 0 1-9.04 9.04H.044Z" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-gray-800 dark:text-gray-100">Panel</span>
            </a>
        </div>

        <!-- Enlaces de navegación -->
        <nav class="p-2">
            <ul class="space-y-1">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ Route::is('dashboard') ? 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                        @click="mobileMenuOpen = false">
                        <svg class="w-4 h-4 mr-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                            <path
                                d="M8.707 7.293a1 1 0 0 0-1.414 0L3.05 11.536a1 1 0 0 0 1.414 1.414L8 9.414l3.536 3.536a1 1 0 0 0 1.414-1.414L8.707 7.293z" />
                            <path d="M8 4a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0V5a1 1 0 0 1 1-1z" />
                        </svg>
                        Dashboard
                    </a>
                </li>

                <!-- Usuarios -->
                <li>
                    <a href="{{ route('usuarios.index') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ Route::is('usuarios*') ? 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                        @click="mobileMenuOpen = false">
                        <svg class="w-4 h-4 mr-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                            <path
                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                        </svg>
                        Usuarios
                    </a>
                </li>

                <!-- QR -->
                <li>
                    <a href="{{ route('qr') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ Route::is('qr') ? 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                        @click="mobileMenuOpen = false">
                        <svg class="w-4 h-4 mr-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                            <path
                                d="M2 2h2v2H2V2zm4 0h2v2H6V2zm4 0h2v2h-2V2zm4 0h2v2h-2V2zM2 6h2v2H2V6zm4 0h2v2H6V6zm4 0h2v2h-2V6zm4 0h2v2h-2V6zM2 10h2v2H2v-2zm4 0h2v2H6v-2zm4 0h2v2h-2v-2zm4 0h2v2h-2v-2zM2 14h2v2H2v-2zm4 0h2v2H6v-2zm4 0h2v2h-2v-2zm4 0h2v2h-2v-2z" />
                        </svg>
                        QR
                    </a>
                </li>

                <!-- Agenda -->
                <li>
                    <a href="{{ route('agenda.index') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ Route::is('agenda*') ? 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                        @click="mobileMenuOpen = false">
                        <svg class="w-4 h-4 mr-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                            <path
                                d="M3.5 0a.5.5 0 0 1 .5.5V1h6V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                        </svg>
                        Agenda
                    </a>
                </li>

                <!-- Componentes -->
                <li>
                    <a href="{{ route('components') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ Route::is('components') ? 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                        @click="mobileMenuOpen = false">
                        <svg class="w-4 h-4 mr-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                            <path
                                d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.952-.433 2.48-.952 3.994-1.105 1.3-.13 2.728-.004 3.713.843a.5.5 0 0 0 .586 0z" />
                        </svg>
                        Componentes
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
