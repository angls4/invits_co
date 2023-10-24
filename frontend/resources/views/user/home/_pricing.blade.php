<section id="paket" class="py-10 bg-brand-purple-100">
    <div class="container">
        <div class="mx-auto w-fit">
            <h2 class="mt-0 mb-2 text-4xl font-medium leading-tight text-center">Pilih Paket Terbaikmu</h2>
            <div class="w-1/2 h-2 mx-auto rounded-md bg-brand-purple-500"></div>
        </div>
        <div class="flex gap-3 mt-5">
            <button id="prev">
                <svg width="26" height="35" viewBox="0 0 26 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M24.7733 33.9767C24.53 34.1033 24.265 34.1667 24 34.1667C23.6667 34.1667 23.3367 34.0667 23.0517 33.87L1.38499 18.87C0.93499 18.5583 0.666656 18.0467 0.666656 17.5C0.666656 16.9533 0.93499 16.4417 1.38499 16.13L23.0517 1.13C23.56 0.776668 24.2267 0.735002 24.7733 1.02334C25.3233 1.31167 25.6667 1.88 25.6667 2.5V32.5C25.6667 33.12 25.3233 33.6883 24.7733 33.9767ZM22.3333 5.68167L5.26166 17.5L22.3333 29.3183V5.68167Z" fill="#692BE2"/>
                </svg>
            </button>
            <div class="w-full min-w-0">
                <div class="relative w-full glide-package">
                    <div class="overflow-hidden glide__track" data-glide-el="track">
                        <ul class="list-none glide__slides relative w-full overflow-hidden p-0 whitespace-no-wrap flex flex-no-wrap [backface-visibility: hidden] [transform-style: preserve-3d] [touch-action: pan-Y] [will-change: transform] text-center">
                            @for ($i = 0; $i < 3; $i++)
                            <li class="py-2.5 glide__slide">
                                <div class="flex flex-col items-center justify-between h-full p-6 bg-white rounded-lg shadow-lg">
                                    <div>
                                        <h5 class="mb-3 text-2xl font-bold text-gray-900">Nama Paket</h4>
                                        <div>
                                            <span class="block text-xs">Mulai Dari</span>
                                            <span class="text-xl font-semibold text-brand-yellow-600">Rp100.000</span>
                                        </div>
                                        {{-- <div>{{ $package->description }}</div> --}}
                                        <ul class="my-4 text-center">
                                            @for ($j = 0; $j < 3; $j++)
                                            <li>Fitur {{ $j }}</li>
                                            @endfor
                                        </ul>
                                    </div>
                                    <x-button-a href="" type="button" class="inline-block px-10 py-2.5 text-white bg-brand-purple-500 font-medium text-xs rounded-full hover:bg-brand-purple-100 focus:bg-brand-purple-100 active:bg-brand-purple-100 mt-4">Pilih</x-button-a>
                                </div>
                            </li>
                            @endfor
                        </ul>
                    </div>
                </div>
            </div>
            <button id="next">
                <svg width="26" height="35" viewBox="0 0 26 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.22662 33.9767C1.46995 34.1033 1.73495 34.1667 1.99995 34.1667C2.33328 34.1667 2.66328 34.0667 2.94828 33.87L24.6149 18.87C25.0649 18.5583 25.3333 18.0467 25.3333 17.5C25.3333 16.9533 25.0649 16.4417 24.6149 16.13L2.94828 1.13C2.43995 0.776668 1.77328 0.735002 1.22662 1.02334C0.676615 1.31167 0.333282 1.88 0.333282 2.5V32.5C0.333282 33.12 0.676615 33.6883 1.22662 33.9767ZM3.66662 5.68167L20.7383 17.5L3.66662 29.3183V5.68167Z" fill="#692BE2"/>
                </svg>
            </button>
        </div>
    </div>
</section>

@push('after-javascript')
<script>
    var glidePackage = new Glide('.glide-package', {
        type: 'carousel',
        perView: 3,
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
    
    var nextButton = document.querySelector('#next');
    var prevButton = document.querySelector('#prev');

    nextButton.addEventListener('click', function (event) {
    event.preventDefault();

    glidePackage.go('>');
    })

    prevButton.addEventListener('click', function (event) {
    event.preventDefault();

    glidePackage.go('<');
    })

    glidePackage.mount();
</script>
@endpush