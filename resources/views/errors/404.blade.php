@extends('layouts.app')

@section('content')
<div class="section">
    <div class="columns is-flex">
        <div class="column">
            <img src="{{ asset('images/emptycart-alt.jpg') }}" alt="">
        </div>
        <div class="column is-flex is-align-items-center">
            <div class="container">
                <h1 class="title is-size-3">404</h1>
                <p>
                    Oops! Non c'è niente da vedere qui.
                </p>
                <p class="mt-5">
                    <a class="is-link" href="/">
                        <strong>Torna al negozio</strong>
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection