@extends('layouts.app')

@section('title')
    {{ $product->name }} - {{ config('app.name', 'ZonkoShop') }}
@endsection


@section('content')
    {{-- Mostra tutte le info sul prodotto qui --}}
    <h1>{{ $product->name }}</h1>

    <div class="container">
        <div class="row">
            <div class="col">
                <img src="{{ $product->category }}.png" alt="{{ $product->category }}.png">
            </div>
            <div class="col">
                <div class="mb-2">
                    <span class="label"><strong>Prezzo:</strong></span>
                    <span>{{ $product->price }}</span><span><i class="fas fa-coins"></i></span>
                </div>
                <div class="mb-2">
                    <span class="label"><strong>Disponibilità:</strong></span>
                    <span>{{ $product->quantity }}</span></span>
                </div>

                <div class="mb-2">
                    @if ($product->isNotAvailable())
                        <div>Non disponibile per l'acquisto</div>
                    @else
                        <form action="{{ action('CartController@store') }}" method="POST">
                            @csrf()
                            <input name="product_id" id="product_id" value="{{ $product->id }}" hidden>
                            <input type="number" name="quantity" id="quantity" value="1">
                            <button id="add-to-cart-btn" type="submit" class="btn btn-primary">Aggiungi al carrello</button>
                        </form>
                    @endif
                </div>
                <div class="mb-2">
                    <span><strong>Venduto da:</strong></span>
                    <span>$product->merchant->name</span>
                </div>

                <div class="mb-2">
                    <div class="label"><strong>Descrizione</strong></div>
                    <div class="content">
                        {{ $product->description }}
                    </div>
                </div>
                <div class="mb-2">
                    <span><strong>Categoria</strong></span>
                    <span>{{ $product->categories()[$product->category] }}</span>
                </div>
                <!-- TEST -->
                <div class="mb-2">
                    <a href="{{ action('ProductController@edit',$product) }}" class="btn btn-dark">
                        <span><i class="fas fa-edit"></i></span>
                        <span>Modifica</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
    
    

@endsection
