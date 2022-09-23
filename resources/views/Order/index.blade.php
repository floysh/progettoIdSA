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
    <h3 class="title is-size-3">I tuoi ordini</h3>
    {{-- Elenco ordini --}}
    <div class="list">
      @foreach($orders as $order)
        <div class="list-item mt-6 mb-6">
          @include('Order._order')
        </div>
      @endforeach
    </div>
  @endif

</div>
@endsection