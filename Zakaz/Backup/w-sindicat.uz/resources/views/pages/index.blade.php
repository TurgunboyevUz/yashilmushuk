@extends('layout.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sindicat/index.css') }}">
@endpush

@push('scripts')
<script>
    const slider = document.querySelector('.slider');
    const prevBtn = document.getElementById('prev');
    const nextBtn = document.getElementById('next');

    let index = 0;
    const totalCards = document.querySelectorAll('.card').length;
    const visibleCards = 3; // Ekranda nechta card ko‘rinadi
    const cardWidth = document.querySelector('.card').offsetWidth + 10; // Card width + gap

    nextBtn.addEventListener('click', () => {
        if (index < totalCards - visibleCards) {
            index++;
        } else {
            index = 0; // Slayderni qayta boshlash
        }
        updateSlider();
    });

    prevBtn.addEventListener('click', () => {
        if (index > 0) {
            index--;
        } else {
            index = totalCards - visibleCards; // Oxiridan boshlab qayta boshlash
        }
        updateSlider();
    });

    function updateSlider() {
        slider.style.transform = `translateX(-${index * cardWidth}px)`;
    }

</script>
@endpush

@section('content')
<div class="header-section container" style="background: url({{ asset('storage/' . $banners->where('key', 'main1')->first()->image) }})">
    <div class="header-secion-left">
        <h1>{!! __('index.banner.main') !!}</h1>
        <h2>{{ __('index.banner.title') }}</h2>
        <p>{{ __('index.banner.description') }}</p>

        <button>
            <a href='{{ $contact_button['url'] }}' style='color: white; text-decoration: none;'>
                {{ __('index.banner.btn') }}
            </a>
        </button>
    </div>
    <div class="header-section-right">
        <video src="{{ $videos->where('key', 'main-1')->first()->path() }}" class="header-section-right-video" controls />
    </div>
</div>

<!-- 2-section -->
<div class="nashi-uslugi container">
    <h1>{{ __('index.advantages.title') }}</h1>
    <div class="nashi-uslugi-card">
        <div class="nashi-uslugi-card-item">
            <i class="fa-solid fa-cart-shopping"></i>
            <h2>{{ __('index.advantages.sections.title1') }}</h2>
            <p>{{ __('index.advantages.sections.content1') }}</p>
        </div>
        <div class="nashi-uslugi-card-item">
            <i class="fa-solid fa-tags"></i>
            <h2>{{ __('index.advantages.sections.title2') }}</h2>
            <p>{{ __('index.advantages.sections.content2') }}</p>
        </div>
        <div class="nashi-uslugi-card-item">
            <i class="fa-solid fa-shop"></i>
            <h2>{{ __('index.advantages.sections.title3') }}</h2>
            <p>{{ __('index.advantages.sections.content3') }}</p>
        </div>
    </div>
</div>

<!-- 3-section -->

