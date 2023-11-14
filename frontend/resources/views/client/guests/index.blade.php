@extends('client.layouts.app')

@section('content')   
@php
    $dataCount = count($data);
    $invitationID = 0;
    $alpineData = "guests";
    $phpData = $invitationId;
@endphp 
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
        <div class="flex flex-col items-start justify-between gap-2 my-5 sm:items-center items sm:flex-row">
            <x-button-a href="{{ route('client.invitation.guest.add', encode_id($invitationId)) }}" type="button"
                class="sm:order-3 whitespace-nowrap w-full !px-6 !py-3 tracking-wide text-white capitalize transition-colors duration-200 transform sm:w-fit bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                <span class="font-extrabold">Add New</span>
            </x-button-a>
            <div class="flex w-full max-sm:justify-between">
                <p class="m-0"><span x-text="selectedCheckboxCount"></span> baris dipilih</p>
                <div class="flex justify-between gap-3 sm:mx-auto">
                    <x-button @click="confirmDelete(getSelectedGuests())" type="button"
                        x-show="selectedCheckboxCount > 0"
                        class="!px-0 !py-0 text-brand-red sm:w-fit hover:text-black">
                        <span class="font-extrabold">Delete</span>
                    </x-button>
                    <x-button @click="modals.broadcast.show()" type="button" x-show="selectedCheckboxCount > 0"
                        class="!px-0 !py-0 text-brand-purple-500 sm:w-fit hover:text-brand-purple-600">
                        <span class="font-extrabold">Broadcast</span>
                    </x-button>
                </div>
            </div>
        </div>
        <div class="relative my-5 overflow-x-auto shadow-md sm:rounded-lg">
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
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nomor WA
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Undangan
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($data as $guest)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-{{ $guest->id }}" value="{{ $guest->id }}"
                                        type="checkbox" name="guestCheckbox"
                                        x-on:change="rowCheckboxChange($el);"
                                        class="w-4 h-4 checkbox-brand-purple-500">
                                    <label for="checkbox-{{ $guest->id }}" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap ">
                                {{ $i }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $guest->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $guest->email }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $guest->no_whats_app }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($guest->is_invited)
                                    Dikirim
                                @else
                                    Belum Dikirim
                                @endif
                            </td>
                            <td class="flex justify-center py-4">
                                <x-button-a @click="confirmInvitation([{{ $guest->id }}],defaultMethod)" 
                                    class="w-9 h-9 mx-1.5 bg-brand-purple-100 text-brand-purple-500 transition-colors duration-200 transform ring-brand-purple-500 hover:text-black hover:bg-brand-yellow-500">
                                    <i class="text-2xl ph-fill ph-envelope-simple"></i>
                                </x-button-a>
                                <x-button-a @click="confirmInvitation([{{ $guest->id }}],'wa')"
                                    class="w-9 h-9 mx-1.5 bg-brand-purple-100 text-brand-purple-500 transition-colors duration-200 transform ring-brand-purple-500 hover:text-black hover:bg-brand-yellow-500">
                                    <i class="text-2xl ph ph-whatsapp-logo"></i>
                                </x-button-a>
                                <x-button-a href="{{ route('client.invitation.guest.edit', encode_id($guest->id)) }}"
                                    class="w-9 h-9 mx-1.5 bg-brand-purple-500 text-white transition-colors duration-200 transform ring-brand-purple-500 hover:text-black hover:bg-brand-yellow-500">
                                    <i class="text-2xl ph ph-pencil-simple"></i>
                                </x-button-a>
                                <x-button @click="confirmDelete([{{ $guest->id }}])"
                                    class="w-9 h-9 mx-1.5 bg-brand-red text-white transition-colors duration-200 transform ring-brand-purple-500 hover:text-black hover:bg-brand-yellow-500">
                                    <i class="text-2xl ph ph-trash"></i>
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

