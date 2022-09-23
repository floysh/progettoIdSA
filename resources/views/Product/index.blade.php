{{-- Visualizza tutti i prodotti passati--}}

@extends('layouts.app')


@section('title')
    {{ $tabname ?? $title }} - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')
<div class="section">
    
    {{-- Controlli Mercante --}}
    <div class="field mb-0 is-grouped is-grouped-right is-pulled-right">
        @can('create', Product::class)
            <div class="control">
                <a href="{{ action('ProductController@create') }}" class="button">
                    <span class="icon">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span>Nuovo prodotto</span>
                </a>
            </div>
        @endcan
    </div>

    <h2 class="title is-size-3">{{ $title }}</h2>
    
    <div class="container">
        <div class="list">
            @foreach ($products as $product)
                <div class="list-item block">
                    @include('Product._product', ['product' => $product])
                </div>
                <hr/>
            @endforeach
        </div>
    </div>

</div>
@endsection