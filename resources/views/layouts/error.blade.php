@extends('layouts.app')

@section('content')
<div class="section">
    <div class="columns">
        <div class="column has-text-right is-hidden-mobile">
            <img src="{{ asset('images/'.($image ?? 'avatar-king.svg')) }}" style="max-height: 70vh">
        </div>
        <div class="column has-text-centered is-hidden-tablet">
            <img src="{{ asset('images/'.($image ?? 'avatar-king.svg')) }}" style="max-height: 33vh">
        </div>
        <div class="column is-flex is-align-items-center">
            <div class="container">
                <h1 class="title is-size-3">{{$errorCode}}{{ isset($errorDescription) ? " - {$errorDescription}" : "" }}</h1>
                @isset($message)
                    <div class="content">
                        <p>{{ $message }}</p>
                    </div>
                @else
                    @isset($errorDescription)
                    <div class="content">
                        <p>{{ $error-description }}</p>
                    </div>
                    @endisset
                @endisset
                <p class="mt-5">
                    <a class="is-link" href="{{ Redirect::back() ?? '/' }}">
                        <strong>Torna al negozio</strong>
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection