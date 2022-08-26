<h4 class="title is-size-4">Ordine # {{$order->id}}</h4>
{{-- Info --}}
<nav class="level mb-0">
<div class="level-item block">
    <div>
    <p class="heading">Effettuato il</p>
    <p class="title is-size-5">{{ $order->created_at }}</p>
    </div>
</div>
<div class="level-item has-text-right">
    <div>
    <p class="heading">Prodotti acquistati</p>
    <p class="title is-size-5">{{ $order->products()->count() }}</p>
    </div>
</div>
</nav>
{{-- Elenco prodotti --}}
<div class="content">
<table class="table">
    <thead>
        <th></th>
        <th>Prodotto</th>
        <th>Quantità</th>
        <th>Mercante</th>
        <th></th>
    </thead>
    <tbody>
    @foreach ($order->products as $product)
        <tr>
            <td class="is-narrow">
                <div class="image is-32x32">
                    <img src="{{ $product->imagePath() }}" alt="product">
                </div>
            </td>
            <td>
                <a href="{{ action('ProductController@show',$product) }}">{{ $product->name }}</a>
            </td>
            <td>{{ $product->order_properties->quantity }}x</td>
            <td>{{ $product->merchant->name ?? "mercante eliminato" }}</td>
            <td>
                @can('create', App\Models\Cart::class)
                    @include('Cart._add_to_cart', ['buttonText' => 'Riacquista', 'sizeClass' => 'is-small'])
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>