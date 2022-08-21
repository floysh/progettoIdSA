{{-- Visualizza tutti i prodotti passati--}}

@extends('layouts.app')

@section('title')
    {{ $tabname }} - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')
<div class="section">
    <h2 class="title is-size-3">{{ $title }}</h2>
    
    <div class="container">
        <div class="list">
            @foreach ($products as $product)
                <div class="list-item block">
                    <div class="columns">
                        <div class="column is-1">
                            <img src="/images/prod/{{ $product->category }}.png" alt="{{ $product->category }}">
                        </div>
                        <div class="column">
                            <div class="is-size-5 has-text-bold">
                                <a href="{{ action('ProductController@show', $product) }}">
                                    <strong>{{ $product->name }}</strong>
                                </a>
                            </div>
                            <div class="is-size-5 has-text-bold">
                                <span class="mr-5">
                                    <span class="icon"><i class="fas fa-coins"></i></span>
                                    <span>{{ $product->price }}</span>
                                </span>
                                <span class="ml-5 mr-5">
                                    <span class="icon"><i class="fas fa-cubes"></i></span>
                                    <span>x {{ $product->quantity }}</span>
                                </span>
                            </div>
                        </div>
                        <div class="column is-narrow has-text-right">
                            @if ($product->isNotAvailable())
                                <div class="field">
                                    <div class="level container-fluid">
                                        <div class="level-item">
                                            <strong>Non disponibile</strong>
                                        </div>
                                    </div>
                                </div>
                            @elseif($product->quantity == 0)
                                <div class="field">
                                    <div class="level container-fluid">
                                        <div class="level-item">
                                            <strong>Esaurito</strong>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <form action="{{ action('CartController@store') }}" method="POST">
                                    @csrf()
                                    <input name="product_id" id="product_id" value="{{ $product->id }}" hidden>

                                    <div class="field is-grouped">
                                        <div class="control">
                                            {{-- <input type="number" name="quantity" id="quantity" value="1" class="input" max="{{ $product->quantity }}"> --}}
                                        </div>
                                        <div class="control has-icons-left">
                                            <div class="select">
                                                <select id="quantity" name="quantity">
                                                    @for ($i = 1; $i <= $product->quantity; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                    </select>
                                                </div>
                                                <span class="icon is-left">
                                                    <i class="fas fa-box"></i>
                                                </span>
                                            </div>
                                            <div class="control">
                                                <button id="add-to-cart-btn" type="submit" class="button is-primary">
                                                    <span class="icon">
                                                        <i class="fas fa-cart-arrow-down"></i>
                                                    </span>
                                                    <span>Aggiungi al carrello</span>
                                                </button>
                                            </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection