{{-- Carrello dell'utente --}}

@extends('layouts.app')

@section('title')
{{$cart->count()}} - Il mio carrello - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')
    <div class="container">
        @if ($cart->count() == 0)
            <div class="row">
                <div class="col mb-5 justify-content-center d-none d-lg-inline">
                    <img src="{{ asset('images/emptycart-alt.jpg') }}" alt="" class="img-fluid" style="height: 40rem">

                </div>
                <div class="col-lg-6 mb-4 text-center text-lg-left d-flex align-items-center">
                    <div class="col">
                        <div class="padding d-lg-none d-block mt-5"></div>
                        <h1 class="title mb-4">Il carrello è vuoto</h1>
                        <p>
                            Quando trovi qualcosa che ti interessa fai click su <strong>Aggiungi al carrello<strong>
                        </p>
                    </div>
                </div>
            </div>

        @else
        <ul class="list-group">
            <div class="mb-3">
                <h1>Il mio carrello</h1>
            </div>
            @php
                $total = 0.0;
            @endphp
            @foreach ($cart as $item)
            <div class="list-group-item cart-item border" id="cart-{{ $item->id }}">
                <div class="" style="padding: 0.4rem">
                    <div class="d-flex w-100 justify-content-between">
                        <h4 class="mb-1">
                            <a href="{{ action('ProductController@show',$item->product_id) }}">
                                {{ $item->product->name }}
                            </a>
                        </h4>
                        <span>
                            <a class="remove-from-cart btn btn-sm btn-link btn-rounded text-danger"
                                href="{{ action('CartController@destroy',$item->id) }}"
                                data-id={{ $item->id }} data-ripple-color="danger"
                            >
                                <span><i class="fas fa-times"></i></span>
                            </a>
                        </span>
                    </div>
                    <br>
                    <div class="d-flex w-100 justify-content-between">
                        <span>
                            <span class="mr-2">Quantità</span>
                            <span class="mr-2">
                                <select name="quantity"
                                class="edit-quantity select"
                                route="{{ action('CartController@update',$item->id) }}"
                                data-id="{{ $item->id }}"
                                >
                                    @for ($i=1; $i <= ($item->product_quantity + $item->quantity); $i++)
                                        <option value="{{ $i }}"
                                        @if($item->quantity == $i)
                                            selected
                                        @endif
                                        >{{ $i }}</option>
                                    @endfor
                                </select>
                            </span>
                        </span>

                        <span class="h5">
                            <span id="item-{{ $item->id }}-price" class="mr-1" >@currency($item->price())</span>
                            <span><i class="fas fa-coins"></i></span>
                        </span>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="mb-4"></div>

            <div class="row" style="padding: 0.4rem">
                <div class="d-flex w-100 justify-content-between mb-3">
                    <div class="h3">Totale</div>
                    <h3>
                        <span id="purchase-total-amount" class="mr-1">@currency(App\Models\Cart::getTotalPrice())</span>
                        <span><i class="fas fa-coins"></i></span>
                    </h3>
                </div>
        @endif
    </div>

