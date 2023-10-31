<div class="text-gray-700 bg-white border-b border-gray-300">
    <div class="container flex items-center py-3">
        <div x-show="!isOpen()" class="flex mr-3">
            <a
                x-show="!isOpen()"
                @click.prevent="handleOpen()"
                class="hover:text-brand-purple-500"
                href="#"
            >
                <svg
                    class="w-6 h-6"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>
            </a>
        </div>
        <div class="flex items-center justify-between flex-grow"> 
            <div
                class="text-xl font-bold"
            >
                <h3>{{ $title }}</h3>
            </div>
            @stack('header-actions')
        </div>
    </div>
</div>