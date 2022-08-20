<nav class="navbar has-shadow is-fixed-top is-unselectable pl-3 pr-3" role="navigation" aria-label="main navigation">

  <div class="container is-widescreen">
    <div class="navbar-brand is-unselectable">
      <a class="navbar-item" href="/">
        <img src={{ asset('images/zonkologo.png') }} style="max-height: 4rem;">
      </a>
      
      <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbar-menu">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>
    
    {{-- LEFT SIDE --}}

    <div id="navbar-menu" class="navbar-menu">
      <div class="navbar-start has-text-weight-bold">
        @php
            $categories = App\Models\Product::categories()
        @endphp
        @foreach ($categories as $cat_id => $category)
        <a href="{{ action('ProductController@index', ['category' => $cat_id]) }}" class="navbar-item">{{ $cat_id }}</a>
        @endforeach
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
       
        <div class="navbar-item pl-0 is-hidden-mobile">
          <a href="{{ route('CartPage') }}" class="navbar-button has-text-black">
            <i class="fas fa-shopping-cart"></i>
          </a>
        </div>



        {{-- Account dropdown menu --}}
        <div id="account-menu" class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">
            <span class="image mr-2 is-hidden-mobile is-hidden-desktop">
              <img class="is-rounded" src="<%= asset_path("avatar-placeholder") %>" alt="profile picture placeholder">
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
            @include('common.navbar.account-menu')
          </div>

        </div>
        @endif
      </div>
    </div>
  </div>

</nav>