<x-flowbite-modal id="broadcast" title="Broadcast" xdata="{method:'wa'}">
    <!--  body -->
    <div class="flex flex-col p-6 my-6 sm:flex-row sm:justify-between sm:items-center">
        <div class="mr-4">
            <span class="font-bold">Broadcast Via</span>
        </div>
        <div class="flex-grow">
            <select name="broadcastMethod" x-model="method"
                class=" border border-gray-300 text-sm rounded-lg focus:ring-brand-purple-500 focus:border-brand-ring-brand-purple-500 block w-full p-2.5">
                <option value="email" selected>Email</option>
                <option value="wa">Whatsapp</option>
            </select>
        </div>
    </div>
    <!--  footer -->

    <div
        class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
        <x-button @click="hide()" type="button"
            class="w-full py-3 tracking-wide capitalize transition-colors duration-200 transform bg-white sm:w-40 ring-1 ring-brand-purple-500 hover:ring-0 hover:text-black hover:bg-brand-yellow-500">
            <span class="mx-1">Cancel</span>
        </x-button>
        <x-button type="button" @click="broadcast()"
            class="w-full py-3 tracking-wide text-white capitalize transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
            Broadcast
        </x-button>
    </div>
</x-flowbite-modal>

<x-flowbite-modal id="confirmInvite" title="Send Invitation">
    <!--  body -->
    <div class="flex flex-col items-center justify-center p-6">
        <i class="fa-regular fa-circle-question text-brand-purple-500 text-9xl"></i>
        <div class="mt-4">
            <span class="font-bold">Apakah anda yakin untuk mengirim undangan?</span>
        </div>
    </div>
    <!--  footer -->
    <div
        class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
        <x-button type="button" @click="hide()"
            class="w-full py-3 tracking-wide capitalize transition-colors duration-200 transform bg-white sm:w-40 ring-1 ring-brand-purple-500 hover:ring-0 hover:text-black hover:bg-brand-yellow-500">
            <span class="mx-1">Batalkan</span>
        </x-button>
        <x-button type="button" @click="sendInvitation(); hide();"
            class="w-full py-3 tracking-wide text-white capitalize transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
            Kirim
        </x-button>
    </div>
</x-flowbite-modal>

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
        class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
        <x-button type="button" @click="hide()"
            class="w-full py-3 tracking-wide capitalize transition-colors duration-200 transform bg-white sm:w-40 ring-1 ring-brand-purple-500 hover:ring-0 hover:text-black hover:bg-brand-yellow-500">
            <span class="mx-1">Batalkan</span>
        </x-button>
        <x-button type="button" @click="deleteGuest(); hide();"
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
@endsection

@push('before-scripts')
    @if (session()->has('success'))
        <script>alert("{{ session('success') }}")</script>
    @endif
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('guests', () => ({
                selectedCheckboxCount: 0,
                dataCount: {{ $dataCount }},
                toggleGuestCheckboxes() {
                    var checkboxes = document.getElementsByName("guestCheckbox");
                    var selectAllCheckbox = document.getElementById("selectAllCheckbox");

                    for (var i = 0; i < checkboxes.length; i++) {
                        checkboxes[i].checked = selectAllCheckbox.checked;
                    }
                },
                updateSelectAllCheckbox() {
                    var checkboxes = document.getElementsByName("guestCheckbox");
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
                    this.toggleGuestCheckboxes();
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
        let targetGuests = [];


        function getSelectedGuests() {
            selectedGuests = [];
            $("input:checkbox[name=guestCheckbox]:checked").each(function() {
                selectedGuests.push($(this).val());
            });
            return selectedGuests;
        }

        function broadcast() {
            modals.broadcast.hide();
            const method = document.getElementsByName("broadcastMethod")[0].value;
            confirmInvitation(getSelectedGuests(), method);
        }

        function confirmInvitation(target, method) {
            targetGuests = target;
            selectedMethod = method;
            modals.confirmInvite.show();
        }

        function sendInvitation() {
            modals.broadcast.hide();
            if (selectedMethod === "" || !selectedMethod) {
                selectedMethod = defaultMethod;
            }
            var csrfToken = '{{ csrf_token() }}';

            $.ajax({
                url: '{{ route('client.invitation.guest.sendInvitation', encode_id($invitationId)) }}',
                method: 'POST',
                data: {
                    selectedIDs: targetGuests,
                    selectedMethod: selectedMethod
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) { //status 200
                    console.log(response.output);
                    modals.loading.hide();
                    modals.success.show();
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    modals.loading.hide();
                    modals.failed.show();
                }
            });
            modals.loading.show();
        }

        function confirmDelete(target) {
            targetGuests = target;
            modals.confirmDelete.show();
        }

        function deleteGuest() {
            var csrfToken = '{{ csrf_token() }}';

            $.ajax({
                url: '{{ route('client.invitation.guest.delete', encode_id($invitationId)) }}',
                method: 'GET',
                data: {
                    selectedIDs: targetGuests,
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

