<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src={{ asset('js/jquery-3.3.1.js') }}></script>
    <script src={{ asset('js/zonkoshop.js') }}></script>
    
    @yield('page-javascript')

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('page-css')

</head>
<body class="has-navbar-fixed-top">
    <div id="app">
        
        @include('common.navbar.navbar')

        <main class="py-4">
            <div class="container mb-4">
                <!-- Alert bar for errors -->
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <h4 class="alert-heading">Si sono verificati alcuni errori</h4>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li><b>{{ $error }}</b></li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>

            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>


</body>
</html>