<div class="nashi-preimushestva container">
    <h1>{{ __('index.capabilities.title') }}</h1>
    <div class="nashi-preimushestva-card">
        <div class="nashi-preimushestva-card-item">
            <img src="/assets/Vector-clock.png" alt="">
            <div class="nashi-preimushestva-card-item-detalies">
                <h2>{{ __('index.capabilities.sections.title1') }}</h2>
                <p>{{ __('index.capabilities.sections.content1') }}</p>
            </div>
        </div>
        <div class="nashi-preimushestva-card-item">
            <img src="/assets/Vector-koylak.png" alt="">
            <div class="nashi-preimushestva-card-item-detalies">
                <h2>{{ __('index.capabilities.sections.title2') }}</h2>
                <p>{{ __('index.capabilities.sections.content2') }}</p>
            </div>
        </div>
        <div class="nashi-preimushestva-card-item">
            <img src="/assets/Vector-seriya.png" alt="">
            <div class="nashi-preimushestva-card-item-detalies">
                <h2>{{ __('index.capabilities.sections.title3') }}</h2>
                <p>{{ __('index.capabilities.sections.content3') }}</p>
            </div>
        </div>
        <div class="nashi-preimushestva-card-item">
            <img src="/assets/Vector-documentatsiya.png" alt="">
            <div class="nashi-preimushestva-card-item-detalies">
                <h2>{{ __('index.capabilities.sections.title4') }}</h2>
                <p>{{ __('index.capabilities.sections.content4') }}</p>
            </div>
        </div>
        <div class="nashi-preimushestva-card-item">
            <img src="/assets/Vector-razrabotka.png" alt="">
            <div class="nashi-preimushestva-card-item-detalies">
                <h2>{{ __('index.capabilities.sections.title5') }}</h2>
                <p>{{ __('index.capabilities.sections.content5') }}</p>
            </div>
        </div>
        <div class="nashi-preimushestva-card-item">
            <img src="/assets/Vector-moshnosti.png" alt="">
            <div class="nashi-preimushestva-card-item-detalies">
                <h2>{{ __('index.capabilities.sections.title6') }}</h2>
                <p>{{ __('index.capabilities.sections.content6') }}</p>
            </div>
        </div>
        <div class="nashi-preimushestva-card-item">
            <img src="/assets/Vector-comanda.png" alt="">
            <div class="nashi-preimushestva-card-item-detalies">
                <h2>{{ __('index.capabilities.sections.title7') }}</h2>
                <p>{{ __('index.capabilities.sections.content7') }}</p>
            </div>
        </div>
        <div class="nashi-preimushestva-card-item">
            <img src="/assets/Vector-oboruvdnya.png" alt="">
            <div class="nashi-preimushestva-card-item-detalies">
                <h2>{{ __('index.capabilities.sections.title8') }}</h2>
                <p>{{ __('index.capabilities.sections.content8') }}</p>
            </div>
        </div>
        <div class="nashi-preimushestva-card-item">
            <img src="/assets/Vector-dastavka.png" alt="">
            <div class="nashi-preimushestva-card-item-detalies">
                <h2>{{ __('index.capabilities.sections.title9') }}</h2>
                <p>{{ __('index.capabilities.sections.content9') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- 4-section -->

<div class="about-us container" style="background: url({{ asset('storage/' . $banners->where('key', 'main2')->first()->image) }})">
    <div class="about-us-video">
        <video src="{{ $videos->where('key', 'main-2')->first()->path() }}" controls />
    </div>

    <div class="about-us-right">
        <h1>{{ __('index.about-us.title') }}</h1>
        <p>{{ __('index.about-us.paragraph1') }}</p>
        <p>{{ __('index.about-us.paragraph2') }}</p>
        <p>{{ __('index.about-us.paragraph3') }}</p>

        <div class="about-us-right-list">

            <div class="about-us-right-list-item">
                <img src="/assets/Vectorchek.png" alt="chek">
                <p>{{ __('index.about-us.mark1') }}</p>
            </div>
            <div class="about-us-right-list-item">
                <img src="/assets/Vectorchek.png" alt="chek">
                <p>{{ __('index.about-us.mark2') }}</p>
            </div>
            <div class="about-us-right-list-item">
                <img src="/assets/Vectorchek.png" alt="chek">
                <p>{{ __('index.about-us.mark3') }}</p>
            </div>

        </div>
        <button>
            <a href='{{ $contact_button['url'] }}' style='color: white; text-decoration: none;'>
                <p>{{ __('general.in_detail') }}</p>
            </a>
        </button>
    </div>
</div>

<!-- 5-section -->

<div class="shtomishem container">
    <h1>{{ __('index.catalogs.title') }}</h1>
    <div class="shtomishem-card">
        @foreach($catalogs as $catalog)
        <a href="{{ route('catalog.index') }}">
            <img src="{{ $catalog->path() }}" alt="{{ $catalog->name }}">
        </a>
        @endforeach
    </div>

</div>

<!-- 6-section -->
<div class="chto-mi-predlagaem container">
    <h1>{{ __('index.services.title') }}</h1>
    <div class="chto-mi-predlagaem-cards">
        @foreach($services as $service)
        <div class="chto-mi-predlagaem-cards-item" style="background-image: url({{ $service->path() }})">
            <div class="chto-mi-predlagaem-cards-item-detalies">
                <h1>{{ $service->name }}</h1>
                <a href="{{ route('services.show', $service->slug) }}">{{ __('general.in_detail') }} ></a>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- 7-section -->
<div class="etap-rabot container">
    <h1>{{ __('index.steps.title') }}</h1>
    <div class="etap-rabot-cards">
        <div class="etap-rabot-cards-item">
            <span>{{ __('index.steps.step', ['num' => 1]) }}</span>
            <p>{{ __('index.steps.content1') }}</p>
        </div>
        <div class="etap-rabot-cards-item">
            <span>{{ __('index.steps.step', ['num' => 2]) }}</span>
            <p>{{ __('index.steps.content2') }}</p>
        </div>
        <div class="etap-rabot-cards-item">
            <span>{{ __('index.steps.step', ['num' => 3]) }}</span>
            <p>{{ __('index.steps.content3') }}</p>
        </div>
        <div class="etap-rabot-cards-item">
            <span>{{ __('index.steps.step', ['num' => 4]) }}</span>
            <p>{{ __('index.steps.content4') }}</p>
        </div>

    </div>
</div>

<!-- 8-section -->
<div class="besplatniy-bonus container">
    <h1>{{ __('index.bonus.title') }}</h1>
    <h2>{{ __('index.bonus.subtitle') }}</h2>
    <div class="slider-container">
        <button id="prev">&lt;</button>
        <div class="slider-wrapper">
            <div class="slider">
                @foreach($bonuses as $bonus)
                <div class="card">
                    <img src="{{ $bonus->path() }}">
                    <span>{{ $bonus->name }}</span>
                    <p>{{ $bonus->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
        <button id="next">&gt;</button>
    </div>
</div>


<!-- 9-section -->
<div class="na-keysi container">
    <h1>{{ __('index.case.title') }}</h1>
    <div class="na-keysi-videos">
        @foreach($youtubes as $youtube)
            <iframe class="youtube-video" src="{{ $youtube->url }}" frameborder="0" allowfullscreen></iframe>
        @endforeach
    </div>
</div>
@endsection
