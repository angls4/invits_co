@extends('layouts.app')

@section('content')

<section class="flex items-center py-10">
    <div class="container">
        <div class="mx-auto w-fit">
            <h1 class="mt-0 mb-2 text-5xl font-medium leading-tight text-center">Pelayanan Terbaik Kami</h1>
            <div class="w-1/2 h-2 mx-auto rounded-md bg-brand-purple-500"></div>
        </div>
        <div class="grid gap-4 mt-8 xl:gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($data as $package)
            <a class="h-full" href="{{ route('order.theme', encode_id($package['id'])) }}"> 
                <div class="flex flex-col h-full bg-white rounded-lg shadow-lg hover:bg-brand-purple-500 hover:text-white hover:fill-white hover:shadow-xl">
                    <div class="px-6 py-3 text-center border-b border-gray-300 bg-[#B14BB0] text-white rounded-t-lg">
                        <h2 class="my-0 text-2xl font-medium leading-tight">{{ $package["name"] }}</h2>
                    </div>
                    <div class="flex-grow p-6">
                        <div class="flex justify-center gap-2">
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30"><path d="M243.8 339.8C232.9 350.7 215.1 350.7 204.2 339.8L140.2 275.8C129.3 264.9 129.3 247.1 140.2 236.2C151.1 225.3 168.9 225.3 179.8 236.2L224 280.4L332.2 172.2C343.1 161.3 360.9 161.3 371.8 172.2C382.7 183.1 382.7 200.9 371.8 211.8L243.8 339.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/></svg> --}}
                            <div>
                                {{-- <h3 class="my-0 text-lg font-bold leading-tight">Deskripsi 1</h3> --}}
                                <ul class="my-4 list-disc list-inside text-start">
                                    {!! $package["features"] !!}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-3 text-center border-t border-gray-300">
                        <h3 class="my-0 text-2xl font-medium leading-tight">{{ $package["price"] }}</h3>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="flex justify-end gap-2 mt-8">
            {{-- <x-button-a class="w-full py-3 tracking-wide transition-colors duration-200 transform bg-white sm:w-40 ring-1 ring-brand-purple-500" :disabled="true">
                <span class="mx-1">Prev</span>
            </x-button-a> --}}
            {{-- <x-button-a href="{{ route('order.theme') }}" class="w-full py-3 tracking-wide text-white transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                <span class="mx-1">Next</span>
            </x-button-a> --}}
        </div>
    </div>
</section>
@endsection

