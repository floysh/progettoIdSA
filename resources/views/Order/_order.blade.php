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
    <th>Quantità</th>
    <th>Prodotto</th>
    <th>Mercante</th>
    </thead>
    <tbody>
    @foreach ($order->products as $product)
        <tr>
        <td>{{ $product->order_properties->quantity }}x</td>
        <td>
            <a href="{{ action('ProductController@show',$product) }}">{{ $product->name }}</a>
        </td>
        <td>$product->merchant->name </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>