@extends('layouts.app')

@section('title')
    {{ Auth::user()->isCustomer() ? "Cronologia ordini " : "Ordini dei clienti" }} - {{ config('app.name', 'Laravel') }}  
@endsection

@section('content')
<div class="section">

  @if ($orders->isEmpty())
    {{-- Nessun ordine --}}
    <div class="content is-flex is-align-items-center">
      <div class="container">
          <h1 class="title is-size-3">Nessun ordine</h1>
          @if (Auth::user()->isCustomer())
            <p>
                Gli acquisti che farai su {{ config('app.name', 'Laravel') }} saranno elencati qui.
            </p>
            <p class="mt-5">
                <a class="is-link" href="/products"><strong>Torna al negozio</strong></a>
            </p>
          @else
            <p>
                Nessuno ha ancora comprato uno dei tuoi prodotti.
            </p>
            <p class="mt-5">
                <a class="is-link" href="/catalogue"><strong>Torna al catalogo</strong></a>
            </p>
          @endif
      </div>
    </div>
    
    @else
    <h3 class="title is-size-3">{{ Auth::user()->isCustomer() ? "I tuoi ordini" : "Ordini clienti" }}</h3>
    {{-- Elenco ordini --}}
    <div class="list">
      @foreach($orders as $order)
        <div class="list-item box pt-6 mb-6">
          @include('Order._order')
        </div>
      @endforeach
    </div>
  @endif

</div>
@endsection