<nav x-init="initState" @scroll.window="initState" x-data="navState" id="main-nav" :class="navTheme" class="sticky top-0 left-0 right-0 z-50 bg-transparent group [&.nav-dark]:bg-brand-purple-500">
    <div id="nav" class="container sticky top-0 left-0 w-full py-2 mx-auto">
        <div class="relative flex items-center justify-between h-16">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <button @click="toggleMobileNav()" type="button"
                    class="inline-flex items-center justify-center p-2 rounded-md text-brand-purple-500 border border-brand-purple-500 group-[.nav-dark]:text-white active:text-white active:bg-brand-purple-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">{{ __('Open main menu') }}</span>
                    <svg class="block w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="hidden w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex items-center content-center justify-center flex-1 sm:items-stretch sm:justify-between">
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ route('home') }}" class="block nav-logo lg:hidden">
                        <img class="w-auto h-10 " :src="navTheme == 'nav-light' ? '{{ asset('img/logo/logo-dark.svg') }}':'{{ asset('img/logo/logo-light.svg') }}'" alt="Invits.co">
                    </a>
                    <a href="{{ route('home') }}" class="hidden nav-text-logo lg:block">
                        <img class="w-auto h-8 " :src="navTheme == 'nav-light' ? '{{ asset('img/logo/logo-with-text-dark.svg') }}':'{{ asset('img/logo/logo-with-text-light.svg') }}'"
                            alt="Invits.co">
                    </a>
                </div>
                <div class="hidden sm:block sm:ml-6">
                    <div class="flex space-x-4 text-gray-600 group-[.nav-dark]:text-white">
                        <a href="#paket"
                            class="px-3 py-2 text-base font-medium transition duration-300 ease-out border-b-2 border-transparent hover:border-brand-purple-500 group-[.nav-dark]:hover:border-white">
                            Paket
                        </a>
                        <a href="#portofolio"
                            class="px-3 py-2 text-base font-medium transition duration-300 ease-out border-b-2 border-transparent hover:border-brand-purple-500 group-[.nav-dark]:hover:border-white">
                            Portfolio
                        </a>
                        <a href="#tema"
                            class="px-3 py-2 text-base font-medium transition duration-300 ease-out border-b-2 border-transparent hover:border-brand-purple-500 group-[.nav-dark]:hover:border-white">
                            Tema
                        </a>
                        <a href="#fitur"
                            class="px-3 py-2 text-base font-medium transition duration-300 ease-out border-b-2 border-transparent hover:border-brand-purple-500 group-[.nav-dark]:hover:border-white">
                            Fitur
                        </a>
                    </div>
                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <div class="relative ml-3" x-data="{ isUserMenuOpen: false }">
                    <div class="flex items-center flex-row gap-2">
                        <x-button-a href="{{ route('order.index') }}"
                            class="invisible px-6 tracking-normal text-white capitalize transition-colors duration-200 transform !rounded-full bg-brand-purple-500 group-[.nav-dark]:border border-white hover:bg-brand-yellow-500 hover:text-black md:visible">
                            <span class="mx-1">Pesan Sekarang</span>
                        </x-button-a>
                        @if(session()->has('api_token'))
                        <button @click="isUserMenuOpen = !isUserMenuOpen" @keydown.escape="isUserMenuOpen = false"
                            type="button"
                            class="flex white w-10 h-10 text-sm transition duration-300 ease-out bg-gray-800 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-offset-cyan-800 focus:ring-white"
                            id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">{{ __('Open main menu') }}</span>
                            <img class=" border border-transparent rounded-full hover:border-cyan-600"
                                src="{{ asset(session('user.avatar') ?? 'img/default-avatar.jpg') }}" alt="User">
                        </button>
                        @else
                        <x-button-a href="{{ route('login') }}"
                            class="invisible px-6 tracking-normal capitalize transition-colors duration-200 transform bg-white !rounded-full ring-1 ring-black hover:ring-0 text-brand-purple-500 hover:text-black hover:bg-brand-yellow-500 md:visible">
                            <span class="mx-1">{{ __('Login') }}</span>
                        </x-button-a>
                        @endif
                    </div>

                    @if(session()->has('api_token'))
                    <div x-show="isUserMenuOpen" @click.away="isUserMenuOpen = false"
                        x-transition:enter="transition ease-out duration-100 transform"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75 transform"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            @if(session('user.role') == 'user')
                            <a href="{{ route('client.orders') }}"
                                class="block px-4 py-2 text-sm text-gray-600 hover:bg-brand-purple-500 hover:text-white"
                                role="menuitem">
                                <i class="fas fa-user fa-fw"></i>&nbsp;Client Area
                            </a>
                            @elseif(session('user.role') == 'admin')
                            <a href="{{ route('admin.index') }}"
                                class="block px-4 py-2 text-sm text-gray-600 hover:bg-brand-purple-500 hover:text-white"
                                role="menuitem">
                                <i class="fas fa-user fa-fw"></i>&nbsp;Dashboard Admin
                            </a>
                            @endif
                            <a href=""
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="block px-4 py-2 text-sm text-gray-600 hover:bg-brand-purple-500 hover:text-white"
                                role="menuitem">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>&nbsp;{{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                {{ csrf_field() }}
                            </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="absolute z-10 w-full p-1 sm:hidden" id="mobile-menu" x-show="showMobileNav"
        @click.away="showMobileNav = false" x-transition:enter="transition ease-out duration-100 transform"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75 transform" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5">
            <a href=""
                class="block px-3 py-2 text-base font-medium text-gray-500 rounded-md">
                Paket
            </a>
            <a href=""
                class="block px-3 py-2 text-base font-medium text-gray-500 rounded-md">
                Portfolio
            </a>
            <a href=""
                class="block px-3 py-2 text-base font-medium text-gray-500 rounded-md">
                Tema
            </a>
            <a href=""
                class="block px-3 py-2 text-base font-medium text-gray-500 rounded-md">
                Fitur
            </a>
    
            @if(session('user.role') == 'admin')
                <a href='{{ route('admin.index') }}'
                    class="block px-3 py-2 text-base font-medium text-gray-500 border rounded-md" role="menuitem">
                    <i class="fas fa-tachometer-alt fa-fw"></i>&nbsp;{{ __('Admin Dashboard') }}
                </a>
            @endif
    
            @guest
                <hr>
                <a href="{{ route('login') }}"
                    class="block px-3 py-2 mt-2 text-base font-medium rounded-md text-brand-purple-500 bg-brand-purple-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-6 h-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span class="mx-1">{{ __('Login') }}</span>
                </a>
            @endauth
        </div>
    </div>
</nav>

@push('after-javascript')
    <script>
        // const mainNav = document.getElementById("main-nav");
        // const nav = document.getElementById("nav");

        // document.addEventListener("scroll", () => {
        //     if (window.pageYOffset > 0) {
        //         nav.classList.add("nav-dark");
        //         nav.classList.remove("nav-light");

        //         mainNav.classList.add('bg-brand-purple-500');
        //     } else {
        //         nav.classList.remove("nav-dark");
        //         nav.classList.add("nav-light");

        //         mainNav.classList.remove('bg-brand-purple-500');
        //     }
        // });
    </script>
@endpush
