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

<div class="section">
    <div class="title is-size-4">Le nostre magie preferite</div>
    <div class="container">
        <div class="cards">
            <div class="reel block mb-5">
                
                @include('Product._reel', ['products' => array()])

            </div>
        </div>
    </div>
    <div class="container has-text-right">
        <a href="#" class="button">Visualizza altro</a>
    </div>
</div>

<div class="section">
    <div class="title is-size-4">Affettali come burro</div>
    <div class="container">

        @include('Product._reel', ['products' => array(15)])
        
    </div>
    <div class="container has-text-right">
        <a href="#" class="button">Visualizza altro</a>
    </div>
</div>

<div class="section">
    <div class="title is-size-4">Shine on you, crazy diamond</div>
    <div class="container">

        @include('Product._reel', ['products' => array(15)])
        
    </div>
    <div class="container has-text-right">
        <a href="#" class="button">Visualizza altro</a>
    </div>
</div>
@endsection