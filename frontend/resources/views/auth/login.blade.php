@extends('auth.layouts.app')

@section('header')
    <h1 class="mb-1 text-3xl font-bold">Masuk</h1>
    <p>Belum punya akun? <a href="{{ route('register') }}" class="font-bold ">Daftar Sekarang!</a></p>
@endsection

@section('card-content')
    <!-- Session Status -->
    <x-auth.session-status class="mb-4" :status="session('status')" />
    
    <!-- Validation Errors -->
    <x-auth.validation-errors class="mb-4" :errors="$errors" />
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
    
        <!-- Email Address -->
        <div>
            <x-forms.input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" placeholder="Email" required />
        </div>
    
        <!-- Password -->
        <div class="mt-4">
            <x-forms.input id="password" class="block w-full mt-1" type="password" name="password" placeholder="Password" required autocomplete="current-password" />
        </div>
    
        <!-- Remember Me -->
        <div class="flex justify-between mt-4">
            @if (Route::has('password.request'))
            <a class="text-sm" href="">Lupa Password?</a>
            @endif
    
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="text-indigo-600 border border-gray-300 rounded shadow-sm focus:border-brand-purple-500 focus:outline-none" name="remember_me">
                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
            </label>
        </div>
    
        <div class="mt-4">
            <x-button class="block w-full font-bold bg-white hover:bg-brand-purple-500 hover:text-white active:bg-brand-purple-600">
                Masuk
            </x-button>
        </div>
    </form>
    
    <!-- Social Login -->
    <x-auth.social-login />
@endsection
