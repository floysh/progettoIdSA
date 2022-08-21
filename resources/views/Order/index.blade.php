@extends('layouts.app')

@section('title')
    Cronologia ordini - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')
<div class="section">

  @if ($orders->isEmpty())
    {{-- Nessun ordine --}}
    <div class="content is-flex is-align-items-center">
      <div class="container">
          <h1 class="title is-size-3">Nessun ordine</h1>
          <p>
              Gli acquisti che farai su {{ config('app.name', 'Laravel') }} saranno elencati qui.
          </p>
          <p class="mt-5">
              <a class="is-link" href="/products"><strong>Torna al negozio</strong></a>
          </p>
      </div>
    </div>
    
    @else
    {{-- Elenco ordini --}}
    @foreach($orders as $order)
      <div class="list">
        <div class="list-item mb-6">
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
        </div>
      </div>
    @endforeach
  @endif

</div>
@endsection