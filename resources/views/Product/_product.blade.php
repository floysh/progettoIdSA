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
                    @if ($product->isNotAvailable())
                        <span class="column is-narrow">
                            <span class="icon"><i class="fas fa-user-ninja"></i></span>
                            <span> Non acquistabile </span>
                        </span>
                    @endif
                    @unless ($product->merchant->is(Auth::user()))
                        <div class="column is-narrow">
                            <span class="icon"><i class="fas fa-scale-balanced"></i></span>
                            <span>Bottega di {{ $product->merchant->name ?? "un mercante eliminato" }}</span>
                        </div>
                    @endunless
                </div>

                {{-- @unless ($product->merchant->is(Auth::user()))
                    <div class="columns is-multiline is-mobile is-size-6 has-text-bold">
                        <div class="column is-narrow">
                            <span class="icon"><i class="fas fa-scale-balanced"></i></span>
                            <span>Bottega di {{ $product->merchant->name ?? "un mercante eliminato" }}</span>
                        </div>
                    </div>
                @endunless --}}
                <div class="is-size-4">
                    <span class="icon"><i class="fas fa-coins"></i></span>
                    <span> @currency($product->price) </span>
                </div>

            </div>
        </div>
    </div>

    <div class="column is-narrow is-centered has-text-right">
        @can('create', App\Models\Cart::class)
            @include('Cart._add_to_cart')
        @elsecanany(['update','delete'], $product)
            <div class="container">
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
                    @can('update', $product)
                        <div class="control">
                            <a href="{{ action('ProductController@edit', $product) }}" class="button">
                                <span class="icon"><i class="fas fa-edit"></i></span>
                                <span>Modifica</span>
                            </a>
                        </div>
                    @endcan
                    @can('delete', $product)
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
                    @endcan
                </div>
            </div>
        @endcan
    </div>
</div>