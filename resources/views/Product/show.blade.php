@extends('layouts.app')

@section('title')
    {{ $product->name }} - {{ config('app.name', 'ZonkoShop') }}
@endsection


@section('content')
    <div class="section">
        <div class="columns">
            <div class="column is-4 is-flex is-justify-content-center p-0">
                <div class="image pt-5" style="max-width: 256px">
                    @php
                        $image_path = 'images/products/'.$product->imagepath;
                    @endphp
                    <img src="{{ file_exists($image_path) ? asset($image_path) : asset('images/dummy.png') }}" alt="product">
                </div>
            </div>
            <div class="column section pt-4">
                <h3 class="title is-size-3">{{ $product->name }}</h3>
                
                <div class="columns is-multiline is-mobile is-size-5 has-text-bold">
                    <div class="column is-narrow">
                        <span class="icon"><i class="fas fa-question"></i></span>
                        <span>{{ \App\Models\Product::categories()[$product->category] }}</span>
                    </div>
                    <div class="column is-narrow">
                        <span class="icon"><i class="fas fa-cubes"></i></span>
                        <span>{{ $product->quantity }} unità disponibili</span>
                    </div>
                    <span class="column is-narrow">
                        <span class="icon"><i class="fas fa-coins"></i></span>
                        <span>{{ $product->price }}</span>
                    </span>
                </div>

                <div class="columns is-multiline is-mobile is-size-5 has-text-bold">
                    <div class="column is-narrow">
                        <span class="icon"><i class="fas fa-store"></i></span>
                        <span>$product->merchant->name</span>
                    </div>
                </div>

                
                {{-- Aggiungi al carrello --}}
                @if ($product->isNotAvailable())
                    <div class="notification content is-warning is-light">
                        <div class="is-size-5">Non disponibile</div>
                        <p>Questo prodotto non può essere acquistato perchè il mercante non lo permette.</p>
                    </div>
                @elseif($product->quantity == 0)
                    <div class="notification content is-danger is-light">
                        <div class="is-size-5 has-text-danger">Scorte esaurite</div>
                        <p>Questo prodotto non può essere acquistato perchè il mercante non ne ha più in magazzino.</p>
                    </div>
                @else
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
                                    <button id="add-to-cart-btn" type="submit" class="button is-primary">Aggiungi al carrello</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif

                {{-- Controlli Mercante --}}
                <div class="container block">
                    <div class="field is-grouped">
                        <div class="control">
                            <a href="{{ action('ProductController@edit', $product) }}" class="button is-dark">
                                <span class="icon">
                                    <i class="fas fa-edit"></i>
                                </span>
                                <span>Modifica</span>
                            </a>
                        </div>
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
                    </div>
                </div>
                <div class="container block">
                    <form action="{{ action('ProductController@update', $product) }}" method="POST">
                        @csrf()
                        @method('PATCH')

                        <div class="field is-grouped">
                            <div class="control">
                                <label class="label" for="quantity">Aggiungi scorte</label>
                                <input class="input" type="number" name="quantity" id="quantity" value="" min="1">
                            </div>
                            <div class="control is-flex is-align-items-flex-end">
                                <input name="product_id" id="product_id" value="{{ $product->id }}" hidden>
                                <button id="restock-btn" type="submit" class="button is-primary">
                                    <span class="icon">
                                        <i class="fas fa-plus"></i>
                                    </span>
                                    <span>Rifornisci scorte</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div class="notification content">
            <h5 class="title is-size-5">Descrizione</h5>
            <p>{{ $product->description }}</p>
        </div>
    </div>
@endsection
