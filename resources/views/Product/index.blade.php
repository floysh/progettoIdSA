{{-- Visualizza tutti i prodotti passati--}}

@extends('layouts.app')

@section('title')
    {{ $tabname }} - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')
<h2 class="mb-4 font-weight-bold">{{ $title }}</h2>
<div class="container">

    <div class="card-deck">
        @foreach ($products as $product)
                @include('Store.common.product_tile', ['product' => $product])
        @endforeach
    </div>

</div>
@endsection