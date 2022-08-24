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
<body class="has-navbar-fixed-top is-unselectable">
    <div id="app">
        
        @include('common._navbar')

        {{-- Success messages --}}
        @if(Session::has('success'))
            <div class="section container pb-0">
                <div class="message is-success is-light">
                    <div class="message-body">
                        <div class="content">
                            <p class="is-size-4">{{ Session::get('success') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Error messages --}}
        @if ($errors->any())
            <div class="section container pb-0">
                <div class="message is-danger is-light">
                    <div class="message-body">
                        <div class="content">
                            <p class="is-size-4">Si sono verificati alcuni errori:</p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li><b>{{ $error }}</b></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
            
        <main class="container">
            @yield('content')
        </main>
    </div>


</body>
</html>
