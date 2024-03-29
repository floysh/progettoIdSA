@extends('layouts.app')

@section('title')
    {{ $product->name }} - {{ config('app.name', 'ZonkoShop') }}
@endsection


@section('content')
    <div class="section">
        <div class="columns">
            <div class="column is-4 is-flex is-justify-content-center p-0">
                <div class="image pt-5 pb-6" style="max-width: 256px">
                    <img src="{{ $product->imagePath() }}" alt="product image">
                </div>
            </div>
            <div class="column pt-4">
                <h3 class="title is-size-3">{{ $product->name }}</h3>
                
                <div class="container mb-5">
                    <div class="columns is-multiline is-mobile is-size-5 has-text-bold">
                        <div class="column is-narrow">
                            <span class="icon"><i class="fas fa-question"></i></span>
                            <span>{{ $product->category() }}</span>
                        </div>
                        <div class="column is-narrow">
                            <span class="icon"><i class="fas fa-cubes"></i></span>
                            <span>{{ $product->quantity }} unità disponibili</span>
                        </div>
                    </div>
    
                    <div class="columns is-multiline is-mobile is-size-5 has-text-bold">
                        <div class="column is-narrow">
                            <span class="icon"><i class="fas fa-scale-balanced"></i></span>
                            <span>Bottega di {{ $product->merchant->name ?? "un mercante eliminato" }}</span>
                            <span> (ID: {{ $product->merchant_id ?? null }})</span>
                        </div>
                    </div>
                </div>

                <div class="container block p-4">
                    <div class="content is-size-3">
                        <span class="icon mr-2"><i class="fas fa-coins"></i></span>
                        <span> @currency($product->price) </span>
                    </div>
                </div>

                
                {{-- Aggiungi al carrello --}}
                @if ($product->isNotAvailable())
                    <div class="notification content is-grey is-light">
                        <div class="is-size-5">Non disponibile per l'acquisto</div>
                        <p>Questo prodotto non può essere acquistato perchè il mercante non lo permette.</p>
                    </div>
                @elseif($product->quantity == 0)
                    <div class="notification content is-warning is-light">
                        <div class="is-size-5 has-text-warning">Scorte esaurite</div>
                        <p>Questo prodotto non può essere acquistato perchè il mercante non ne ha più in magazzino.</p>
                    </div>
                @elsecan('create', App\Models\Cart::class)
                    <div class="container block">
                        <form action="{{ action('CartController@store') }}" method="POST">
                            @csrf()
                            <div class="field is-grouped">
                                <div class="control">
                                    <label class="label" for="quantity">Quantità</label>
                                    <input class="input" type="number" name="quantity" id="quantity" value="1" max="{{$product->quantity}}">
                                </div>
                                <div class="control is-flex is-align-items-flex-end">
                                    <input name="product_id" id="product_id" value="{{ $product->id }}" hidden>
                                    <button id="add-to-cart-btn" dusk="add-to-cart" type="submit" class="button is-primary">Aggiungi al carrello</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                @endif

                {{-- Controlli Mercante --}}
                <div class="container block">
                    <div class="field is-grouped">
                        @can('update', $product)
                            <div class="control">
                                <a href="{{ action('ProductController@edit', $product) }}" class="button">
                                    <span class="icon">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                    <span>Modifica</span>
                                </a>
                            </div>
                        @endcan
                        @can('delete', $product)
                            <div class="control">
                                <form action="{{ action('ProductController@destroy', $product) }}" method="post">
                                    @csrf()
                                    @method('DELETE')
                                    <button class="button is-danger" type="submit">
                                        <span class="icon">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span>Elimina</span>
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
                @can('update', $product)
                    <div class="container block">
                        <form action="{{ action('ProductController@refill', $product) }}" method="POST">
                            @csrf()
                            @method('PATCH')

                            <div class="field is-grouped">
                                <div class="control">
                                    <label class="label" for="quantity">Aggiungi scorte</label>
                                    <input class="input" type="number" name="quantity" id="quantity" value="" min="1">
                                </div>
                                <div class="control is-flex is-align-items-flex-end">
                                    <input name="product_id" id="product_id" value="{{ $product->id }}" hidden>
                                    <button id="restock-btn" type="submit" class="button">
                                        <span class="icon">
                                            <i class="fas fa-cubes"></i>
                                        </span>
                                        <span>Rifornisci</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endcan

            </div>
        </div>
        <div class="notification content mt-6">
            <h5 class="title is-size-5">Descrizione</h5>
            <p>{!! nl2br(e($product->description)) !!}</p>
        </div>
    </div>
@endsection
