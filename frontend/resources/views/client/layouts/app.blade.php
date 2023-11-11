<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    {{-- <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/favicon.png')}}"> --}}
    <meta name="keyword" content="">
    <meta name="description" content="">

    <!-- Shortcut Icon -->
    {{-- <link rel="shortcut icon" href="{{asset('img/favicon.png')}}"> --}}
    {{-- <link rel="icon" type="image/ico" href="{{asset('img/favicon.png')}}" /> --}}

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Invits.co | {{ $title }}</title>

    {{-- font & icons --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    @stack('before-styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('after-styles')
</head>

<body 
    x-data="sidebar()"
    class="text-gray-700 bg-gray-200"
    @resize.window="handleResize()"
>
    @yield('data')
    <!-- Sidebar -->
    <div class="xl:flex" x-data={{$alpineData ?? ""}}>
        @include('client.layouts._sidebar', ['data' => $phpData ?? ""])
        <!-- /Sidebar -->
        <div class="flex flex-col w-full min-h-screen">
            @include('client.layouts._header')
            @yield('content')
            @include('client.layouts._footer')
        </div>
    </div>

    <!-- Scripts -->
    @stack('before-scripts')
    <script>
        function sidebar() {
            const breakpoint = 1280
            return {
                open: {
                    above: true,
                    below: false,
                },
                isAboveBreakpoint: window.innerWidth > breakpoint,

                handleResize() {
                    this.isAboveBreakpoint = window.innerWidth > breakpoint
                },
                isOpen() {
                    if (this.isAboveBreakpoint) {
                        return this.open.above
                    }
                    return this.open.below
                },
                handleOpen() {
                    if (this.isAboveBreakpoint) {
                        this.open.above = true
                    }
                    this.open.below = true
                },
                handleClose() {
                    if (this.isAboveBreakpoint) {
                        this.open.above = false
                    }
                    this.open.below = false
                },
                handleAway() {
                    if (!this.isAboveBreakpoint) {
                        this.open.below = false
                    }
                },
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.0.2/glide.js"></script>
    
    @stack('after-javascript')
    <!-- / Scripts -->

</body>

</html>