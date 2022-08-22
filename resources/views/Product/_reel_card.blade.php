<a href="/products/3">
    <div class="card p-4 is-unselectable">
        <div class="image block is-128x128 m-4">
            <img src="/images/products/green-potion.svg" alt="">
        </div>
        <hr class="mt-0">
        <div class="container">
            <h6 class="title is-size-6 mb-4"><strong>Lorem Ipsum</strong></h6>
            <div class="field mb-5">
                <div>
                    <span class="icon"><i class="fas fa-coins"></i></span>
                    <span>9999.54</span>
                </div>
                <div>
                    <span class="icon"><i class="fas fa-filter"></i></span>
                    <span>Lorem</span>
                </div>
            </div>
            <div class="field">
                <form action="{{action('CartController@store')}}" method="POST">
                    @csrf()
                    <input type="hidden" name="product_id" id="product_id" value="3">
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