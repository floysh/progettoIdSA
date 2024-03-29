<nav class="navbar has-shadow is-fixed-top is-unselectable pl-3 pr-3" role="navigation" aria-label="main navigation">

  <div class="container is-widescreen">
    <div class="navbar-brand is-unselectable">
      <a class="navbar-item" href="/">
        <img src={{ asset('images/zonkologo.png') }} style="max-height: 3rem;">
      </a>
      
      <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" 
          onclick="document.getElementById('navbar-menu').classList.toggle('is-active')"
          data-target="navbar-menu">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>
    
    
    <div id="navbar-menu" class="navbar-menu">
      {{-- LEFT SIDE --}}
      <div class="navbar-start has-text-weight-bold">
        <div class="navbar-item has-dropdown is-hoverable is-boxed">
          <div class="navbar-link">
            Prodotti
          </div>
          <div class="navbar-dropdown is-boxed">

            <a class="navbar-item" href="{{ action('ProductController@index') }}" >Tutti i prodotti</a>
            @foreach (App\Enums\ProductCategory::cases() as $category)
            <a class="navbar-item" href="{{ action('StoreController@category', ['category' => $category->value]) }}" >{{ $category->name }}</a>
            @endforeach

            @can('create', App\Models\Product::class)
            <hr class="navbar-divider"/>
              <div class="navbar-item">
                <a href="{{action('ProductController@create')}}" class="button">
                  <span class="icon"><i class="fas fa-plus"></i></span>
                  <span>Nuovo prodotto</span>
                </a>
              </div>
            @endcan
            
          </div>
        </div>
      </div>

      <div class="navbar-item container-fluid" id="search_bar">
        <form action="{{ route('search') }}" method="GET">
          <div class="field has-addons" style="min-width: 20rem">
            
            <div class="control is-expanded has-icons-left">
              <input name="q" class="input is-fullwidth" type="text" placeholder="Cerca un prodotto" value="{{ Request::get("q") }}">
              <span class="icon is-left">
                <i class="fas fa-search"></i>
              </span>
            </div>

          </div>
        </form>
        <div id="search_autocomplete" class="search-suggestions-container box p-4 is-hidden">
          <div class="suggestions list">
            {{-- *** autocomplete suggestions here ** --}}
          </div>
        </div>
      </div>

      {{-- RIGHT SIDE --}}
      <div class="navbar-end">
        @if(!Auth::check())
        <div class="navbar-item">
          <div class="buttons">
            <a href="{{ route('login') }}" class="button">Accedi</a>
            <a href="{{ route('register') }}" class="button is-primary">Registrati</a>
          </div>
        </div>
        @else
       
        @can('create', App\Models\Cart::class)
          <div class="navbar-item is-hidden-mobile">
            <a href="{{ route('CartPage') }}" class="navbar-button has-text-black">
              <i class="fas fa-shopping-cart"></i>
            </a>
          </div>
        @endcan
        @can('create', App\Models\Product::class)
          <div class="navbar-item is-hidden-mobile">
            <a href="{{ route('UserCatalogue') }}" class="navbar-button has-text-black">
              <i class="fas fa-scale-balanced"></i>
            </a>
          </div>
          <div class="navbar-item is-hidden-mobile">
            <a href="{{ action('OrderController@index') }}" class="navbar-button has-text-black">
              <i class="fas fa-list"></i>
            </a>
          </div>
        @endcan



        {{-- Account dropdown menu --}}
        <div id="account-menu" class="navbar-item has-dropdown is-hoverable pl-4">
          <a class="navbar-link">

            <div class="columns is-gapless is-mobile">
              <div class="column is-narrow">
                <span class="image mr-2 is-hidden">
                  <img class="is-rounded" src="{{ asset("images/avatar-placeholder.png") }}" alt="pp">
                </span>
              </div>
              <div class="column">
                <strong>{{ Auth::user()->name }}</strong>
                
                @if (Auth::user()->isMerchant())
                  <div>
                    <div class="tag is-info is-light">
                      <span class="icon">
                        <i class="fas fa-scale-balanced"></i>
                      </span>
                      <span>Mercante</span>
                    </div>
                  </div>
                @elseif (Auth::user()->isCustomer())
                  <div>
                    <div class="tag is-success is-light">
                    <span class="icon">
                      <i class="fas fa-coins"></i>
                    </span>
                    <span>@currency(Auth::user()->money)</span>
                    </div>
                  </div>
                @endif
              </div>
              
            </div>
          </a>
          
          <div class="navbar-dropdown is-right is-boxed mr-2">
            @include('common.navbar._account-menu')
          </div>

        </div>
        @endif
      </div>
    </div>

  </div>

</nav>