@extends('layouts.app')

@section('content')
    <div class="section">
        <div class="block">
            <div class="columns is-mobile">
                <div class="column is-flex is-align-items-center">
                    <div class="content">
                        <div class="title is-size-4">Bottega di {{ Auth::user()->name }}</div>
                        <div class="subtitle is-size-5 mb-3">{{ Auth::user()->products->count() }} prodotti nel catalogo</div>
                    </div>
                </div>
                <div class="column is-narrow is-hidden-mobile">
                    <div class="block image is-96x96">
                        <img src="{{ asset('images/merchant.svg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="content block mb-6">
            <a href="{{ action('ProductController@create') }}" class="button">
                <span class="icon"><i class="fas fa-plus"></i></span>
                <span>Nuovo prodotto</span>
            </a>
        </div>

        <div class="container list">
            @forelse ($products as $product)
                <div class="list-item block">
                    @include('Product._product', ['product' => $product])
                </div>
                <hr>
            @empty
                <div class="section">
                    <h4 class="subtitle block">Non hai ancora inserito prodotti nel catalogo</h4>
                </div>
            @endforelse
        </div>
    </div>
@endsection