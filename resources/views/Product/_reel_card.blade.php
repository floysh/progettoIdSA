@isset ($product)
    <a href="{{ action('ProductController@show', $product) }}">
        <div class="card p-4 is-unselectable">
            <div class="image block is-128x128 m-4">
                <img src="{{ $product->imagePath() }}" alt="">
            </div>
            <hr class="mt-0">
            <div class="container">
                <h6 class="title is-size-6 mb-4"><strong>{{ $product->name }}</strong></h6>
                <div class="field mb-5">
                    <div>
                        <span class="icon"><i class="fas fa-coins"></i></span>
                        <span>{{ $product->price }}</span>
                    </div>
                    <div>
                        <span class="icon"><i class="fas fa-filter"></i></span>
                        <span>{{ $product->category() }}</span>
                    </div>
                </div>
                <div class="field">
                    <form action="{{action('CartController@store')}}" method="POST">
                        @csrf()
                        <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" id="quantity" value="1">
                        <button type="submit" class="button is-primary">
                            <span class="icon">
                                <i class="fas fa-cart-arrow-down"></i>
                            </span>
                            <span>Aggiungi</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </a>
@endif