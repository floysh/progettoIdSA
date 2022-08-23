<nav class="navbar has-shadow is-fixed-top is-unselectable pl-3 pr-3" role="navigation" aria-label="main navigation">

  <div class="container is-widescreen">
    <div class="navbar-brand is-unselectable">
      <a class="navbar-item" href="/">
        <img src={{ asset('images/zonkologo.png') }} style="max-height: 3.5rem;">
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
              @php
                $categories = App\Models\Product::categories()
            @endphp
            @foreach ($categories as $cat_id => $category)
            <a class="navbar-item" href="{{ action('ProductController@index', ['category' => $cat_id]) }}" >{{ $cat_id }}</a>
            @endforeach
          </div>
        </div>
      </div>

      <div class="navbar-item container-fluid">
        <div class="field has-addons">
          <div class="control has-icons-left">
            <input class="input" type="text" placeholder="Cerca un prodotto">
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
       
        <div class="navbar-item is-hidden-mobile">
          <a href="{{ route('CartPage') }}" class="navbar-button has-text-black">
            <i class="fas fa-shopping-cart"></i>
          </a>
        </div>



        {{-- Account dropdown menu --}}
        <div id="account-menu" class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">
            <span class="image mr-2 is-hidden-mobile is-hidden-desktop">
              <img class="is-rounded" src="{{ asset("images/avatar-placeholder.png") }}" alt="pp">
            </span>
            <span class="is-hidden-touch">
              <div><strong>{{ Auth::user()->name }}</strong></div>
             @if (Auth::user()->isMerchant())
             <div>
               <div class="tag is-black">
                <span class="icon">
                  <i class="fas fa-basket"></i>
                </span>
                <span>Mercante</span>
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