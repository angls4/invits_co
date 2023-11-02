@extends('layouts.app')

@section('content')    
<section class="flex items-center py-10">
    <div class="container">
        <div class="mx-auto w-fit">
            <h1 class="mt-0 mb-2 text-5xl font-medium leading-tight text-center">Ringkasan Pemesanan</h1>
            <div class="w-1/2 h-2 mx-auto rounded-md bg-brand-purple-500"></div>
        </div>
        <div class="py-5 mt-8 rounded-md px-7 bg-brand-purple-100">
            <div>
                <strong>Pilihan Paket</strong>
                <div>
                    <p class="mb-1">{{ $package["name"] }}</p>
                </div>
            </div>
            <div>
                <strong>Pilihan Tema</strong>
                <div>
                    <p class="mb-1">{{ $theme["name"] }}</p>
                </div>
            </div>
        </div>
        {{-- <div class="mt-5" x-data="{open: false}">
            <div class="flex gap-3 py-4 rounded-md px-7 bg-brand-purple-100" :class="open && 'rounded-b-none border-b border-gray-400'" @click="open = !open">
                <div class="flex justify-between grow">
                    <strong>Metode Pembayaran</strong>
                    <img src="{{asset('img/bca.svg')}}" alt="" class="w-12">
                </div>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="15" :class="open && 'rotate-180'"><path d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z"/></svg>
                </span>
            </div>
            <div class="py-6 rounded-b-md px-7 bg-brand-purple-100" x-show="open">
                <div class="mb-5">
                    <p class="font-bold">Transfer Bank</p>
                    <div class="flex gap-4">
                        <img src="{{asset('img/bca.svg')}}" alt="" class="w-20">
                        <img src="{{asset('img/bca.svg')}}" alt="" class="w-20">
                        <img src="{{asset('img/bca.svg')}}" alt="" class="w-20">
                    </div>
                </div>
                <div>
                    <p class="font-bold">Transfer E-Wallet</p>
                    <div class="flex gap-4">
                        <img src="{{asset('img/bca.svg')}}" alt="" class="w-20">
                        <img src="{{asset('img/bca.svg')}}" alt="" class="w-20">
                        <img src="{{asset('img/bca.svg')}}" alt="" class="w-20">
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="flex flex-col justify-between py-4 mt-5 font-bold rounded-md px-7 sm:flex-row bg-brand-purple-100">
            <span>Total</span>
            <span>@rupiah($theme["price"])</span>
            {{-- <span>@rupiah(10000)</span> --}}
        </div>
        <div class="flex justify-end gap-2 mt-8">
            {{-- <x-button-a href="{{ route('order.theme') }}" class="w-full py-3 tracking-wide transition-colors duration-200 transform bg-white sm:w-40 ring-1 ring-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                <span class="mx-1">Prev</span>
            </x-button-a> --}}
            <x-button-a href="{{ route('order.checkout', encode_id($theme['id'])) }}" class="w-full py-3 tracking-wide text-white transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                <span class="mx-1">Buat Undangan</span>
            </x-button-a>

            {{-- <form action="{{route('order.checkout')}}" method="post">
                @csrf
                <input type="hidden" name="theme_id" value={{ encode_id($data['theme']->id) }}>
                <button type="submit" class="w-full py-3 tracking-wide text-white transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                    <span class="mx-1">Buat Undangan</span>
                </button>
            </form> --}}
        </div>
    </div>
</section>
@endsection
