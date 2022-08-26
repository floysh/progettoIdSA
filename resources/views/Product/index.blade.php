{{-- Visualizza tutti i prodotti passati--}}

@extends('layouts.app')


@section('title')
    {{ $tabname ?? $title }} - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')
<div class="section">
    
    {{-- Controlli Mercante --}}
    <div class="field mb-0 is-grouped is-grouped-right is-pulled-right">
        <div class="control">
            <a href="{{ action('ProductController@create') }}" class="button">
                <span class="icon">
                    <i class="fas fa-plus"></i>
                </span>
                <span>Nuovo prodotto</span>
            </a>
        </div>
    </div>

    <h2 class="title is-size-3">{{ $title }}</h2>
    
    <div class="container">
        <div class="list">
            @foreach ($products as $product)
                <div class="list-item block">
                    <div class="columns">
                        
                        <div class="column">
                            <div class="columns is-mobile">
                                <div class="column is-narrow">
                                    <div class="image is-64x64">
                                        <img src="{{ $product->imagePath() }}" alt="product image">
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="mb-3 is-size-5 has-text-bold">
                                        <a href="{{ action('ProductController@show', $product) }}">
                                            <strong>{{ $product->name }}</strong>
                                        </a>
                                    </div>
                                    
                                    <div class="columns is-multiline is-mobile is-size-6 has-text-bold">
                                        <div class="column is-narrow">
                                            <span class="icon"><i class="fas fa-question"></i></span>
                                            <span>{{ $product->category() }}</span>
                                        </div>
                                        <div class="column is-narrow">
                                            <span class="icon"><i class="fas fa-cubes"></i></span>
                                            <span>x {{ $product->quantity }}</span>
                                        </div>
                                        <span class="column is-narrow">
                                            <span class="icon"><i class="fas fa-coins"></i></span>
                                            <span> @currency($product->price) </span>
                                        </span>
                                    </div>
                    
                                    <div class="columns is-multiline is-mobile is-size-6 has-text-bold">
                                        <div class="column is-narrow">
                                            <span class="icon"><i class="fas fa-scale-balanced"></i></span>
                                            <span>Bottega di {{ $product->merchant->name ?? "un mercante eliminato" }}</span>
                                        </div>
                                    </div>
        
                                </div>
                            </div>
                        </div>

                        <div class="column is-narrow is-centered has-text-right">
                            @can('create', App\Models\Cart::class)
                                @include('Cart._add_to_cart')
                            @elsecan('edit|delete', App\Models\Product::class)
                                <div>TODO</div>
                            @endcan
                        </div>
                    </div>
                </div>
                <hr/>
            @endforeach
        </div>
    </div>

</div>
@endsection