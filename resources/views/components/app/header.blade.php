<header
    class="sticky top-0 before:absolute before:inset-0 before:backdrop-blur-md max-lg:before:bg-white/90 dark:max-lg:before:bg-gray-800/90 before:-z-10 z-30 {{ $variant === 'v2' || $variant === 'v3' ? 'before:bg-white after:absolute after:h-px after:inset-x-0 after:top-full after:bg-gray-200 dark:after:bg-gray-700/60 after:-z-10' : 'max-lg:shadow-xs lg:before:bg-gray-100/90 dark:lg:before:bg-gray-900/90' }} {{ $variant === 'v2' ? 'dark:before:bg-gray-800' : '' }} {{ $variant === 'v3' ? 'dark:before:bg-gray-900' : '' }}">
    <div class="px-4 sm:px-6 lg:px-8">
        <div
            class="flex items-center justify-between h-16 {{ $variant === 'v2' || $variant === 'v3' ? '' : 'lg:border-b border-gray-200 dark:border-gray-700/60' }}">

            <!-- Header: Left side -->
            <div class="flex items-center relative space-x-4">
                <!-- Menú Móvil -->
                <x-mobile-menu />

                <!-- Logo del proyecto (solo desktop) -->
                <div class="hidden lg:block">
                    <a class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl shadow-lg hover:shadow-violet-500/25 transition-all duration-200 hover:scale-105 p-2"
                        href="{{ route('dashboard') }}">
                        <svg class="fill-red-400 dark:fill-green-300 w-full h-full transition-colors duration-200"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                            <path
                                d="M31.956 14.8C31.372 6.92 25.08.628 17.2.044V5.76a9.04 9.04 0 0 0 9.04 9.04h5.716ZM14.8 26.24v5.716C6.92 31.372.63 25.08.044 17.2H5.76a9.04 9.04 0 0 1 9.04 9.04Zm11.44-9.04h5.716c-.584 7.88-6.876 14.172-14.756 14.756V26.24a9.04 9.04 0 0 1 9.04-9.04ZM.044 14.8C.63 6.92 6.92.628 14.8.044V5.76a9.04 9.04 0 0 1-9.04 9.04H.044Z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Header: Center -->
            <div class="flex items-center justify-center flex-1">
                <!-- Menú Horizontal con Logo (solo desktop) -->
                <div class="hidden lg:block">
                    <x-horizontal-menu />
                </div>
            </div>

            <!-- Header: Right side -->
            <div class="flex items-center space-x-3">

                <!-- Dark mode toggle -->
                <x-theme-toggle />

                <!-- Divider -->
                <hr class="w-px h-6 bg-gray-200 dark:bg-gray-700/60 border-none" />

                <!-- User button -->
                <x-dropdown-profile align="right" />

            </div>

        </div>
    </div>
</header>
