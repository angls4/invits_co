@extends('layouts.app')

@section('content')    
<section class="flex items-start h-auto py-10 grow">
    <div class="container">
        <div class="text-4xl font-bold text-center grow">
            Pusat Bantuan
        </div>
        <div class="mt-4 text-xl text-center from-neutral-600 grow">
            Punya pertanyaan? Kami siap membantu anda
        </div>
        <div class="flex flex-row items-center justify-center mx-auto mt-4">
            <div class="w-full sm:max-w-lg">
                <form>   
                    <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only ">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="search" id="search" class="block w-full p-3 pl-10 text-sm text-gray-900 border border-gray-300 rounded-2xl focus:ring-blue-500 focus:border-blue-500" placeholder="Search" required>
                        <button type="submit" class="absolute top-0 right-0 h-full px-6 py-2 text-sm font-medium text-white rounded-r-2xl bg-brand-purple-500 hover:bg-brand-yellow-500">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="grid gap-6 py-8 sm:grid-cols-2">
            <x-button-a href="{{ route('help.tac') }}" class="flex flex-col sm:flex-row items-center justify-center text-center gap-3 !p-8 rounded-lg bg-brand-purple-100">
                <i class="text-7xl fa-solid fa-file-circle-check"></i>
                <span class="text-2xl">
                    Terms and Condition
                </span>
            </x-button-a>
            <x-button-a href="{{ route('help.tac') }}" class="flex flex-col sm:flex-row items-center justify-center text-center gap-3 !p-8 rounded-lg bg-brand-purple-100">
                <i class="text-7xl fa-solid fa-file-shield"></i>                    
                <span class="text-2xl">
                    Privacy Policy
                </span>
            </x-button-a>
        </div>
        <div class="mt-8 text-3xl font-bold grow">
            Guide Aplikasi
        </div>
        <div class="grid gap-6 py-8 sm:grid-cols-2 lg:grid-cols-4">
            <x-button-a href="{{route('help.panduan-pemesanan')}}" class="aspect-square grid gap-3 !p-8 place-content-center place-items-center rounded-lg bg-brand-purple-100 "> 
                <i class="text-8xl fa-solid fa-cart-plus"></i>
                <span class="text-2xl text-center">
                    Melakukan Pemesanan
                </span>
            </x-button-a>
            <x-button-a href="{{route('help.panduan-pemesanan')}}" class="aspect-square grid gap-3 !p-8 place-content-center place-items-center rounded-lg bg-brand-purple-100 "> 
                <i class="text-8xl fa-solid fa-user-pen"></i>
                <span class="text-2xl text-center">
                    Mengubah Profil
                </span>
            </x-button-a>
            <x-button-a href="{{route('help.panduan-pemesanan')}}" class="aspect-square grid gap-3 !p-8 place-content-center place-items-center rounded-lg bg-brand-purple-100 "> 
                <i class="text-8xl fa-solid fa-users-gear"></i>
                <span class="text-2xl text-center">
                    Manajemen Tamu
                </span>
            </x-button-a>
            <x-button-a href="{{route('help.panduan-pemesanan')}}" class="aspect-square grid gap-3 !p-8 place-content-center place-items-center rounded-lg bg-brand-purple-100 "> 
                <i class="text-8xl fa-solid fa-envelope"></i>
                <span class="text-2xl text-center">
                    Membuat Undangan
                </span>
            </x-button-a>
        </div>
        <div class="my-8 text-3xl font-bold text-center grow">
            Sering Ditanyakan
        </div>
        <div>
            <div>
                <button onclick="this.classList.toggle('faqItem-cascaded')" class="flex items-center justify-between w-full py-3 mt-3 text-xl font-medium tracking-wide text-white rounded-t-lg text-start px-11 bg-brand-purple-500 focus:outline-none faqItem-cascaded">
                    <span>Berapa lama waktu pengerjaan website?</span><i class="text-white transition-transform fa-solid fa-chevron-up"></i>
                </button>
                <div class="py-3 text-base font-medium tracking-wide text-black rounded-b-lg bg-brand-purple-100 px-11">
                    <p>
                        Undangan dapat dibuat langsung setelah kamu melakukan pemesanan dengan mengisi data yang diperlukan di “Client Area”.
                    </p>
                </div>
            </div>
            <div>
                <button onclick="this.classList.toggle('faqItem-cascaded')" class="flex items-center justify-between w-full py-3 mt-3 text-xl font-medium tracking-wide text-white rounded-t-lg text-start px-11 bg-brand-purple-500 focus:outline-none faqItem-cascaded">
                    <span>Berapa lama batas pembayaran harus dilakukan?</span><i class="text-white transition-transform fa-solid fa-chevron-up"></i>
                </button>
                <div class="py-3 text-base font-medium tracking-wide text-black rounded-b-lg bg-brand-purple-100 px-11">
                    <p>
                        Batas pembayaran adalah 24 jam. Lebih dari itu, pemesanan akan dibatalkan.
                    </p>
                </div>
            </div>
        </div>
        {{-- <div class="mt-8 text-base font-bold text-center underline grow">
            <a href="javascript:void">Lihat lebih banyak</a>
        </div> --}}
    </div>
</section>
<div class="flex flex-col items-center justify-center py-16 mt-8 text-center bg-brand-purple-100 lg:flex-row lg:text-start">
    <img class="mx-24" src="/img/faq-question.svg" width=402 height=283 alt="image">
    <div class="flex flex-col items-center justify-center">
        <div class="mt-8 text-3xl font-bold text-center grow">
            Anda masih punya pertanyaan?
        </div>
        <div class="flex justify-center gap-4">
            <x-button-a href="#" class="w-12 h-12 py-3 mt-6 text-white bg-brand-purple-500 hover:text-black hover:bg-brand-yellow-500">
                <i class="text-3xl fa-brands fa-whatsapp"></i>
            </x-button-a>
            <x-button-a href="#" class="w-12 h-12 py-3 mt-6 text-white bg-brand-purple-500 hover:text-black hover:bg-brand-yellow-500">
                <i class="text-3xl fa-brands fa-instagram"></i>
            </x-button-a>
            <x-button-a href="#" class="w-12 h-12 py-3 mt-6 text-white bg-brand-purple-500 hover:text-black hover:bg-brand-yellow-500">
                <i class="text-3xl fa-regular fa-envelope"></i>
            </x-button-a>
        </div>
    </div>
</div>
@endsection