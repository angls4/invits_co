@extends('client.layouts.app')

@section('content') 

@php
$phpData = $data['invitation']->id
@endphp

<main class="py-3 bg-white grow">
    <div class="container" >
    @if($data['package']->name == 'Gold' || $data['package']->name == 'Silver')
        <div class="flex flex-col gap-2 text-center sm:flex-row">
            <div class="grow">
                <form>
                    <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only ">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="search" id="search" name="key"
                            class="block w-full p-3 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-brand-purple-500 focus:border-brand-ring-brand-purple-500"
                            placeholder="Search" required>
                        <button type="submit"
                            class="absolute top-0 right-0 h-full px-6 py-2 text-sm font-medium text-white rounded-r-lg bg-brand-purple-500 hover:bg-brand-yellow-500">Search</button>
                    </div>
                </form>
            </div>
            {{-- <x-button class="px-6 py-3 transition-colors duration-200 transform bg-brand-purple-100 ring-brand-purple-500 hover:text-black hover:bg-brand-yellow-500"><i class="mr-2 fa-solid fa-filter"></i>Filter</x-button> --}}
        </div>

        <div class="relative my-5 overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Jumlah Tamu
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tanggal Pengisian
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kehadiran
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['rsvps'] as $rsvp)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap ">
                                {{ $rsvp->id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $rsvp->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $rsvp->amount_guest }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $rsvp->created_at }}
                            </td>
                            <td class="px-6 py-4">
                                @if($rsvp->is_attend)
                                Hadir
                                @else
                                Tidak Hadir
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $data['rsvps']->links() }}
    @else
    <p>Paket yang anda beli tidak mendukung fitur RSVP</p>
    @endif
    </div>
</main>

@endsection


