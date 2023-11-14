@php
    $link =  config('app.url') . '/' . $data['invitation']->slug;
@endphp

<x-mail::message>
# Undangan

Yth.
Saudara/Saudari {{ $data['guest']->name }}

Kami yang berbahagia {{ $data['wedding']->groom->name }} dan {{ $data['wedding']->bride->name }}, mengundang Saudara/Saudari untuk hadir di pemberkatan nikah kami, pada:

<table style="border-collapse: collapse;">
    <tr>
        <td>Hari dan Tanggal </td>
        <td>:</td>
        <td>@dateID($data['wedding']->event[0]->date)</td>
    </tr>
    <tr>
        <td>Pukul</td>
        <td>:</td>
        <td>{{ $data['wedding']->event[0]->start_time }}</td>
    </tr>
    <tr>
        <td>Lokasi</td>
        <td>:</td>
        <td>{{ $data['wedding']->location }}</td>
    </tr>
    <tr>
        <td>Link Undangan</td>
        <td>:</td>
        <td>{{ $link }}</td>
    </tr>
</table>
<br>

Akan menjadi suatu kehormatan apabila Saudara/Saudari berkenan hadir di acara kami.

<x-mail::button :url="$link">
Lihat Undangan
</x-mail::button>

Salam Hormat,<br>
Keluarga {{ $data['wedding']->groom->name }} dan keluarga {{ $data['wedding']->bride->name }}
</x-mail::message>
