@extends('layouts.app')

@section('content')
<div class="section">
    <div class="message is-success">
        <div class="message-header">{{ __('Dashboard') }}</div>

        <div class="message-body">
            @if (session('status'))
                <div class="content">
                    {{ session('status') }}
                </div>
            @endif

            {{ __('You are logged in!') }}
        </div>
    </div>
</div>
@endsection
