@extends('layouts.app')

@section('content')
    <div class="section">
        <div class="block">
            <div class="columns is-mobile">
                <div class="column is-flex is-align-items-center">
                    <div class="content">
                        <div class="title is-size-4">Bottega di {{ Auth::user()->name }}</div>
                        <div class="subtitle is-size-5 mb-3">{{ Auth::user()->products->count() }} prodotti nel catalogo</div>
                    </div>
                </div>
                <div class="column is-narrow is-hidden-mobile">
                    <div class="block image is-96x96">
                        <img src="{{ asset('images/merchant.svg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="content block mb-6">
            <a href="{{ action('ProductController@create') }}" class="button">
                <span class="icon"><i class="fas fa-plus"></i></span>
                <span>Nuovo prodotto</span>
            </a>
        </div>

        <div class="container list">
            @forelse ($products as $product)
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
                                        @if ($product->isNotAvailable())
                                            <div class="column is-narrow">
                                                <span class="icon"><i class="fas fa-user-ninja"></i></span>
                                                <span>Non acquistabile</span>
                                            </div>
                                        @endif
                                    </div>
        
                                </div>
                            </div>
                        </div>

                        <div class="column is-narrow">
                            <div class="field">
                                <form action="{{ action('ProductController@refill', $product) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="field has-addons">
                                        <div class="control">
                                            <input type="number" class="input" name="quantity" placeholder="0">
                                        </div>
                                        <div class="control">
                                            <button type="submit" class="button">
                                                <span class="icon"><i class="fas fa-cubes"></i></span>
                                                <span>Rifornisci</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="field is-grouped">
                                <div class="control">
                                    <a href="{{ action('ProductController@edit', $product) }}" class="button">
                                        <span class="icon"><i class="fas fa-edit"></i></span>
                                        <span>Modifica</span>
                                    </a>
                                </div>
                                @if ($product->isAvailable())
                                    <div class="control">
                                        <form action="{{ action('ProductController@destroy', $product) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="button is-danger">
                                                <span class="icon"><i class="fas fa-trash"></i></span>
                                                <span>Rimuovi</span>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            @empty
                <div class="section">
                    <h4 class="subtitle block">Non hai ancora inserito prodotti nel catalogo</h4>
                </div>
            @endforelse
        </div>
    </div>
@endsection