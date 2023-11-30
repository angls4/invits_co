@extends('client.layouts.app')

@section('content')
<main class="grow flex">
    <section class="self-stretch w-full bg-white">
        <form action="{{ route('admin.themes.update', encode_id($theme->id))}}" method="post">
            @csrf
            <div class="container py-8">
                <div class="pb-4 text-center sm:text-start">
                    <h3 class="mb-0 text-xl font-medium">Edit Theme</h3>
                    <p>Update information about your theme.</p>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Nama</span>
                    </div>
                    <div class="sm:w-2/3">
                        <x-forms.input type="text" name="name" value="{{ $theme->name }}"
                            placeholder="Masukkan nama tema" required/>
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Harga</span>
                    </div>
                    <div class="sm:w-2/3">
                        <x-forms.input type="text" name="price" value="{{ $theme->price }}" placeholder="100000" pattern="\d+"
                            placeholder="Masukkan nama lengkap tamu" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Deskripsi</span>
                    </div>
                    <div class="sm:w-2/3">
                        <x-forms.textarea row="3" name="description" value="" placeholder="Masukkan deskripsi paket">{{ $theme->description }}</x-forms.textarea>
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Fitur</span>
                    </div>
                    <div class="flex flex-wrap gap-5 sm:w-2/3">
                        <div class="flex items-center gap-2">
                            <x-forms.checkbox id="fitur" name="features[]" value="Informasi Dasar Pernikahan" :checked="in_array('Informasi Dasar Pernikahan', $theme->features)"/>
                            <x-forms.label class="!inline-block !m-0">Informasi Dasar Pernikahan</x-forms.label>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-forms.checkbox id="fitur" name="features[]" value="Gallery" :checked="in_array('Gallery', $theme->features)"/>
                            <x-forms.label class="!inline-block !m-0">Gallery</x-forms.label>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-forms.checkbox id="fitur" name="features[]" value="Konfirmasi Kehadiran" :checked="in_array('Konfirmasi Kehadiran', $theme->features)"/>
                            <x-forms.label class="!inline-block !m-0">Konfirmasi Kehadiran</x-forms.label>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-forms.checkbox id="fitur" name="features[]" value="Love Stories" :checked="in_array('Love Stories', $theme->features)"/>
                            <x-forms.label class="!inline-block !m-0">Love Stories</x-forms.label>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-forms.checkbox id="fitur" name="features[]" value="Wishes & Gifts" :checked="in_array('Wishes & Gifts', $theme->features)"/>
                            <x-forms.label class="!inline-block !m-0">Wishes & Gifts</x-forms.label>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-forms.checkbox id="fitur" name="features[]" value="Save to Google Calendar" :checked="in_array('Save to Google Calendar', $theme->features)"/>
                            <x-forms.label class="!inline-block !m-0">Save to Google Calendar</x-forms.label>
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