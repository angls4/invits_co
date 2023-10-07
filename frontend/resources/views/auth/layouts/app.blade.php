@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center h-full sm:justify-center">
    <div class="w-full px-6 py-4 my-6 overflow-hidden shadow-md bg-brand-purple-100 sm:max-w-md sm:rounded-lg">
        <div class="mb-5 text-center">
            @yield('header')
        </div>
        @yield('card-content')
    </div>
</div>
@endsection 