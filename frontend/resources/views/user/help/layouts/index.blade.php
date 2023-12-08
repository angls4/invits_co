@extends('layouts.app')

@section('content')
<section class="py-6">
    <div class="container text-justify">
        <h1 class="mb-4 text-4xl text-center">{{ $title }}</h1>
        @yield('help-content')
    </div>
</section>
@endsection