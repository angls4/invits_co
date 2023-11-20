@extends('client.layouts.app')

@section('content')   
<main class="grow">
    <form action="{{ route('client.profile.password.update', encode_id(session('user.id'))) }}" method="POST">
        @csrf
        <section class="bg-white">
            <div class="container py-8">
                <div class="text-center sm:text-start">
                    <h3 class="mb-0 text-xl font-medium">Ubah kata sandi</h3>
                    <p>Ubah kata sandi akun anda</p>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Kata sandi Lama</span>
                        @error('old_password')
                        <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>
                    <div class="sm:w-2/3">
                        <x-forms.input id="old_password" class="block w-full mt-1" type="password" name="old_password"
                            placeholder="Password" required />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Kata sandi Baru</span>
                        @error('new_password')
                        <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>
                    <div class="sm:w-2/3">
                        <x-forms.input id="new_password" class="block w-full mt-1" type="password" name="new_password"
                            placeholder="Password Baru" required />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Konfirmasi Kata sandi Baru</span>
                        @error('c_new_password')
                        <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>
                    <div class="sm:w-2/3">
                        <x-forms.input id="c_new_password" class="block w-full mt-1" type="password"
                            name="c_new_password" placeholder="Konfirmasi Password Baru" required />
                    </div>
                </div>
                <div class="flex justify-end gap-2 py-4 border-t border-gray-200">
                    <x-button-a type="button" href="{{ route('client.profile.index', encode_id(session('user.id'))) }}"
                        class="w-full py-3 tracking-wide capitalize transition-colors duration-200 transform bg-white sm:w-40 ring-1 ring-brand-purple-500 hover:ring-0 hover:text-black hover:bg-brand-yellow-500">
                        <span class="mx-1">Batal</span>
                    </x-button-a>
                    <x-button type="submit"
                        class="w-full py-3 tracking-wide text-white capitalize transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                        <span class="mx-1">Simpan</span>
                    </x-button>
                </div>
            </div>
        </section>
    </form>

</main>
@endsection