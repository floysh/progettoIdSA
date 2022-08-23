@extends('layouts.app')

@section('content')
<div class="section">
    @if (Auth::check())
    <div class="hero">
        <div class="title is-size-3">Lietodì, {{ Auth::user()->name }}!</div>
        <div class="subtitle is-size-5">Ricorda: troppe monete in tasca riducono l'agilità nei combattimenti.</div>
    </div>
    @else
    <div class="hero">
        <div class="title is-size-4">Dalle migliori botteghe, per i migliori avventurieri</div>
        <div class="subtitle is-size-5">Che tu sia un mago, un ranger o un guaritore, ZonkoShop ha sempre quello che ti serve.</div>
    </div>
    @endif
</div>

@for ($i = 0; $i < 3; $i++)
    <div class="section">
        <div class="container has-text-right is-pulled-right">
            <a href="#" class="button">Visualizza altro</a>
        </div>
        <div class="title is-size-4">{{ Faker\Factory::create()->sentence() }}</div>
        <div class="container">
            
            @include('Product._reel', ['products' => App\Models\Product::all()])

        </div>
    </div>
@endfor


</div>
@endsection