@extends('client.layouts.app')

@section('content')
<main class="grow flex">
    <section class="self-stretch w-full bg-white">
        <form action="{{ route('admin.themes.store')}}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="container py-8">
                <div class="pb-4 text-center sm:text-start">
                    <h3 class="mb-0 text-xl font-medium">Add Theme</h3>
                    <p>Fill in information about your theme.</p>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Paket</span>
                    </div>
                    <div class="sm:w-2/3">
                        <x-forms.select name="package_id" :value="old('material')" required>
                            <option selected disabled>Pilih Paket</option>
                            @foreach ($packages as $package)
                                <option value="{{ $package->id }}">{{ $package->name }}</option>
                            @endforeach
                        </x-forms.select>
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Nama</span>
                    </div>
                    <div class="sm:w-2/3">
                        <x-forms.input type="text" name="name" value="" required
                            placeholder="Masukkan nama tema" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Harga</span>
                    </div>
                    <div class="sm:w-2/3">
                        <x-forms.input type="text" name="price" value="" placeholder="100000" pattern="\d+"
                            placeholder="Masukkan harga tema" required/>
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Deskripsi</span>
                    </div>
                    <div class="sm:w-2/3">
                        <x-forms.textarea row="3" name="description" value="" placeholder="Masukkan deskripsi tema" required/>
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-semibold">Foto</span>
                    </div>
                    <div class="flex flex-col gap-3 sm:w-2/3 lg:flex-row">
                        <input name="img_preview" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50  file:bg-brand-purple-500 file:text-white file:rounded-md file:px-5 file:py-2 file:mr-5 file:rounded-r-none" id="file_input" type="file" required>
                    </div>
                </div>  
                <div class="flex justify-end">
                    <x-button type="submit" class="text-white bg-brand-purple-500">
                        Add
                    </x-button>
                </div>
            </div>
        </form>
    </section>
</main>
@endsection