<a href="{{ $url ?? '#'}}">
    <div class="notification" 
        style="
            background-image: url('{{ $backgroundImage ?? '/'}}');
            box-shadow: inset 0 -27px 115px -28px black;
            background-repeat: no-repeat;
            background-size: 100%;
            ">
        <div class="hero">
            <div class="hero-body"></div>
            <div class="hero-body"></div>
            <div class="hero">
                <div class="content has-text-white is-hidden-mobile">
                    <div class="title is-size-4 is-size-5-mobile">{{ $title ?? Faker\Factory::create()->sentence() }}</div>
                    <div class="subtitle is-size-5 is-size-6-mobile mb-3">{{ $subtitle ?? Faker\Factory::create()->sentence() }}</div>
                    @isset($spotlightUrl)
                    <div class="button is-outlined">Visualizza dettagli</div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
    <div class="content has-text-white is-hidden-tablet">
        <div class="button is-pulled-right" style="border: none">
            <i class="fas fa-arrow-right"></i>
        </div>
        <div class="title is-size-4 is-size-5-mobile">{{ $title ?? Faker\Factory::create()->sentence() }}</div>
        <div class="subtitle is-size-5 is-size-6-mobile">{{ $subtitle ?? Faker\Factory::create()->sentence() }}</div>
    </div>
</a>