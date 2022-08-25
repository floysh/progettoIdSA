@extends('layouts.app')

@section('content')
<div class="section pb-0">
    @include('_spotlight', [
        'title' => $spotlightTitle ?? Faker\Factory::create()->sentence(),
        'subtitle' => $spotlightSubtitle ?? Faker\Factory::create()->sentence(),
        'url' => $spotlightUrl ?? '#',
        'backgroundImage' => $spotlightBackgroundImageUrl,
    ])
</div>

<div class="section">
    @include('_home_section', [
        'title' => "Le nostre magie preferite TODO",
        //'url' => "/search?category=spell",
        'products' => App\Models\Product::where('category','spell')->where('price','>',100)->get()
        ])
</div>


@for ($i = 0; $i < 3; $i++)
    <div class="section">
        @include('_home_section', [
            'title' => Faker\Factory::create()->sentence(),
            'url' => "/products",
            'products' => App\Models\Product::all()
            ])
    </div>
@endfor


</div>
@endsection