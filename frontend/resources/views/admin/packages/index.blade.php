@extends('client.layouts.app')

@section('content')
<main class="py-3 bg-white grow">
    <div class="container">
        <div class="flex flex-col gap-2 text-center sm:flex-row">
            <div class="grow">
                <form>
                    <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only ">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
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
        </div>
        <x-button-a href="{{ route('admin.packages.add') }}" type="button"
            class="whitespace-nowrap w-full !px-6 !py-3 my-4 ml-auto !block tracking-wide text-white capitalize transition-colors duration-200 transform sm:w-fit bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
            <span>Add New</span>
        </x-button-a>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Harga
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Deskripsi
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($data as $package)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap ">
                                {{ $i }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $package->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $package->price }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $package->description }}
                            </td>
                            <td class="flex justify-center py-4 gap-1">
                                <x-button-a href="{{ route('admin.packages.edit', encode_id($package->id)) }}"
                                    class="w-9 h-9 bg-brand-purple-500 text-white transition-colors duration-200 transform ring-brand-purple-500 hover:text-black hover:bg-brand-yellow-500">
                                    <i class="text-lg ph ph-pencil-simple"></i>
                                </x-button-a>
                                <x-button
                                    class="w-9 h-9 bg-brand-red text-white transition-colors duration-200 transform ring-brand-purple-500 hover:text-black hover:bg-brand-yellow-500">
                                    <i class="text-xl ph ph-trash"></i>
                                </x-button>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $data->links() }}
    </div>
</main>

<x-flowbite-modal id="confirmDelete" title="Hapus Tamu">
    <!--  body -->
    <div class="flex flex-col items-center justify-center p-6">
        <i class="fa-regular fa-circle-question text-brand-purple-500 text-9xl"></i>
        <div class="mt-4">
            <span class="font-bold">Apakah anda yakin untuk menghapus tamu?</span>
        </div>
    </div>
    <!--  footer -->
    <div
        class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b">
        <x-button type="button"
            class="w-full py-3 tracking-wide capitalize transition-colors duration-200 transform bg-white sm:w-40 ring-1 ring-brand-purple-500 hover:ring-0 hover:text-black hover:bg-brand-yellow-500">
            <span class="mx-1">Batalkan</span>
        </x-button>
        <x-button type="button"
            class="w-full py-3 tracking-wide text-white capitalize transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
            Hapus
        </x-button>
    </div>
</x-flowbite-modal>
@endsection

@push('before-scripts')
    @if (session()->has('success'))
        <script>alert("{{ session('success') }}")</script>
    @endif
    <script>
        
    </script>
@endpush