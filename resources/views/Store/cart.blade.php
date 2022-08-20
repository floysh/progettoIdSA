{{-- Carrello dell'utente --}}

@extends('layouts.app')

@section('title')
Carrello ({{$cart->count()}}) - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')

<div class="section container">
    @if (empty($cart))
        <div class="columns">
            <div class="column">
                <img src="{{ asset('images/emptycart-alt.jpg') }}" alt="" class="img-fluid" style="height: 40rem">
            </div>
            <div class="column is-flex is-align-items-center">
                <div class="container">
                    <h1 class="title is-size-3">Il carrello è vuoto</h1>
                    <p>
                        Quando trovi qualcosa che ti interessa fai click su <strong>Aggiungi al carrello<strong>
                    </p>
                </div>
            </div>
        </div>
        
    @else
        <h3 class="title is-size-3">Carrello</h3>
        
        <div class="list block">
            @foreach ($cart as $item)
                <div class="list-item cart-item block" id="cart-{{ $item->id }}">
                    <div class="columns">
                        <div class="column is-1">
                            <img src="/images/prod/{{ $item->product->category }}.png" alt="{{ $item->product->category }}">
                        </div>
                        <div class="column">
                            <div class="block is-size-5 has-text-bold">
                                <a href="{{ action('ProductController@show', $item->product) }}">
                                    <strong>{{ $item->product->name }}</strong>
                                </a>
                            </div>
                            <div class="is-size-6">
                                <span><i class="fas fa-user"></i></span>
                                <span>Helga Maga di Test-a</span>
                            </div>
                            <div class="is-size-6">
                                <span><i class="fas fa-coins"></i></span>
                                <span>{{ $item->product->price }}</span>
                            </div>
                        </div>

                        <div class="column is-narrow">
                            <div class="block padding"></div>
                            {{-- <div class="block is-size-5 has-text-bold">
                                <span class="mr-5">
                                    <span>{{ $item->quantity * $item->product->price }}</span>
                                    <span class="icon"><i class="fas fa-coins"></i></span>
                                </span>
                            </div> --}}
                            <span class="block ml-4">
                                {{-- <strong><span>x {{ $item->quantity }}</span></strong> --}}
                                <form action="{{ action('CartController@update', $item) }}" method="POST" id="cart-edit-{{ $item->id }}-form">
                                    @method('PATCH')
                                    @csrf()
                                    
                                    <div class="field is-grouped">
                                        <div class="control">
                                            <label class="label">Quantità</label>
                                            <div class="select">
                                                <select name="quantity" 
                                                        onchange="event.preventDefault();
                                                                document.getElementById('cart-edit-{{ $item->id }}-form').submit();">
                                                    
                                                    @for ($i = 1; $i <= ($item->quantity + $item->product->quantity); $i++)
                                                        <option value="{{$i}}" 
                                                            @if($item->quantity == $i)
                                                                selected
                                                            @endif>{{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control ml-5">
                                            <label class="label">Prezzo</label>
                                            <div class="is-size-5">
                                                <span><i class="fas fa-coins"></i></span>
                                                <span><strong>{{ $item->product->price }}</strong></span>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </span>
                        </div>
                        
                        <div class="column is-narrow has-text-right">
                            <form action="{{ action('CartController@destroy',$item->id) }}" method="POST">
                                @method('DELETE')
                                @csrf()
                                <button type="submit" class="button is-small is-danger is-light">
                                    <span><i class="fas fa-times"></i></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <hr> 
            @endforeach
        </div>

        <hr>

        <div class="container has-text-right">
            <div class="block is-size-4 mt-4">
                <span><strong>Totale:</strong></span>
                <span>@currency(App\Models\Cart::getCheckoutPrice())</span>
                <span><i class="fas fa-coins"></i></span>
            </div>
            <div class="justify-content-end d-flex">
                <form action="{{ action('OrderController@store') }}" method="POST">
                    @csrf()
                    <button id="purchase" type="submit" class="button is-primary">
                        Conferma acquisto
                    </button>
                </form>
            </div>
        </div>
    
    @endif
</div>
@endsection()