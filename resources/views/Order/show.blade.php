@extends('layouts.app')

@section('title')
    Dettagli ordine n.{{ $order->id }} - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')
    <div class="section">
        @include('Order._order')
    </div>
@endsection