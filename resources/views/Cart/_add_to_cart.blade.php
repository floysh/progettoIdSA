@if ($product->isNotAvailable())
    <div class="field">
        <div class="control">
            <div class="input is-static is-disabled">
                <strong class="has-text-danger mr-5">Non disponibile</strong>
            </div>
        </div>
    </div>
@elseif ($product->quantity == 0)
    <div class="field">
        <div class="control">
            <div class="input is-static is-disabled">
                <strong class="mr-5">Scorte esaurite</strong>
            </div>
        </div>
    </div>
@else
    <form action="{{ action('CartController@store') }}" method="POST">
        @csrf()
        <input name="product_id" id="product_id" value="{{ $product->id }}" hidden>

        <div class="field is-grouped">
            <div class="control has-icons-left">
                <div class="select {{ $sizeClass ?? '' }}">
                    <select id="quantity" name="quantity">
                        @for ($i = 1; $i <= $product->quantity; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                        </select>
                    </div>
                <span class="icon is-left">
                    <i class="fas fa-box"></i>
                </span>
            </div>
            <div class="control">
                <button type="submit" class="button is-primary {{ $sizeClass ?? '' }}">
                    <span class="icon">
                        <i class="fas fa-cart-arrow-down"></i>
                    </span>
                    <span>{{ $buttonText ?? "Aggiungi al carrello" }}</span>
                </button>
            </div>
        </div>
    </form>
@endif
