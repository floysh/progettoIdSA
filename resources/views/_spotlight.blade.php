<a href="{{ $url ?? '#'}}">
    <div class="spotlight has-background-dimmed" style="background-image: url('https://i.pinimg.com/originals/ee/0a/47/ee0a47d7342f4ab1db5590793875d53c.png')">
        <div class="spotlight-content">
            <div class="content has-text-white is-hidden-mobile">
                <div class="title is-size-4 is-size-5-mobile">{{ $title ?? Faker\Factory::create()->sentence() }}</div>
                <div class="subtitle is-size-5 is-size-6-mobile mb-3">{{ $subtitle ?? Faker\Factory::create()->sentence() }}</div>
                <div class="button is-outlined">Visualizza dettagli</div>
            </div>
        </div>
    </div>
    <div class="content mt-5 has-text-white is-hidden-tablet">
        <div class="button is-pulled-right" style="border: none">
            <i class="fas fa-arrow-right"></i>
        </div>
        <div class="title is-size-4 is-size-5-mobile">{{ $title ?? Faker\Factory::create()->sentence() }}</div>
        <div class="subtitle is-size-5 is-size-6-mobile">{{ $subtitle ?? Faker\Factory::create()->sentence() }}</div>
    </div>
</a>