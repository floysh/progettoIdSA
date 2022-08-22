<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accedi al tuo account {{ config('app.name', 'Laravel') }}</title>
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    
    <div class="login-background">
        <div class="is-fullheight is-centered">
          <div class="section">
          <div class="container has-text-centered">
              <div class="login-controls-container box">
                  <h3 class="title has-text-black mt-6">{{ config('app.name', 'Zonko Shop') }}</h3>
                  <hr class="login-hr">
                  <p class="subtitle has-text-black">Accedi al tuo account</p>
      
                  <div class="pl-5 pr-5 pb-5 pt-3">
                      <form method="POST" action="{{ route('login') }}">
                          @csrf
      
                          <div class="field has-text-left">
                              <div class="control">
                              <label for="email" class="label">{{ __('Email Address') }}</label>
                                  <input id="email" type="email" class="input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
      
                                  @error('email')
                                      <span class="invalid-feedback" role="alert">
                                          <strong class="has-text-danger">{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                          </div>
      
                          <div class="field has-text-left">
                              <div class="control">
                                  <label for="password" class="label">{{ __('Password') }}</label>
                                  <input id="password" type="password" class="input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                  
                                  @error('password')
                                      <span class="invalid-feedback has-text-danger" role="alert">
                                          <strong class="has-text-danger">{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                          </div>
      
                          <div class="field has-text-left">
                              <div class="control">
                                  <label class="checkbox" for="remember">
                                      <input class="checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                      {{ __('Remember Me') }}
                                  </label>
                              </div>
                          </div>
      
                          <div class="field">
                              <div class="control">
                                  <button type="submit" class="button is-block is-primary is-fullwidth">
                                    Login
                                  </button>
                              </div>
                          </div>
                          
                    </form>
                  </div>
                  <p class="has-text-grey m-3">
                      Non hai un account? <a href="{{ route('register') }}">Registrati</a>
                  </p>
              </div>
          </div>
      
          </div>
        </div>
      </div>

</body>
</html>


