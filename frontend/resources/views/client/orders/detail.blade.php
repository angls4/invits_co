@extends('layouts.app')

@section('content')
<main class="py-3 bg-white grow">
    <section class="py-10">
        <div class="container">
            <div class="flex justify-between py-4 mt-5 rounded-md px-7 bg-brand-purple-100">
                <strong>ID Transaksi</strong>
                <span>
                    {{ $data['order']->payment->transaction_id }}
                </span>
            </div>
            <div class="py-4 mt-8 rounded-md px-7 bg-brand-purple-100">
                <div>
                    <strong>Nama</strong>
                    <p>{{  $data['order']->user->name }}</p>
                </div>
                <div>
                    <strong>Email</strong>
                    <p>{{ $data['order']->user->email }}</p>
                </div>
                <div>
                    <strong>Tema Undangan</strong>
                    <p>{{ $data['order']->theme->name }}</p>
                </div>
                <div>
                    <strong>Pilihan Paket</strong>
                    <p>{{ $data['order']->package->name }}</p>
                </div>
                <div>
                    <div>
                        <span class="my-0 leading-tight"><?= $data['order']->package->features; ?></span>
                    </div>
                </div>     
            </div>
            <div class="py-4 mt-8 rounded-md px-7 bg-brand-purple-100">
                <div class="flex justify-between mb-2">
                    <strong>Metode Pembayaran</strong>
                    <span>{{ $data['order']->payment->type }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <strong>Waktu Transaksi</strong>
                    <span>{{ Carbon\Carbon::parse($data['order']->payment->transaction_time)->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <strong>Harga Total</strong>
                    <span>@rupiah($data['order']->payment->total_price)</span>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection