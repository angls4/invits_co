<section id="portfolio" class="py-10">
    <div class="container">
        <div class="relative w-full glide-portfolio">
            <div class="items-end justify-between mb-5 md:flex">
                <div>
                    <span>Our Portfolio</span>
                    <h2 class="my-0 text-4xl font-medium leading-tight">Mari Lihat Klien Kami Sebelumnya</h2>
                </div>
                <div class="flex gap-2 glide__arrows" data-glide-el="controls">
                    <button class="flex p-5 rounded-full glide__arrow glide__arrow--left bg-brand-purple-100 place-items-center" data-glide-dir="<">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-6 h-6"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
                    </button>
                    <button class="flex p-5 rounded-full glide__arrow glide__arrow--right bg-brand-purple-100 place-items-center" data-glide-dir=">">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-6 h-6"><path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"/></svg>
                    </button>
                </div>
            </div>
            <div class="w-full mt-8">
                <div class="overflow-hidden glide__track " data-glide-el="track">
                    <ul class="list-none glide__slides relative w-full overflow-hidden p-0 whitespace-no-wrap flex flex-no-wrap [backface-visibility: hidden] [transform-style: preserve-3d] [touch-action: pan-Y] [will-change: transform]">
                        <li class="glide__slide py-2.5">
                            <div class="flex flex-col h-full bg-white rounded-lg shadow-lg">
                                <a href="#!">
                                    <img class="rounded-t-lg" src="{{asset('img/themes/theme-bronze.png')}}" alt=""/>
                                </a>
                                <div class="flex flex-col items-start h-full p-6">
                                    <h5 class="mb-2 text-xl font-medium text-gray-900">Rudi & Ani</h5>
                                    <p class="flex-grow mb-4 text-base text-gray-700">
                                        Undangan paket Bronze dengan tema Basic White.
                                    </p>
                                    {{-- <x-button-a type="button" class="px-8 py-2 m-0 tracking-wide text-white transition-colors duration-200 transform bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">Button</x-button-a> --}}
                                </div>
                            </div>
                        </li>
                        <li class="glide__slide py-2.5">
                            <div class="flex flex-col h-full bg-white rounded-lg shadow-lg">
                                <a href="#!">
                                    <img class="rounded-t-lg" src="{{asset('img/themes/theme-silver.png')}}" alt=""/>
                                </a>
                                <div class="flex flex-col items-start h-full p-6">
                                    <h5 class="mb-2 text-xl font-medium text-gray-900">Rina & Dika</h5>
                                    <p class="flex-grow mb-4 text-base text-gray-700">
                                        Undangan paket Silver dengan tema Lego.
                                    </p>
                                    {{-- <x-button-a type="button" class="px-8 py-2 m-0 tracking-wide text-white transition-colors duration-200 transform bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">Button</x-button-a> --}}
                                </div>
                            </div>
                        </li>
                        <li class="glide__slide py-2.5">
                            <div class="flex flex-col h-full bg-white rounded-lg shadow-lg">
                                <a href="#!">
                                    <img class="rounded-t-lg" src="{{asset('img/themes/theme-bronze.png')}}" alt=""/>
                                </a>
                                <div class="flex flex-col items-start h-full p-6">
                                    <h5 class="mb-2 text-xl font-medium text-gray-900">Calvin & Nanda</h5>
                                    <p class="flex-grow mb-4 text-base text-gray-700">
                                        Undangan paket Bronze dengan tema Basic White.
                                    </p>
                                    {{-- <x-button-a type="button" class="px-8 py-2 m-0 tracking-wide text-white transition-colors duration-200 transform bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">Button</x-button-a> --}}
                                </div>
                            </div>
                        </li>
                        <li class="glide__slide py-2.5">
                            <div class="flex flex-col h-full bg-white rounded-lg shadow-lg">
                                <a href="#!">
                                    <img class="rounded-t-lg" src="{{asset('img/themes/theme-gold.png')}}" alt=""/>
                                </a>
                                <div class="flex flex-col items-start h-full p-6">
                                    <h5 class="mb-2 text-xl font-medium text-gray-900">Wafi & Manda</h5>
                                    <p class="flex-grow mb-4 text-base text-gray-700">
                                        Undangan paket Gold dengan tema Basic Luxury Flower.
                                    </p>
                                    {{-- <x-button-a type="button" class="px-8 py-2 m-0 tracking-wide text-white transition-colors duration-200 transform bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">Button</x-button-a> --}}
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@push('after-javascript')
<script>
    var glidePortfolio = new Glide('.glide-portfolio', {
        type: 'carousel',
        perView: 4,
        breakpoints: {
            640: {
                perView: 1
            },
            1024: {
                perView: 2
            }
        },
        autoplay: 3500,
        animationDuration: 700,
        gap: 16,
    });

    glidePortfolio.mount();
</script>
@endpush