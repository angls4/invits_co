@extends('client.layouts.app')

@section('content')

@php
    $alpineData = "formData";
    $phpData = $data['order']->invitation->id;
@endphp

@push('header-actions')
<div>
    <x-button-a href="" type="button" target="_blank"
        class="w-full py-3 tracking-wide text-white capitalize transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
        <span class="font-extrabold">Pratinjau</span>
    </x-button>
</div>
@endpush

<main class="grow">
    @if(session()->has('success'))
     <script>alert("{{session('success')}}")</script>   
    @endif
    <form action="{{ route("client.save.editInvitation", $data['order']->id) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <section class="bg-white">
            <div class="container py-8">
                <div class="text-center sm:text-start">
                    <h3 class="mb-0 text-xl font-medium">Invitation</h3>
                    <p>General information of your invitation.</p>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Order ID</span>
                    </div>
                    <div class="sm:w-2/3">
                        <input type="text" name="order_id" value="{{ $data['order']->id }}"
                            class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                            placeholder="Masukkan Order ID" :disabled="true"
                            :class="edit == false && 'bg-neutral-100 '" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Type</span>
                    </div>
                    <div class="sm:w-2/3">
                        <input type="text" name="status" value="{{ $data['order']->invitation->type->type }}"
                        
                            class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                            placeholder="Wedding / Birthday / Event" :disabled="true"
                            :class="edit == false && 'bg-neutral-100 '" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Tanggal Pemesanan</span>
                    </div>
                    <div class="sm:w-2/3">
                        <input type="date" name="created_at"
                            value="{{ \Carbon\Carbon::parse($data['order']->created_at)->toDateString() }}"
                            class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                            placeholder="Masukkan Tanggal Pemesanan" :disabled="true"
                            :class="edit == false && 'bg-neutral-100 '" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Paket</span>
                    </div>
                    <div class="sm:w-2/3">
                        <input type="text" name="package_name" value="{{ $data['order']->package->name }}"
                        
                            class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                            placeholder="Masukkan Nama Paket" :disabled="true"
                            :class="edit == false && 'bg-neutral-100 '" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Tema</span>
                    </div>
                    <div class="sm:w-2/3">
                        <input type="text" name="theme_name" value="{{ $data['order']->theme->name }}"
                            class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                            placeholder="Masukkan Nama Tema" :disabled="true"
                            :class="edit == false && 'bg-neutral-100 '" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Status</span>
                    </div>
                    <div class="sm:w-2/3">
                        <input type="text" name="status" value="{{ $data['order']->invitation->status }}"
                        
                            class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                            placeholder="Status Undangan" :disabled="true"
                            :class="edit == false && 'bg-neutral-100 '" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Slug</span>
                    </div>
                    <div class="sm:w-2/3">
                        <input type="text" name="slug" value="{{ $data['order']->invitation->slug }}"
                        
                            class="inline-block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                            placeholder="Ex: bride-groom" :disabled="edit ? false : true"
                            :class="edit == false && 'bg-neutral-100 '" />
                    </div>
                </div>
                {{-- CUSTOM DOMAIN --}}
                {{-- <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Custom Domain</span>
                    </div>
                    <div class="sm:w-2/3">
                        <select name="is_custom_domain"
                            class=" border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            :disabled="edit ? false : true"
                            :class="edit == false && 'bg-neutral-100 '">
                            <option selected value="true">Yes</option>
                            <option value="false">No</option>
                        </select>
                        <input type="text" name="custom_domain" value="wafi-manda.com"
                            class="mt-1.5 sm:mt-4 block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                            placeholder="Ex: bride-groom.com" :disabled="edit ? false : true"
                            :class="edit == false && 'bg-neutral-100 '" />
                    </div>
                </div> --}}
            </div>
        </section>
        <section class="bg-white">
            <div class="container py-8">
                <div class="text-center sm:text-start">
                    <h3 class="mb-0 text-xl font-medium">Wedding</h3>
                    <p>General information about the wedding.</p>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Judul</span>
                    </div>
                    <div class="sm:w-2/3">
                        <input type="text" name="title" value="{{ $data['order']->invitation->wedding->title }}"
                        
                            class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                            placeholder="Masukkan Judul Undangan" :disabled="edit ? false : true"
                            :class="edit == false && 'bg-neutral-100 '" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Lokasi</span>
                    </div>
                    <div class="sm:w-2/3">
                        <input type="text" name="location"
                            value="{{ $data['order']->invitation->wedding->location }}"
                            class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                            placeholder="Masukkan Lokasi Resepsi" :disabled="edit ? false : true"
                            :class="edit == false && 'bg-neutral-100 '" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Link Lokasi (Google Maps)</span>
                    </div>
                    <div class="sm:w-2/3">
                        <input type="text" name="location_gmap"
                            value="{{ $data['order']->invitation->wedding->location_gmap }}"
                            class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                            placeholder="Ex: https://goo.gl/maps/W7cH6dNi7JLXt2jG7"
                            :disabled="edit ? false : true"
                            :class="edit == false && 'bg-neutral-100 '" />
                    </div>
                </div>
                @if($data['order']->package->name == 'Gold')
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">No Rekening</span>
                    </div>
                    <div class="sm:w-2/3">
                        <input type="text" name="rekening_gift"
                            value="{{ $data['order']->invitation->wedding->rekening_gift }}"
                            class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                            placeholder="Masukkan Rekening Untuk Hadiah Digital" :disabled="edit ? false : true"
                            :class="edit == false && 'bg-neutral-100 '" />
                    </div>
                </div>
                @endif
            </div>
        </section>
        <section class="bg-white">
            <div class="container py-8">
                <div class="text-center sm:text-start">
                    <h3 class="mb-0 text-xl font-medium">Groom</h3>
                    <p>Information about the Groom.</p>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Nama</span>
                    </div>
                    <div class="sm:w-2/3">
                        <input type="text" name="groom_name"
                            value="{{ $data['order']->invitation->wedding->groom->name }}"
                            class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                            placeholder="Masukkan Nama Pengantin Pria" :disabled="edit ? false : true"
                            :class="edit == false && 'bg-neutral-100 '" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Ayah</span>
                    </div>
                    <div class="sm:w-2/3">
                        <input type="text" name="groom_father"
                            value="{{ $data['order']->invitation->wedding->groom->father }}"
                            class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                            placeholder="Masukkan Nama Ayah Pengantin Pria"
                            :disabled="edit ? false : true"
                            :class="edit == false && 'bg-neutral-100 '" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Ibu</span>
                    </div>
                    <div class="sm:w-2/3">
                        <input type="text" name="groom_mother"
                            value="{{ $data['order']->invitation->wedding->groom->mother }}"
                            class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                            placeholder="Masukkan Nama Ibu Pengantin Pria" :disabled="edit ? false : true"
                            :class="edit == false && 'bg-neutral-100 '" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Alamat</span>
                    </div>
                    <div class="sm:w-2/3">
                        <textarea :disabled="edit ? false : true" :class="edit == false && 'bg-neutral-100 '"
                            name="groom_address" rows="4" value="{{ $data['order']->invitation->wedding->groom->address }}"
                            class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Masukkan Alamat Pengantin Pria">{{ $data['order']->invitation->wedding->groom->address }}</textarea>
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Instagram</span>
                    </div>
                    <div class="sm:w-2/3">
                        <div class="relative flex flex-wrap items-stretch w-full mb-4">
                            <span :class="edit == false && 'bg-neutral-100'"
                                class="flex items-center whitespace-nowrap rounded-l border border-r-0 border-solid border-neutral-300 px-3 py-[0.25rem] text-center text-base font-normal leading-[1.6] text-neutral-700"
                                id="basic-addon1">@</span>
                            <input :disabled="edit ? false : true"
                                :class="edit == false && 'bg-neutral-100'" type="text"
                                name="groom_instagram"
                                value="{{ $data['order']->invitation->wedding->groom->instagram }}"
                                class="relative m-0 block w-[1px] min-w-0 flex-auto rounded-r border border-solid border-neutral-300 px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition ease-in-out focus:z-[3] focus:border-primary-600 focus:text-neutral-700 focus:shadow-te-primary focus:outline-none"
                                placeholder="instagram" />
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-semibold">Foto</span>
                    </div>
                    <div class="flex flex-col gap-3 sm:w-2/3 lg:flex-row">
                        <div class="lg:w-full max-w-xs">
                            <img class="w-full object-cover aspect-square rounded" src="{{ asset($data['order']->invitation->wedding->groom->image) }}" alt="">
                        </div>
                        <div class="lg:w-full">
                            <input name="groom_image" value="{{ asset($data['order']->invitation->wedding->groom->image) }}" class="block w-full text-sm text-gray-900 focus:outline-none file:bg-brand-purple-500 file:text-white file:rounded-md file:px-5 file:py-2 file:mr-5" id="file_input" type="file" :disabled="edit ? false : true">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-white">
            <div class="container py-8">
                <div class="text-center sm:text-start">
                    <h3 class="mb-0 text-xl font-medium">Bride</h3>
                    <p>Information about the Bride.</p>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Nama</span>
                    </div>
                    <div class="sm:w-2/3">
                        <input type="text" name="bride_name"
                            value="{{ $data['order']->invitation->wedding->bride->name }}"
                            class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                            placeholder="Masukkan Nama Pengantin Wanita" :disabled="edit ? false : true"
                            :class="edit == false && 'bg-neutral-100 '" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Ayah</span>
                    </div>
                    <div class="sm:w-2/3">
                        <input type="text" name="bride_father"
                            value="{{ $data['order']->invitation->wedding->bride->father }}"
                            class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                            placeholder="Masukkan Nama Ayah Pengantin Pria"
                            :disabled="edit ? false : true"
                            :class="edit == false && 'bg-neutral-100 '" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Ibu</span>
                    </div>
                    <div class="sm:w-2/3">
                        <input type="text" name="bride_mother"
                            value="{{ $data['order']->invitation->wedding->bride->mother }}"
                            class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                            placeholder="Masukkan Nama Ibu Pengantin Pria" :disabled="edit ? false : true"
                            :class="edit == false && 'bg-neutral-100 '" />
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Alamat</span>
                    </div>
                    <div class="sm:w-2/3">
                        <textarea :disabled="edit ? false : true" :class="edit == false && 'bg-neutral-100 '"
                            name="bride_address" rows="4" value="{{ $data['order']->invitation->wedding->bride->address }}"
                            class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Masukkan Alamat Pengantin Pria">{{ $data['order']->invitation->wedding->bride->address }}</textarea>
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Instagram</span>
                    </div>
                    <div class="sm:w-2/3">
                        <div class="relative flex flex-wrap items-stretch w-full mb-4">
                            <span :class="edit == false && 'bg-neutral-100'"
                                class="flex items-center whitespace-nowrap rounded-l border border-r-0 border-solid border-neutral-300 px-3 py-[0.25rem] text-center text-base font-normal leading-[1.6] text-neutral-700"
                                id="basic-addon1">@</span>
                            <input :disabled="edit ? false : true"
                                :class="edit == false && 'bg-neutral-100'" type="text"
                                name="bride_instagram"
                                value="{{ $data['order']->invitation->wedding->bride->instagram }}"
                                class="relative m-0 block w-[1px] min-w-0 flex-auto rounded-r border border-solid border-neutral-300 px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition ease-in-out focus:z-[3] focus:border-primary-600 focus:text-neutral-700 focus:shadow-te-primary focus:outline-none"
                                placeholder="instagram" />
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-semibold">Foto</span>
                    </div>
                    <div class="flex flex-col gap-3 sm:w-2/3 lg:flex-row">
                        <div class="lg:w-full max-w-xs">
                            <img class="w-full object-cover aspect-square rounded" src="{{ asset($data['order']->invitation->wedding->bride->image) }}" alt="">
                        </div>
                        <div class="lg:w-full">
                            <input name="bride_image" value="{{ asset($data['order']->invitation->wedding->bride->image) }}" class="block w-full text-sm text-gray-900 focus:outline-none file:bg-brand-purple-500 file:text-white file:rounded-md file:px-5 file:py-2 file:mr-5" id="file_input" type="file" :disabled="edit ? false : true">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-white">
            <div class="container py-8">
                <div class="text-center sm:text-start">
                    <h3 class="mb-0 text-xl font-medium">Events</h3>
                    <p>Information of Wedding Events</p>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Akad</span>
                    </div>
                    <div class="sm:w-2/3">
                        <div>
                            <span class="font-semibold">Tanggal</span>
                            <input type="date" name="date_akad"
                                value="{{ \Carbon\Carbon::createFromDate($data['order']->invitation->wedding->event[0]->date)->toDateString() }}"
                                class="mt-1.5 block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                :disabled="edit ? false : true"
                                :class="edit == false && 'bg-neutral-100'" />
                        </div>
                        <div class="mt-4">
                            <span class="font-semibold">Waktu</span>
                            <div class="flex flex-col items-center gap-2 sm:flex-row mt-1.5">
                                <input type="time"  name="start_time_akad"
                                    value="{{ $data['order']->invitation->wedding->event[0]->start_time }}"
                                
                                    class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                    :disabled="edit ? false : true"
                                    :class="edit == false && 'bg-neutral-100'" />
                                -
                                <input type="time"  name="end_time_akad"
                                    value="{{ $data['order']->invitation->wedding->event[0]->end_time }}"
                                
                                    class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                    :disabled="edit ? false : true"
                                    :class="edit == false && 'bg-neutral-100'" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="font-semibold">Tempat</span>
                            <input type="text" name="place_akad"
                                value="{{ $data['order']->invitation->wedding->event[0]->place }}"
                                class="mt-1.5 block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                placeholder="Masukkan Tempat Akad" :disabled="edit ? false : true"
                                :class="edit == false && 'bg-neutral-100 '" />
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Resepsi</span>
                    </div>
                    <div class="sm:w-2/3">
                        <div>
                            <span class="font-semibold">Tanggal</span>
                            <input type="date" name="date_resepsi"
                                value="{{ \Carbon\Carbon::createFromDate($data['order']->invitation->wedding->event[1]->date)->toDateString() }}"
                                class="mt-1.5 block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                :disabled="edit ? false : true"
                                :class="edit == false && 'bg-neutral-100'" />
                        </div>
                        <div class="mt-4">
                            <span class="font-semibold">Waktu</span>
                            <div class="flex flex-col items-center gap-2 sm:flex-row mt-1.5">
                                <input type="time"  name="start_time_resepsi"
                                    value="{{ $data['order']->invitation->wedding->event[1]->start_time }}"
                                
                                    class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                    :disabled="edit ? false : true"
                                    :class="edit == false && 'bg-neutral-100'" />
                                -
                                <input type="time"  name="end_time_resepsi"
                                    value="{{ $data['order']->invitation->wedding->event[1]->end_time }}"
                                
                                    class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                    :disabled="edit ? false : true"
                                    :class="edit == false && 'bg-neutral-100'" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="font-semibold">Tempat</span>
                            <input type="text" name="place_resepsi"
                                value="{{ $data['order']->invitation->wedding->event[1]->place }}"
                                class="mt-1.5 block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                placeholder="Masukkan Tempat Resepsi" :disabled="edit ? false : true"
                                :class="edit == false && 'bg-neutral-100 '" />
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Unduh Mantu</span>
                    </div>
                    <div class="sm:w-2/3">
                        <div>
                            <span class="font-semibold">Tanggal</span>
                            <input type="date" name="date_unduh_mantu"
                                value="{{ \Carbon\Carbon::createFromDate($data['order']->invitation->wedding->event[2]->date)->toDateString() }}"
                                class="mt-1.5 block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                :disabled="edit ? false : true"
                                :class="edit == false && 'bg-neutral-100'" />
                        </div>
                        <div class="mt-4">
                            <span class="font-semibold">Waktu</span>
                            <div class="flex flex-col items-center gap-2 sm:flex-row mt-1.5">
                                <input type="time"  name="start_time_unduh_mantu"
                                    value="{{ $data['order']->invitation->wedding->event[2]->start_time }}"
                                
                                    class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                    :disabled="edit ? false : true"
                                    :class="edit == false && 'bg-neutral-100'" />
                                -
                                <input type="time"  name="end_time_unduh_mantu"
                                    value="{{ $data['order']->invitation->wedding->event[2]->end_time }}"
                                
                                    class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                    :disabled="edit ? false : true"
                                    :class="edit == false && 'bg-neutral-100'" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="font-semibold">Tempat</span>
                            <input type="text" name="place_unduh_mantu"
                                value="{{ $data['order']->invitation->wedding->event[2]->place }}"
                                class="mt-1.5 block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                placeholder="Masukkan Tempat Unduh Mantu" :disabled="edit ? false : true"
                                :class="edit == false && 'bg-neutral-100 '" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @if($data['order']->package->name == 'Gold')
        <section class="bg-white">
            <div class="container py-8">
                <div class="text-center sm:text-start">
                    <h3 class="mb-0 text-xl font-medium">Love Stories</h3>
                    <p>Stories of your love</p>
                </div>
                <?php $i = 0; ?>
                {{-- <template x-for="i in eventsCount"> --}}
                @foreach ($data['order']->invitation->wedding->love_story as $love_story)
                    <input type="hidden" name="love_stories[{{$i}}][id]" value={{$love_story->id}}>
                    <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                        <div class="sm:w-1/3">
                            <span class="font-bold">Story {{ $i }}</span>
                        </div>
                        <div class="sm:w-2/3">
                            <div>
                                <span class="font-semibold">Tahun</span>
                                <input type="number" name="love_stories[{{$i}}][year]" value="{{ $love_story->year }}"
                                
                                    class="mt-1.5 block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                    placeholder="Masukkan Tahun Kejadian" :disabled="edit ? false : true"
                                    :class="edit == false && 'bg-neutral-100 '" />
                            </div>
                            <div class="mt-4">
                                <span class="font-semibold">Kisah</span>
                                <textarea :disabled="edit ? false : true" :class="edit == false && 'bg-neutral-100 '" id="message"
                                    name="love_stories[{{$i}}][story]" rows="4" value="{{ $love_story->story }}"
                                    class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 mt-1.5"
                                    placeholder="Ceritakan Kisahmu Disini...">{{ $love_story->story }}</textarea>
                            </div>
                            <div class="mt-4">
                                <span class="font-semibold">Gambar</span>
                                <div class="flex flex-col gap-3 lg:flex-row">
                                    <div class="lg:w-full max-w-xs">
                                        <img class="w-full object-cover aspect-square rounded" src="{{ asset($love_story->image) }}" alt="">
                                    </div>
                                    <div class="lg:w-full">
                                        <input name="love_stories[{{$i}}][image]" value="{{ asset($love_story->image) }}" class="block w-full text-sm text-gray-900 focus:outline-none file:bg-brand-purple-500 file:text-white file:rounded-md file:px-5 file:py-2 file:mr-5" id="file_input" type="file" :disabled="edit ? false : true">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $i++; ?>
                @endforeach
                {{-- </template> --}}
                {{-- <div class="flex justify-end gap-2" x-show="edit">
                    <x-button type="button" @click="decrementEvent()" x-show="eventsCount > 1"
                        class="w-full py-3 tracking-wide capitalize transition-colors duration-200 transform bg-white sm:w-40 ring-1 ring-brand-purple-500 hover:ring-0 hover:text-black hover:bg-brand-yellow-500">
                        <span class="mx-1"><i class="fa-solid fa-minus"></i></span>
                    </x-button>
                    <x-button type="button" @click="incrementEvent()" x-show="eventsCount < 5"
                        class="w-full py-3 tracking-wide text-white capitalize transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                        <span class="mx-1"><i class="fa-solid fa-plus"></i></span>
                    </x-button>
                </div> --}}
            </div>
        </section>
        @endif
        <section class="bg-white">
            <div class="container py-8">
                @if($data['order']->package->name == 'Gold' || $data['order']->package->name == 'Silver')
                <div class="text-center sm:text-start">
                    <h3 class="mb-0 text-xl font-medium">Gallery</h3>
                    <p>Upload your romantic images</p>
                </div>
                <?php
                $i = 0;
                ?>
                {{-- <template x-for="i in eventsCount"> --}}
                @foreach ($data['order']->invitation->wedding->gallery as $gallery)
                <input type="hidden" name="galleries[{{$i}}][id]" value={{$gallery->id}}>
                <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="sm:w-1/3">
                        <span class="font-bold">Image {{ $i }}</span>
                    </div>
                    <div class="sm:w-2/3">
                        <div class="mt-4">
                            <div class="flex flex-col gap-3 lg:flex-row">
                                <div class="lg:w-full max-w-xs">
                                    <img class="w-full object-cover aspect-square rounded" src="{{ asset($gallery->file) }}" alt="">
                                </div>
                                <div class="lg:w-full">
                                    <input name="galleries[{{$i}}][file]" value="{{ asset($gallery->file) }}" class="block w-full text-sm text-gray-900 focus:outline-none file:bg-brand-purple-500 file:text-white file:rounded-md file:px-5 file:py-2 file:mr-5" id="file_input" type="file" :disabled="edit ? false : true">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php
                $i++;
                ?>
                @endforeach
                @endif
                {{-- </template> --}}
                <div class="flex justify-end gap-2 py-4 border-t border-gray-200" x-show="!edit">
                    <x-button type="button" @click="editMode()"
                        class="w-full py-3 tracking-wide text-white capitalize transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                        <span class="mx-1">Ubah</span>
                    </x-button>
                </div>
                <div class="flex justify-end gap-2 py-4 border-t border-gray-200" x-show="edit">
                    <x-button type="button" @click="reset()"
                        class="w-full whitespace-nowrap tracking-wide capitalize transition-colors duration-200 transform bg-white sm:w-40 ring-1 ring-brand-purple-500 hover:ring-0 hover:text-black hover:bg-brand-yellow-500">
                        <span class="mx-1">Batalkan</span>
                    </x-button>
                    <x-button type="submit"
                        class="w-full whitespace-nowrap tracking-wide text-white capitalize transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                        Simpan Perubahan
                    </x-button>
                </div>
            </div>
        </section>
        <section class="bg-white">
            <div class="container py-8">
                <div>
                    <h3 class="mb-0 text-xl font-medium">Tamu</h3>
                    <p>Tamu yang baru ditambahkan.</p>
                </div>
                <div class="relative overflow-auto shadow-md max-h-96 sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Description
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Address
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    No WA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['guests'] as $guest )
                            <tr
                                class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $guest->name }}</td>
                                <td class="px-6 py-4">{{ $guest->description }}</td>
                                <td class="px-6 py-4">{{ $guest->address }}</td>
                                <td class="px-6 py-4">{{ $guest->no_whats_app }}</td>
                                <td class="px-6 py-4">{{ $guest->email }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="justify-between mt-5 sm:flex">
                    <p>Total tamu seluruhnya: <span class="font-bold">{{ $data['guests_count'] }}</span></p>
                    <a class="text-brand-purple-500"
                        href="">Lihat lebih
                        banyak
                        <i class="fa-solid fa-arrow-right-long"></i></a>
                </div>
            </div>
        </section>
    </form>
</main>
@push('before-scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('formData', () => ({
                edit: false,
                eventsCount: {{ count($data['order']->invitation->wedding->love_story) }},
                imagesCount: 2,
                form: {},
                editMode() {
                    this.edit = true
                },
                readonlyMode() {
                    this.edit = false
                },
                reset() {
                    this.form = {};
                    this.edit = false;
                },
                incrementEvent() {
                    this.eventsCount++
                },
                decrementEvent() {
                    this.eventsCount--
                },
                incrementImage() {
                    this.imagesCount++
                },
                decrementImage() {
                    this.imagesCount--
                }
            }))
        });
    </script>
@endpush
@endsection

