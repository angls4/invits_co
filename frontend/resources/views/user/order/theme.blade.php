@extends('layouts.app')

@section('content') 
<section class="flex items-center py-10">
    <div class="container">
        <div class="mx-auto w-fit">
            <h1 class="mt-0 mb-2 text-5xl font-medium leading-tight text-center">Pelayanan Terbaik Kami</h1>
            <div class="w-1/2 h-2 mx-auto rounded-md bg-brand-purple-500"></div>
        </div>
        <div class="grid gap-4 mt-8 xl:gap-8 place-items-center place-content-between sm:grid-cols-2 lg:grid-cols-3">
            @for ($i = 0; $i < 3; $i++)
            <div class="bg-white rounded-lg shadow-lg">
                <a href="{{  route('order.summary', 1) }}" class="relative">
                    <img class="rounded-t-lg" src="{{ asset('img/themes/theme-gold.png') }}" alt=""/>
                    <div class="absolute bottom-0 left-0 w-full p-2 text-center bg-black opacity-60 text-brand-yellow-500">
                        Nama Tema
                    </div>
                </a>
                <div class="text-center">
                    <div class="flex gap-1.5 justify-center pt-5 pb-3">
                        {{-- <div class="bg-gray-200 rounded-full w-9 h-9"></div>
                        <div class="bg-gray-200 rounded-full w-9 h-9"></div>
                        <div class="bg-gray-200 rounded-full w-9 h-9"></div> --}}
                        <div>Rp100.000</div>
                    </div>
                    <div class="w-full py-3 text-base font-bold border-t rounded-b-lg text-brand-purple-500 border-t-neutral-200">
                        <span class="font-bold">Nama Tema</span> 
                    </div>
                </div>
            </div>
            @endfor
        </div>
        <div class="flex justify-end gap-2 mt-8">
            {{-- <x-button-a href="{{ route('order.index') }}" class="w-full py-3 tracking-wide transition-colors duration-200 transform bg-white sm:w-40 ring-1 ring-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                <span class="mx-1">Prev</span>
            </x-button-a> --}}
            {{-- <x-button-a href="{{ route('order.summary') }}" class="w-full py-3 tracking-wide text-white transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                <span class="mx-1">Next</span>
            </x-button-a> --}}
        </div>
    </div>
</section>
@endsection

