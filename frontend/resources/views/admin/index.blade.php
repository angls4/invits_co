@extends('client.layouts.app')

@section('content')   
<main class="py-6 bg-white grow">
    <div class="container grid gap-5 md:grid-cols-2 2xl:grid-cols-3">
        <div class="w-full border rounded-md border-brand-purple-300 flex">
            <div class="w-full flex items-center gap-4 p-2.5">
                <div class="grid rounded-md w-28 aspect-square place-items-center bg-brand-purple-500">
                    <i class="text-5xl text-white ph ph-package"></i>
                </div>
                <div class="border-b-md">
                    <h2 class="text-3xl text-brand-purple-500">{{ $data["packages"]->count() }}</h2>
                    <span class="uppercase">Total Packages</span>
                </div>
            </div>
            <x-button-a href="{{ route('admin.packages.index') }}" class="text-white !px-2 rounded-l-none bg-brand-purple-400 hover:bg-brand-purple-500"><i class="ph-bold ph-caret-right"></i></x-button>
        </div>
        <div class="w-full border rounded-md border-brand-purple-300 flex">
            <div class="flex items-center gap-4 p-2.5 w-full">
                <div class="grid rounded-md w-28 aspect-square place-items-center bg-brand-purple-500">
                    <i class="text-5xl text-white ph ph-palette"></i>
                </div>
                <div class="border-b-md">
                    <h2 class="text-3xl text-brand-purple-500">{{ $data["themes"]->count() }}</h2>
                    <span class="uppercase">Total Themes</span>
                </div>
            </div>
            <x-button-a href="{{ route('admin.themes.index') }}" class="text-white !px-2 rounded-l-none bg-brand-purple-400 hover:bg-brand-purple-500"><i class="ph-bold ph-caret-right"></i></x-button>
        </div>
        <div class="w-full border rounded-md border-brand-purple-300 flex">
            <div class="flex items-center gap-4 p-2.5 w-full">
                <div class="grid rounded-md w-28 aspect-square place-items-center bg-brand-purple-500">
                    <i class="text-5xl text-white ph ph-shopping-cart-simple"></i>
                </div>
                <div class="border-b-md">
                    <h2 class="text-3xl text-brand-purple-500">{{ $data["orders"]->count() }}</h2>
                    <span class="uppercase">Total Orders</span>
                </div>
            </div>
            <x-button-a href="{{ route('admin.orders') }}" class="text-white !px-2 rounded-l-none bg-brand-purple-400 hover:bg-brand-purple-500"><i class="ph-bold ph-caret-right"></i></x-button>
        </div>
        <div class="w-full border rounded-md border-brand-purple-300 flex">
            <div class="flex items-center gap-4 p-2.5 w-full">
                <div class="grid rounded-md w-28 aspect-square place-items-center bg-brand-purple-500">
                    <i class="text-5xl text-white ph ph-user"></i>
                </div>
                <div class="border-b-md">
                    <h2 class="text-3xl text-brand-purple-500">{{ $data["users"]->count() }}</h2>
                    <span class="uppercase">Total Users</span>
                </div>
            </div>
            <x-button-a href="{{ route('admin.users.index') }}" class="text-white !px-2 rounded-l-none bg-brand-purple-400 hover:bg-brand-purple-500"><i class="ph-bold ph-caret-right"></i></x-button>
        </div>
        <div class="w-full border rounded-md border-brand-purple-300">
            <div class="flex items-center gap-4 p-2.5">
                <div class="grid rounded-md w-28 aspect-square place-items-center bg-brand-purple-500">
                    <i class="text-5xl text-white ph ph-money"></i>
                </div>
                <div class="border-b-md">
                    <h2 class="text-3xl text-brand-purple-500">@rupiah($data["payments"])</h2>
                    <span class="uppercase">Total Income</span>
                </div>
            </div>
        </div>
    </div>
</main>
@push('before-scripts')
    @if (session()->has('success'))
        <script>alert("{{ session('success') }}")</script>
    @endif
@endpush
@endsection