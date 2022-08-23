@extends('layouts.app')

@section('title')
Registrati su {{ config('app.name') }}
@endsection

@section('content')

<div class="section container">
  
    <h2 class="title is-size-2">Registrati su {{ config('app.name') }}</h2>
  
    <div class="columns is-gapless">

        <div class="column is-hidden-mobile is-centered is-narrow">
            <figure class="image">
                <img src="{{ asset('images/avatar-peasant.svg') }}" alt="" style="max-height: 24rem;">
            </figure>
        </div>
      
        <div class="column">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="field">
                    <div class="control">
                        <label for="name" class="label">Nome</label>
                        <input id="name" type="text" class="input" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="help label is-danger" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <label for="role" class="label">Che cosa sei?</label>
                        <div class="select">
                            <select name="role" id="role">
                                <option value="customer" selected>Cliente</option>
                                <option value="merchant">Mercante</option>
                            </select>
                        </div>
                        <p class="help is-size-6 is-small">
                            <strong>Nota:</strong> Il ruolo utente non può essere modificato dopo la registrazione.
                        </p>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <label for="email" class="label">{{ __('Email Address') }}</label>
                        <input id="email" type="text" class="input" name="email" value="{{ old('email') }}" required autocomplete="name" autofocus>
                        @error('email')
                            <span class="help label is-danger" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <label for="password" class="label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="input @error('password') is-danger @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="help label is-danger" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <label for="password-confirm" class="label">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="input @error('password') is-danger @enderror" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="field mt-4">
                    <div class="control">
                        <button class="button is-primary" type="submit">Conferma registrazione</button>
                    </div>
                </div>
                
            </form>
        </div>
      
    </div>
  </div>

@endsection
