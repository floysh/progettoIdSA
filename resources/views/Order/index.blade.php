@extends('layouts.app')

@section('title')
    I tuoi ordini - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')
<div>
    @foreach($orders as $order)
      <div>
        <h3>Ordine n.{{ $order->id }}</h3>
        <h4>{{ $order->total() }} soldini</h4>
      </div>
      <div>
        @foreach($order->products as $product)
        <div>
            <ul>
                <li><a href="{{ action('ProductController@show',$product->id) }}">{{ $product->name }}</a></li>
                <li><img src="{{ $product->imgpath }}.png" alt="{{ $product->imgpath }}"></li>
                <li>{{ $product->order_properties->quantity }} x {{ $product->price }} soldini</li>
                <li>{{ $product->description }}</li>
            </ul>
        </div>
        @endforeach
      </div>
    @endforeach
</div>
@endsection