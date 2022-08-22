@isset($products)
    <div class="cards">
        <div class="reel block">
            
            @foreach ($products as $product)
            <div class="tile">
                @include('Product._reel_card')
            </div>
            @endforeach

        </div>
    </div>
@endisset