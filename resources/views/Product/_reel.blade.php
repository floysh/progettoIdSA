<div class="cards">
    <div class="reel block mb-5">
        
        @for ($i = 0; $i < 6; $i++)
        <div class="tile">
                @include('Product._reel_card')
            </div>
        @endfor

    </div>
</div>