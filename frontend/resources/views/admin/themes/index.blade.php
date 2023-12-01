@extends('client.layouts.app')

@section('content')
@php
    $dataCount = count($data);
    $alpineData = "themes";
@endphp 
<main class="py-3 bg-white grow">
    <div class="container">
        {{-- <div class="flex flex-col gap-2 text-center sm:flex-row">
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
        </div> --}}
        <div class="flex flex-col items-start justify-between gap-2 mb-5 sm:items-center items sm:flex-row">
            <x-button-a href="{{ route('admin.themes.add') }}" type="button"
                class="sm:order-3 whitespace-nowrap w-full !px-6 !py-3 tracking-wide text-white capitalize transition-colors duration-200 transform sm:w-fit bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                <span>Add New</span>
            </x-button-a>
            <div class="flex w-full max-sm:justify-between">
                <p class="m-0"><span x-text="selectedCheckboxCount"></span> baris dipilih</p>
                <div class="flex justify-between gap-3 sm:mx-auto">
                    <x-button @click="confirmDelete(getSelectedThemes())" type="button"
                        x-show="selectedCheckboxCount > 0"
                        class="!px-0 !py-0 text-brand-red sm:w-fit hover:text-black">
                        <span class="font-extrabold">Delete</span>
                    </x-button>
                </div>
            </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="selectAllCheckbox" type="checkbox"
                                    x-on:change="headerCheckboxChange($el);"
                                    class="w-4 h-4 checkbox-brand-purple-500">
                                <label for="selectAllCheckbox" class="sr-only">checkbox</label>
                            </div>
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
                    @foreach ($data as $theme)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-{{ $theme->id }}" value="{{ $theme->id }}"
                                        type="checkbox" name="themeCheckbox"
                                        x-on:change="rowCheckboxChange($el);"
                                        class="w-4 h-4 checkbox-brand-purple-500">
                                    <label for="checkbox-{{ $theme->id }}" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                {{ $theme->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @rupiah($theme->price)
                            </td>
                            <td class="px-6 py-4">
                                {{ $theme->description }}
                            </td>
                            <td class="py-4 gap-1">
                                <x-button-a href="{{ route('admin.themes.edit', encode_id($theme->id)) }}"
                                    class="!w-9 !h-9 bg-brand-purple-500 text-white transition-colors duration-200 transform ring-brand-purple-500 hover:text-black hover:bg-brand-yellow-500">
                                    <i class="text-lg ph ph-pencil-simple"></i>
                                </x-button-a>
                                <x-button @click="confirmDelete([{{ $theme->id }}])"
                                    class="!w-9 !h-9 bg-brand-red text-white transition-colors duration-200 transform ring-brand-purple-500 hover:text-black hover:bg-brand-yellow-500">
                                    <i class="text-lg ph ph-trash"></i>
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

    <x-flowbite-modal id="confirmDelete" title="Hapus Themes">
        <!--  body -->
        <div class="flex flex-col items-center justify-center p-6">
            <i class="fa-regular fa-circle-question text-brand-purple-500 text-9xl"></i>
            <div class="mt-4">
                <span class="font-bold">Apakah anda yakin untuk menghapus themes?</span>
            </div>
        </div>
        <!--  footer -->
        <div
            class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
            <x-button type="button" @click="hide()"
                class="w-full py-3 tracking-wide capitalize transition-colors duration-200 transform bg-white sm:w-40 ring-1 ring-brand-purple-500 hover:ring-0 hover:text-black hover:bg-brand-yellow-500">
                <span class="mx-1">Batalkan</span>
            </x-button>
            <x-button type="button" @click="deleteThemes(); hide();"
                class="w-full py-3 tracking-wide text-white capitalize transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                Hapus
            </x-button>
        </div>
    </x-flowbite-modal>

    <x-flowbite-modal id="success" title="successTitle" xdata="{message:'operasi berhasil'}" closable="false">
        <!--  body -->
        <div class="flex flex-col items-center justify-center p-6">
            <i class="fa-regular fa-circle-check text-brand-purple-500 text-9xl"></i>
            <div class="mt-4">
                <span x-text="message" class="font-bold"></span>
            </div>
        </div>
        <!--  footer -->
        <div
            class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
            <x-button type="button" @click="window.location.reload(true)"
                class="w-full py-3 tracking-wide text-white capitalize transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                OK
            </x-button>
        </div>
    </x-flowbite-modal>
    
    <x-flowbite-modal id="failed" title="failTitle" xdata="{message:'operasi gagal'}" closable="false">
        <!--  body -->
        <div class="flex flex-col items-center justify-center p-6">
            <i class="fa-regular fa-circle-xmark text-brand-purple-500 text-9xl"></i>
            <div class="mt-4">
                <span x-text="message" class="font-bold"></span>
            </div>
        </div>
        <!--  footer -->
        <div
            class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
            <x-button type="button" @click="hide();"
                class="w-full py-3 tracking-wide text-white capitalize transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                OK
            </x-button>
        </div>
    </x-flowbite-modal>
    
    <x-flowbite-modal id="loading" title="loadingTitle" xdata="{message:'Mohon tunggu ...'}" closable="false"
        header="false">
        <!--  body -->
        <div class="flex flex-col items-center justify-center p-6">
            <i class="fa-solid fa-spinner fa-spin-pulse text-brand-purple-500 text-9xl"></i>
            <div class="mt-4">
                <span x-text="message" class="font-bold"></span>
            </div>
        </div>
    </x-flowbite-modal>
</main>
@endsection

@push('before-scripts')
    @if (session()->has('success'))
        <script>alert("{{ session('success') }}")</script>
    @endif
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('themes', () => ({
                selectedCheckboxCount: 0,
                dataCount: {{ $dataCount }},
                toggleThemeCheckboxes() {
                    var checkboxes = document.getElementsByName("themeCheckbox");
                    var selectAllCheckbox = document.getElementById("selectAllCheckbox");

                    for (var i = 0; i < checkboxes.length; i++) {
                        checkboxes[i].checked = selectAllCheckbox.checked;
                    }
                },
                updateSelectAllCheckbox() {
                    var checkboxes = document.getElementsByName("themeCheckbox");
                    var selectAllCheckbox = document.getElementById("selectAllCheckbox");

                    for (var i = 0; i < checkboxes.length; i++) {
                        if (!checkboxes[i].checked) {
                            selectAllCheckbox.checked = false;
                            return;
                        }
                    }

                    selectAllCheckbox.checked = true;
                },
                checkboxChange(el) {
                    console.log(this.selectedCheckboxCount);
                },
                headerCheckboxChange(el) {
                    console.log(el);
                    this.toggleThemeCheckboxes();
                    if (el.checked) {
                        this.selectedCheckboxCount = this.dataCount;
                    } else {
                        this.selectedCheckboxCount = 0;
                    }
                    this.checkboxChange(el);
                },
                rowCheckboxChange(el) {
                    this.updateSelectAllCheckbox();
                    if (el.checked) {
                        this.selectedCheckboxCount += 1;
                    } else {
                        this.selectedCheckboxCount -= 1;
                    }
                    this.checkboxChange(el);
                }
            }))
        });

        let defaultMethod = 'email';
        let targetTheme = [];

        function getSelectedThemes() {
            selectedTheme = [];
            $("input:checkbox[name=themeCheckbox]:checked").each(function() {
                selectedTheme.push($(this).val());
            });
            return selectedTheme;
        }

        function confirmDelete(target) {
            targetTheme = target;
            modals.confirmDelete.show();
        }

        function deleteThemes() {
            var csrfToken = '{{ csrf_token() }}';

            $.ajax({
                url: '{{ route('admin.themes.delete') }}',
                method: 'POST',
                data: {
                    selectedIDs: targetTheme,
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) { //status 200
                    console.log(response);
                    modals.loading.hide();
                    modals.success.show();
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.log(xhr);
                    modals.loading.hide();
                    modals.failed.show();
                }
            });
            modals.loading.show();
        }
    </script>
@endpush