@extends('layouts.app')

@section('content') 
    <section class="flex items-center h-screen -mt-[80px]">
        <div class="container flex items-center gap-4">
            <div class="w-full">
                <div>
                    <h1 class="mt-0 mb-2 text-5xl font-medium leading-tight">Rayakan Cinta Tanpa Batas dengan Keindahan Teknologi.</h1>
                    <p>Menghidupkan Cerita Cinta Anda melalui Sentuhan Digital yang Mempesona.</p>
                </div>
                <div class="flex flex-wrap items-center justify-between p-4 mt-12 text-center bg-brand-purple-100">
                    <div class="w-1/3 xl:flex xl:w-fit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="40" class="mx-auto fill-brand-purple-500">
                            <path d="M321.7 21.36c-43.2 0-86.4 16.5-119.4 49.5-19.1 19.08-32.6 41.54-40.7 65.44 16.9-2.4 32.9-2.7 48.7-1.1 3.9-5.5 8.3-10.7 13.2-15.6 23.3-23.26 53.8-34.9 84.4-34.9 30.6 0 61.2 11.64 84.5 34.9 46.6 46.6 46.6 122.4 0 168.9-46.5 46.6-122.4 46.6-168.9 0-22.2-22.2-33.9-51.1-34.9-80.2-11.5 1.8-22.8 5.6-33.2 11.4 5.8 33 21.4 64.5 46.9 90 66 66 172.9 66.1 238.9 0 66-66 66-172.8 0-238.84-33-33-76.3-49.5-119.5-49.5zM147.6 158.2c-27.9 7.7-58.94 25.4-76.75 44-47.5 47.4-60.8 116-40.1 175.3 8.91 24.1 23.56 47.1 40.1 63.6 66.05 66 172.95 66 238.95 0 19.1-19.1 32.6-41.6 40.7-65.5-16.2 2.5-32.6 2.9-48.8 1.2-3.8 5.4-8.2 10.6-13.1 15.5-62.7 39.7-137.8 40.6-173.3-4.4-20.57-26-32.05-58.8-30.55-85.8 2.58-41.6 26.85-79.9 57.75-98.5 10.2-5.9 37.6-15.1 61.6-15.1 33.7 1.5 60.6 11.1 84.5 34.9 22.3 22.1 33.8 51.1 34.8 80.3 11.6-1.8 22.9-5.6 33.3-11.4-9.4-41.6-26.9-73.2-53.9-96.7-21.4-18.7-44.1-31.4-70.6-37.6-28.4-7-58.6-6.5-84.6.2z"/>
                        </svg>
                        <div class="xl:ml-2">
                            <strong class="block text-2xl">1K+</strong>
                            <span class="text-sm">
                                Pernikahan    
                            </span>
                        </div>
                    </div>
                    <div class="w-1/3 xl:flex xl:w-fit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" width="40" class="mx-auto stroke-brand-purple-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>                      
                        <div class="xl:ml-2">
                            <strong class="block text-2xl">10K+</strong>
                            <span class="text-sm">
                                Tamu    
                            </span>
                        </div>
                    </div>
                    <div class="w-1/3 xl:flex xl:w-fit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" viewBox="0 0 16 16" class="mx-auto fill-brand-purple-500">
                            <path d="M3 2.5a2.5 2.5 0 0 1 5 0 2.5 2.5 0 0 1 5 0v.006c0 .07 0 .27-.038.494H15a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 1 14.5V7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h2.038A2.968 2.968 0 0 1 3 2.506V2.5zm1.068.5H7v-.5a1.5 1.5 0 1 0-3 0c0 .085.002.274.045.43a.522.522 0 0 0 .023.07zM9 3h2.932a.56.56 0 0 0 .023-.07c.043-.156.045-.345.045-.43a1.5 1.5 0 0 0-3 0V3zM1 4v2h6V4H1zm8 0v2h6V4H9zm5 3H9v8h4.5a.5.5 0 0 0 .5-.5V7zm-7 8V7H2v7.5a.5.5 0 0 0 .5.5H7z"/>
                        </svg>
                        <div class="xl:ml-2">
                            <strong class="block text-2xl">80K+</strong>
                            <span class="text-sm">
                                Hadiah    
                            </span>
                        </div>
                    </div>
                    <x-button-a href="" class="w-full py-4 mt-5 text-white transition-colors duration-200 transform bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black xl:w-fit xl:mt-0">Buat Undangan Anda</x-button-a>
                </div>
            </div>
            <div class="hidden w-full lg:block">
                <img src="{{asset('img/wedding.svg')}}" alt="" class="w-full mx-auto">
            </div>
        </div>
    </section>
@endsection

