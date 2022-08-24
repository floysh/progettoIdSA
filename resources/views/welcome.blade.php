@extends('layouts.app')

@section('content')
<div class="section pb-0">
    @include('_spotlight', [
        'title' => "Preparati per l'Ovest Proibito",
        'subtitle' => "Fai scorta di pozioni prima di esplorare le pericolose montagne a ovest.",
        'url' => '/products/1',
        'backgroundImage' => 'https://i.pinimg.com/originals/ee/0a/47/ee0a47d7342f4ab1db5590793875d53c.png',
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