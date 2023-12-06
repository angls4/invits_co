@extends('layouts.app')

@section('content')
<section class="py-10">
    <div class="container">
        <div class="mx-auto w-fit">
            <h1 class="mt-0 mb-2 text-5xl font-medium leading-tight text-center">Pembayaran</h1>
            <div class="w-1/2 h-2 mx-auto rounded-md bg-brand-purple-500"></div>
        </div>
        <div class="py-5 mt-8 rounded-md px-7 bg-brand-purple-100">
            <div>
                <strong>Nama</strong>
                <p class="capitalize">{{ session('user.name') }}</p>
            </div>
            <div>
                <strong>Email</strong>
                <p>{{ session('user.name') }}</p>
            </div>
            <div>
                <strong>Pilihan Paket</strong>
                <div>
                    <p class="mb-1">{{ $data["package"]["name"] }}</p>
                </div>
            </div>
            <div>
                <strong>Pilihan Tema</strong>
                <div>
                    <p class="mb-1">{{ $data["theme"]["name"] }}</p>
                </div>
            </div>
        </div>
        <div class="flex flex-col justify-between py-4 mt-5 font-bold rounded-md px-7 sm:flex-row bg-brand-purple-100">
            <span>Total</span>
            <span>@rupiah($data["theme"]["price"])</span>
        </div>
        <div class="flex justify-end gap-2 mt-8">
            {{-- <x-button-a href="{{ route('order.theme') }}" class="w-full py-3 tracking-wide transition-colors duration-200 transform bg-white sm:w-40 ring-1 ring-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                <span class="mx-1">Prev</span>
            </x-button-a> --}}
            {{-- <x-button-a href="{{ route('order.checkout') }}" class="w-full py-3 tracking-wide text-white transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                <span class="mx-1">Buat Undangan</span>
            </x-button-a> --}}

            <x-button id="pay-button" type="submit" class="text-white transition-colors duration-200 transform bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                <span class="mx-1">Bayar Sekarang</span>
            </x-button>
        </div>
    </div>
    
    {{-- @php
        $snapToken = $data["order"]["payment_midtrans"];
        $order_id = explode(':',$snapToken)[1];
        $server_key = env('MIDTRANS_SERVER_KEY');
        $signature_key = hash("sha512", $order_id . $server_key);
    @endphp --}}
    <script type="text/javascript">
    // For example trigger on button clicked, or any time you need
    var payButton = document.getElementById('pay-button');
    var snapPay = function () {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay('{{ $data["order"]["payment_midtrans"] }}', {
            onSuccess: function(result){
                /* You may add your own implementation here */
                alert("payment success!"); console.log(result);
                window.location.href = "{{ route('home')}}";
            },
            onPending: function(result){
                /* You may add your own implementation here */
                alert("wating your payment!"); console.log(result);
            },
            onError: function(result){
                /* You may add your own implementation here */
                alert("payment failed!"); console.log(result);
            },
            onClose: function(){
                /* You may add your own implementation here */
                alert('you closed the popup without finishing the payment');
            }
        })
    }
    payButton.addEventListener('click', {{ env('APP_ENV') == 'testing' ? 'mockSnapPay' : 'snapPay' }});
    </script>
</section>
@endsection
