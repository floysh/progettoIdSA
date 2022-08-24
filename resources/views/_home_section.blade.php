<div class="container has-text-right is-pulled-right">
    @isset($url)
    <a href="{{$url}}" class="">
        <span class="icon"><i class="fas fa-arrow-right"></i></span>
    </a>
    @endisset
</div>
<div class="title is-size-4 is-size-5-mobile">{{ $title ?? Faker\Factory::create()->sentence() }}</div>
<div class="container">
    
    @include('Product._reel', ['products' => $products ?? array() ])

</div>