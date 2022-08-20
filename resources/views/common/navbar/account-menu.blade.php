<div class="account-menu">

    <a class="navbar-item is-justify-content-left" href="<%= current_user_profile_url %>">
      <span class="image pr-3 is-hidden-mobile">
        <img class="is-rounded" src="{{ asset('images/avatar-placeholder') }}" alt="pp">
      </span>
      <span>
        <div class="has-text-weight-bold">{{ Auth::user()->name }}</div>
        <div>{{ Auth::user()->email  }}</div>
      </span>
    </a>

    <div class="navbar-item is-justify-content-left">
      <span>
        <span class="icon">
          <i class="fas fa-coins"></i>
        </span>
        <span>{{ Auth::user()->money }}</span>
      </span>
    </div>
  
    <hr class="navbar-divider"/>
  
  
    @include('common/menu-item', ['link' => action('OrderController@index'),  'icon' => 'fas fa-receipt', 'title' => 'Ordini'])
    
    @include('common/menu-item', ['link' => action('CartController@index'),  'icon' => 'fas fa-shopping-cart', 'title' => 'Carrello'])
   
  
    <hr class="navbar-divider"/>


    <a class="navbar-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
  
  </div>
  