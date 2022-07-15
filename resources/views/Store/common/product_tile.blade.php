{{-- Tile di un prodotto, da includere con @include --}}

<div class="col-md-3 mb-3">
    <div class="card border">
        <div class="card-img-top">
            <a href="{{ route('ShowProduct', $product->id) }}">
            <div class="bg-image hover-overlay ripple" data-ripple-color="light">
                <img class="card-img-top"
                     src="{{ asset('images/prod/'.$product->imagepath) }}" alt="{{ $product->name }}">
            </a>
            </div>
        </div>

        <div class="card-body">
            <a href="{{ route('ShowProduct', $product->id) }}" class="text-decoration-none">
                <h5 class="card-title" href="{{ route('ShowProduct', $product->id) }}">
                    {{ $product->name }}
                </h5>
            </a>
            <h4 class="card-text">
                <span>{{ $product->price }}</span>
                <span><i class="fas fa-coins"></i></span>
            </h4>

        </div>

        <div class="card-footer">
            @if (Auth::check())
                @if ($product->isDisabled())
                <div class="container">
                    <div class="row">
                        <a class="btn btn-dark text-white">
                            <span>
                                <i class="fas fa-eye-slash"></i>
                            </span>
                            <span>Disattivato</span>
                        </a>
                    </div>
                </div>
                @else
                    @if($product->quantity == 0)
                    <div class="container">
                        <div class="row">
                            <div class="btn btn-grey text-danger" data-prod="{{ $product->id }}" id="product_{{ $product->id }}">
                                <span class="mr-1">
                                    <i class="fas fa-clock"></i>
                                </span>
                                <span>ESAURITO</span>
                            </div>
                        </div>
                    </div>

                    @else {{-- Mostra i pulsanti d'acquisto solo se il prodotto è disponibile e l'utente è cliente --}}
                        @if(Auth::user()->isMerchant())
                            <div class="container">
                                <div class="row">
                                    <div class="add-to-cart btn btn-grey font-weight-bold">
                                        <strong>ID prodotto: {{ $product->id }}</strong>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="container" id="in_cart_{{ $product->id}}">
                                <div class="row">
                                    <span><i class="fas fa-cart-arrow-down"></i></span>
                                    <span>Nel carrello</span>
                                </div>
                            </div>
                            <div class="container" id="add_to_cart_{{ $product->id}}">
                                <a
                                    class="btn btn-primary add-to-cart"
                                    href="{{ "TODO:CART_STORE" }}"
                                    data-prod="{{ $product->id }}" id="product_{{ $product->id }}">
                                    <span class="mr-1">Aggiungi</span>
                                    <span>
                                        <i class="fas fa-shopping-cart"></i>
                                    </span>
                                </a>
                            </div>
                        @endif
                    @endif
                @endif
            @else
                <span>Accedi per acquistare</span>
            @endif
        </div>
    </div>
</div>

