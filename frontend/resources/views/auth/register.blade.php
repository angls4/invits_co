@extends('auth.layouts.app')

@section('header')
    <h1 class="mb-1 text-3xl font-bold">Daftar</h1>
    <p>Sudah punya akun? <a href=" {{ route('login') }} " class="font-bold ">Masuk!</a></p>
@endsection

@section('card-content')
    <!-- Validation Errors -->
    <x-auth.validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- First Name -->
        <div class="mt-4">
            <x-forms.input id="first_name" class="block w-full mt-1" type="text" name="first_name" :value="old('first_name')" placeholder="Nama Depan" required autofocus />
        </div>

        <!-- First Name -->
        <div class="mt-4">
            <x-forms.input id="last_name" class="block w-full mt-1" type="text" name="last_name" :value="old('last_name')" placeholder="Nama Belakang" required/>
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-forms.input id="mobile" class="block w-full mt-1" type="text" name="mobile" placeholder="No. Telepon" required />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-forms.input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" placeholder="Email" required />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-forms.input id="password" class="block w-full mt-1" type="password" name="password" placeholder="Password" required autocomplete="new-password" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-forms.input id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation" placeholder="Konfirmasi Password" required autocomplete="new-password" />
        </div>

        <div class="mt-4">
            <x-button class="block w-full font-bold bg-white hover:bg-gray-100 active:bg-gray-200">
                Daftar
            </x-button>
        </div>
    </form>

    <!-- Social login -->
    <x-auth.social-login />
@endsection