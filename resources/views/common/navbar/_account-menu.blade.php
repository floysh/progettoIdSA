<div class="account-menu">

    <div class="navbar-item is-justify-content-left is-hidden-mobile">
      <span class="image pr-3">
        <img class="is-rounded" src="{{ asset('images/avatar-placeholder.png') }}" alt="pp">
      </span>
      <span>
        <div class="has-text-weight-bold">{{ Auth::user()->name }}</div>
        <div>{{ Auth::user()->email  }}</div>
      </span>
    </div>

    <hr class="navbar-divider"/>

    <div class="navbar-item is-justify-content-left">
      <span>
        <span class="icon">
          <i class="fas fa-coins"></i>
        </span>
        <span> @currency(Auth::user()->money) </span>
      </span>
    </div>
  
    <hr class="navbar-divider"/>
  
  
    
    @can('create', App\Models\Cart::class)
      @include('common.navbar._menu-item', ['link' => action('OrderController@index'),  'icon' => 'fas fa-receipt', 'title' => 'Cronologia ordini'])
      @include('common.navbar._menu-item', ['link' => action('CartController@index'),  'icon' => 'fas fa-shopping-cart', 'title' => 'Carrello'])
    @endcan

    @if (Auth::user()->isMerchant())
      @include('common.navbar._menu-item', ['link' => route('UserCatalogue') ?? 'TODO',  'icon' => 'fas fa-scale-balanced', 'title' => 'Gestione bottega'])
      @include('common.navbar._menu-item', ['link' => action('OrderController@index'),  'icon' => 'fas fa-list', 'title' => 'Ordini clienti'])
    @endif
   
  
    <hr class="navbar-divider"/>


    <a class="navbar-item" href="{{ route('logout') }}"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <div>
          <span class="icon mr-2">
            <i class="fas fa-sign-out"></i>
          </span>
          <span>{{ __('Logout') }}</span>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </a>

  
  </div>
  