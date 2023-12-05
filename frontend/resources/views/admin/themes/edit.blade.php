@extends('client.layouts.app')

@section('content')
<main class="grow flex">
    <section class="self-stretch w-full bg-white">
        <form action="{{ route('admin.themes.update', encode_id($theme->id))}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container py-8">
                <div class="pb-4 text-center sm:text-start">
                    <h3 class="mb-0 text-xl font-medium">Edit Theme</h3>
                    <p>Update information about your theme.</p>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Paket</span>
                    </div>
                    <div class="sm:w-2/3">
                        <x-forms.select name="package_id" required>
                            <option disabled>Pilih Paket</option>
                            @foreach ($packages as $package)
                                <option value="{{ $package->id }}" :selected="$package->id == $theme->package_id">{{ $package->name }}</option>
                            @endforeach
                        </x-forms.select>
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Nama</span>
                    </div>
                    <div class="sm:w-2/3">
                        <x-forms.input type="text" name="name" value="{{ $theme->name }}" required
                            placeholder="Masukkan nama tema" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Harga</span>
                    </div>
                    <div class="sm:w-2/3">
                        <x-forms.input type="text" name="price" value="{{ $theme->price }}" placeholder="100000" pattern="\d+"
                            placeholder="Masukkan harga tema" required/>
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Deskripsi</span>
                    </div>
                    <div class="sm:w-2/3">
                        <x-forms.textarea row="3" name="description" value="{{ $theme->description }}" placeholder="Masukkan deskripsi tema" required>{{ $theme->description }}</x-forms.textarea>
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-semibold">Foto</span>
                    </div>
                    <div class="flex flex-col gap-3 sm:w-2/3 lg:flex-row">
                        <div class="max-w-xs lg:w-full">
                            <img class="object-cover w-full rounded aspect-square" src="{{ asset($theme->img_preview) }}" alt="">
                        </div>
                        <div class="lg:w-full">
                            <input name="img_preview" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50  file:bg-brand-purple-500 file:text-white file:rounded-md file:px-5 file:py-2 file:mr-5 file:rounded-r-none" id="file_input" type="file">
                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <x-button type="submit" class="text-white bg-brand-purple-500">
                        Ubah
                    </x-button>
                </div>
            </div>
        </form>
    </section>
</main>
@endsection