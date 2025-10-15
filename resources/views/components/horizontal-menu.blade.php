<!-- Menú Horizontal -->
<nav class="flex items-center space-x-2 xl:space-x-4">
    <!-- Logo del proyecto -->
    <a class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl shadow-lg hover:shadow-violet-500/25 transition-all duration-200 hover:scale-105 p-2"
        href="{{ route('dashboard') }}">
        <svg class="fill-red-400 dark:fill-green-300 w-full h-full transition-colors duration-200"
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
            <path
                d="M31.956 14.8C31.372 6.92 25.08.628 17.2.044V5.76a9.04 9.04 0 0 0 9.04 9.04h5.716ZM14.8 26.24v5.716C6.92 31.372.63 25.08.044 17.2H5.76a9.04 9.04 0 0 1 9.04 9.04Zm11.44-9.04h5.716c-.584 7.88-6.876 14.172-14.756 14.756V26.24a9.04 9.04 0 0 1 9.04-9.04ZM.044 14.8C.63 6.92 6.92.628 14.8.044V5.76a9.04 9.04 0 0 1-9.04 9.04H.044Z" />
        </svg>
    </a>
    <!-- Dashboard -->
    <a href="{{ route('dashboard') }}"
        class="flex items-center px-2 py-1.5 rounded-md text-xs font-medium transition-colors duration-200 {{ Route::is('dashboard') ? 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
        <svg class="w-3 h-3 mr-1.5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
            <path
                d="M8.707 7.293a1 1 0 0 0-1.414 0L3.05 11.536a1 1 0 0 0 1.414 1.414L8 9.414l3.536 3.536a1 1 0 0 0 1.414-1.414L8.707 7.293z" />
            <path d="M8 4a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0V5a1 1 0 0 1 1-1z" />
        </svg>
        <span class="hidden xl:inline">Dashboard</span>
    </a>

    <!-- Usuarios -->
    <a href="{{ route('usuarios.index') }}"
        class="flex items-center px-2 py-1.5 rounded-md text-xs font-medium transition-colors duration-200 {{ Route::is('usuarios*') ? 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
        <svg class="w-3 h-3 mr-1.5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
            <path
                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
        </svg>
        <span class="hidden xl:inline">Usuarios</span>
    </a>

    <!-- QR -->
    <a href="{{ route('qr') }}"
        class="flex items-center px-2 py-1.5 rounded-md text-xs font-medium transition-colors duration-200 {{ Route::is('qr') ? 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
        <svg class="w-3 h-3 mr-1.5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
            <path
                d="M2 2h2v2H2V2zm4 0h2v2H6V2zm4 0h2v2h-2V2zm4 0h2v2h-2V2zM2 6h2v2H2V6zm4 0h2v2H6V6zm4 0h2v2h-2V6zm4 0h2v2h-2V6zM2 10h2v2H2v-2zm4 0h2v2H6v-2zm4 0h2v2h-2v-2zm4 0h2v2h-2v-2zM2 14h2v2H2v-2zm4 0h2v2H6v-2zm4 0h2v2h-2v-2zm4 0h2v2h-2v-2z" />
        </svg>
        <span class="hidden xl:inline">QR</span>
    </a>

    <!-- Componentes -->
    <a href="{{ route('components') }}"
        class="flex items-center px-2 py-1.5 rounded-md text-xs font-medium transition-colors duration-200 {{ Route::is('components') ? 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
        <svg class="w-3 h-3 mr-1.5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
            <path
                d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.952-.433 2.48-.952 3.994-1.105 1.3-.13 2.728-.004 3.713.843a.5.5 0 0 0 .586 0z" />
        </svg>
        <span class="hidden xl:inline">Componentes</span>
    </a>
</nav>
