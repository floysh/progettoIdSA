{{-- Info --}}
<div class="columns">
    <div class="column">
        <p class="heading">Numero ordine</p>
        <p class="title is-size-6">#{{$order->id}}</p>
    </div>
    @if (Auth::user()->isMerchant())
    <div class="column">
        <p class="heading">Cliente</p>
        <p class="title is-size-6">{{ $order->user->name }}</p>
    </div>
    @endif
    @if (Auth::user()->isCustomer())
    <div class="column">
        <p class="heading">Numero di prodotti acquistati</p>
        <p class="title is-size-6">{{ $order->products()->count() }}</p>
    </div>
    @endif
    <div class="column is-narrow">
        <p class="heading">Effettuato il</p>
        <p class="title is-size-6">{{ $order->created_at }}</p>
    </div>
</div>
<hr/>
{{-- Elenco prodotti --}}
<div class="content">
<table class="table is-hoverable">
    <thead>
        <th></th>
        <th>Prodotto</th>
        <th>Q.tà ordinate</th>
        @if (Auth::user()->isCustomer())
            <th>Mercante</th>
        @endif
        @if (Auth::user()->isMerchant())
            <th>Q.tà rimaste</th>
        @endif
        <th></th>
    </thead>
    <tbody>
    @foreach ($order->products as $product)
        @if (Auth::user()->isCustomer() || Auth::user()->isMerchant() && Auth::user()->is($product->merchant))
            <tr>
                <td class="is-narrow">
                    <div class="image is-32x32">
                        <img src="{{ $product->imagePath() }}" alt="product">
                    </div>
                </td>
                <td>
                    <a href="{{ action('ProductController@show',$product) }}">{{ $product->name }}</a>
                </td>
                <td>{{ $product->order_properties->quantity }}</td>
                @if (Auth::user()->isCustomer())
                    <td>{{ $product->merchant->name ?? "mercante eliminato" }}</td>
                @endif
                @if (Auth::user()->isMerchant())
                <td>{{ $product->quantity }}</td>
                @endif
                <td>
                    @can('create', App\Models\Cart::class)
                        @include('Cart._add_to_cart', ['buttonText' => 'Riacquista', 'sizeClass' => 'is-small'])
                    @endcan
                </td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
</div>