@extends('layouts.app')

@section('content')
<div class="section">
    <div class="columns">
        <div class="column has-text-right is-hidden-mobile">
            <img src="{{ asset('images/emptycart-alt.jpg') }}" style="max-height: 70vh">
        </div>
        <div class="column has-text-centered is-hidden-tablet">
            <img src="{{ asset('images/404-dead-end.svg') }}" alt="" style="max-height: 33vh">
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