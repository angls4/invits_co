@extends('client.layouts.app')

@section('content')   
<main class="py-3 bg-white grow">
    <div class="container">
        @if($data->count() > 0)
        <div class="relative my-5 overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tanggal Pemesanan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            URL
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tema
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nota
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Undangan
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $order)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-table-search-3" type="checkbox"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 ">
                                    <label for="checkbox-table-search-3" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                {{ ($loop->index + 1) + (($data->currentPage() - 1) * $data->perPage()) }}
                            </th>
                            <td class="px-6 py-4">
                                {{ Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($order->status != "UNPAID")
                                <a href="{{ "../" . $order->invitation->slug }}" target="_blank"> {{ $order->invitation->slug }} </a>
                                @else
                                {{ "BELUM MEMBAYAR" }}
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ $order->theme->name }}
                            </td>
                            <td class="px-6 py-4">
                                @if($order->status != "UNPAID")
                                    {{ $order->invitation->status }}
                                @else
                                    {{ "UNPAID" }}
                                @endif
                            </td>
                            @if($order->status != "UNPAID")
                                <td class="px-6 py-4">
                                    <a href="{{ route('client.ordersDetail', $order->id) }}"
                                        class="font-medium text-brand-pink hover:underline">Details</a>
                                </td>
                                <td class="px-6 py-4">
                                    <a href=""
                                        class="font-medium text-brand-purple-500 hover:underline">Details</a>
                                </td>
                            @else
                                <td class="px-6 py-4">
                                    -
                                </td>
                                <td class="px-6 py-4">
                                    -
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $data->links() }}
        @else
        <div class="mx-auto w-fit">
            <h2 class="mt-0 mb-2 text-4xl font-medium leading-tight text-center">Anda Belum Memesan</h2>
            <div class="w-1/2 h-2 mx-auto rounded-md bg-brand-purple-500"></div>
        </div>
        <div class="mx-auto mt-4 w-fit">
            <x-button-a href="{{ route('order.index') }}" type="button"
                class="w-full py-3 tracking-wide text-white capitalize transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                <span class="font-extrabold">Pesan Sekarang</span>
            </x-button>
        </div>
        @endif

    </div>
</main>
@endsection