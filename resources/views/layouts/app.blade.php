<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Zonko Shop'))</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    {{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap"/> --}}
    {{-- <link href='https://fonts.googleapis.com/css?family=Product+Sans' rel='stylesheet' type='text/css'> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/mdb.min.css')}}" />
    <link href="{{ asset('css/stile2.css') }}" rel="stylesheet">


    @yield('page-css')

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light">
            <div class="container">

                {{-- ZONKO Logo --}}
                <div class="col-md-3">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <!--{{ config('app.name', 'Zonko Shop') }}-->
                        <img src={{ asset('images/zonkologo.png') }} style="max-height: 5rem;">
                    </a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                {{-- Search bar --}}
                <div class="col-md-5">
                    <div class="box_search" >
                        <form class="d-flex input-group w-auto" action="{{ "/TODO" }}" method="GET">
                            <input type="search" name="prodotto" id="search" class="form-control" placeholder="Cerca un prodotto">
                            <button class="btn btn-outline-primary ripple-surface ripple-surface-light" type="submit" data-ripple-color="dark">
                                <span class="fa fa-search" width="25" height="25" id="active_search"></span>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            @if(Auth::check() && Auth::user()->isMerchant())
                            <span class="badge badge-success">MASTER</span>
                            @endif
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            @if ( !Auth::check() || !Auth::user()->isMerchant() )
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ "TODO:CUSTOMER_CART" }}">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                            @endif
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Accedi</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">Registrati</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right border" aria-labelledby="navbarDropdown">
                                        @if(Auth::user()->isMerchant())
                                            <a class="dropdown-item" href="{{ "/TODO:MERCHANT_HOME" }}">
                                                Dashboard
                                            </a>
                                            <a class="dropdown-item" href="{{ "/TODO:MERCHANT_HIDDEN_PAGE" }}">
                                                Prodotti nascosti
                                            </a>
                                            <a class="dropdown-item" href="{{ "/TODO:MERCHANT_REFILL_PAGE" }}">
                                                Rifornimento bottega
                                            </a>
                                            <a class="dropdown-item" href="{{ "TODO:MERCHANT_ORDERS" }}">
                                                Ordini clienti
                                            </a>
                                        @else
                                            <p class="dropdown-item disabled">
                                                <span id="user-money">@currency(Auth::user()->money)</span>
                                                <span><i class="fas fa-coins"></i></span>
                                            </p>
                                            <a class="dropdown-item" href="{{ "TODO:CUSTOMER_CART" }}">
                                                <span>Il mio carrello</span>
                                            </a>
                                            <a class="dropdown-item" href="{{ "TODO:CUSTOMER_ORDERS" }}">
                                                I miei ordini
                                            </a>
                                        @endif
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>

            </div>

        </nav>


        <nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse justify-content-center" id="navbarCenteredExample">
                <!-- Left links -->
                <ul class="navbar-nav mb-2 mb-lg-0">
                    @php
                        $categories = App\Models\Product::categories() //App\Category::orderBy('name')->get();
                    @endphp
                    @foreach ($categories as $key => $category)
                        <li>
                            <span class="col-md-3">
                                <a class="btn btn-link btn-lg " data-ripple-color="dark" {{-- style="color: #f20707;" --}}
                                href="{{ "/TODO:CATEGORY_VIEW/".$key }}">{{ $category }}</a>
                            </span>
                        </li>
                    @endforeach
                </ul>
                </div>
            </div>
        </nav>



        <main class="py-4">
            <div class="container mb-4">
                <!-- Alert bar for errors -->
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <h4 class="alert-heading">Si sono verificati alcuni errori</h4>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li><b>{{ $error }}</b></li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>

            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

    <script type="text/javascript" src="{{ asset('js/mdb.min.js') }}"></script>
    <script src={{ asset('js/zonkoshop.js') }}></script>
    
    @yield('page-javascript')


</body>
</html>
