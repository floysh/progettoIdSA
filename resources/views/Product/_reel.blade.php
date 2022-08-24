@isset($products)
    <div class="cards">
        <div class="reel block">
            
            @foreach ($products as $product)
                @include('Product._reel_card')
            @endforeach

        </div>
    </div>
@endisset