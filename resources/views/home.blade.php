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


@foreach ($reels as $reel)
    <div class="section">
        @include('_home_section', [
            'title' => $reel['title'],
            'url' => $reel['url'],
            'products' => $reel['products']
            ])
    </div>
@endforeach


</div>
@endsection