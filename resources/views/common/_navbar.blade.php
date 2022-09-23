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
          <a class="navbar-link" href="/products">
            Prodotti
          </a>
          <div class="navbar-dropdown is-boxed">

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

      <div class="navbar-item container-fluid">
        <div class="field has-addons is-expanded" id="search_bar">
          <div class="control has-icons-left">
            <input class="input is-fullwidth" type="text" placeholder="Cerca un prodotto">
            <span class="icon is-left">
              <i class="fas fa-hat-wizard"></i>
            </span>
          </div>
          <div class="control">
            <a class="button is-info">
              <i class="fas fa-search"></i>
            </a>
          </div>
        </div>
        <div id="search_autocomplete" class="box p-4 mr-3" style="position: absolute; top: 3rem; max-height: 13rem; overflow-y: scroll;">
          <div class="suggestions list">
            @for ($i = 0; $i < 3; $i++)
            <div class="list-item mt-2 mb-2">
              <a href="/products/9999">
                <div class="columns">
                  <div class="column is-narrow pt-2 pr-0">
                    <div class="image is-48x48">
                      <img src="{{ asset('images/placeholders/product.svg') }}" alt="product image" style="max-height: unset">
                    </div>
                  </div>
                  <div class="column">
                    <div class="title is-size-6 mb-1">
                      {{ Faker\Factory::create()->sentence() }}
                    </div>
                    <div class="label">
                      <span class="icon"><i class="fas fa-coins"></i></span>
                      <span>@currency(12.5)</span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            @endfor
          </div>
        </div>
      </div>

      {{-- RIGHT SIDE --}}
      <div class="navbar-end">
        @if(!Auth::check())
        <div class="navbar-item">
          <div class="buttons">
            {{--<a href="{{ route('register') }}" class="button is-primary">Sign up</a>--}}
            <a href="{{ route('login') }}" class="button">Login</a>
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
            <a href="{{ route('Dashboard') }}" class="navbar-button has-text-black">
              <i class="fas fa-list"></i>
            </a>
          </div>
        @endcan



        {{-- Account dropdown menu --}}
        <div id="account-menu" class="navbar-item has-dropdown is-hoverable pl-4">
          <a class="navbar-link">
            <span class="image mr-2 is-hidden-mobile is-hidden-desktop">
              <img class="is-rounded" src="{{ asset("images/avatar-placeholder.png") }}" alt="pp">
            </span>
            <span class="is-hidden-touch">
              <div><strong>{{ Auth::user()->name }}</strong></div>
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
            </span>
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