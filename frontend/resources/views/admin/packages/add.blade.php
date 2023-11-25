@extends('client.layouts.app')

@section('content')
<main class="grow">
    <section class="h-full bg-white">
        <form action="{{ route('admin.packages.store')}}" method="post"
            x-data="data()">
            @csrf
            <div class="container py-8">
                <div class="pb-4 text-center sm:text-start">
                    <h3 class="mb-0 text-xl font-medium">Add Package</h3>
                    <p>Fill in information about your package.</p>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Nama</span>
                    </div>
                    <div class="sm:w-2/3">
                        <x-forms.input type="text" name="name" value="" x-model="form.name"
                            placeholder="Masukkan nama lengkap tamu" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Harga</span>
                    </div>
                    <div class="sm:w-2/3">
                        <x-forms.input type="text" name="price" value="" placeholder="100000" pattern="\d+"
                            placeholder="Masukkan nama lengkap tamu" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Deskripsi</span>
                    </div>
                    <div class="sm:w-2/3">
                        <x-forms.textarea row="3" name="description" value="" placeholder="Masukkan deskripsi paket" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Fitur</span>
                    </div>
                    <div class="flex flex-wrap gap-5 sm:w-2/3">
                        <div class="flex items-center gap-2">
                            <x-forms.checkbox id="fitur" name="features[]" value="Informasi Dasar Pernikahan" />
                            <x-forms.label class="!inline-block !m-0">Informasi Dasar Pernikahan</x-forms.label>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-forms.checkbox id="fitur" name="features[]" value="Gallery" />
                            <x-forms.label class="!inline-block !m-0">Gallery</x-forms.label>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-forms.checkbox id="fitur" name="features[]" value="Konfirmasi Kehadiran" />
                            <x-forms.label class="!inline-block !m-0">Konfirmasi Kehadiran</x-forms.label>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-forms.checkbox id="fitur" name="features[]" value="Love Stories" />
                            <x-forms.label class="!inline-block !m-0">Love Stories</x-forms.label>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-forms.checkbox id="fitur" name="features[]" value="Wishes & Gifts" />
                            <x-forms.label class="!inline-block !m-0">Wishes & Gifts</x-forms.label>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-forms.checkbox id="fitur" name="features[]" value="Save to Google Calendar" />
                            <x-forms.label class="!inline-block !m-0">Save to Google Calendar</x-forms.label>
                        </div>
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