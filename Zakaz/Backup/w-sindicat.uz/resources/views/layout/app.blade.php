<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {!! seo()->html() !!}

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">

    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/sindicat/default.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="default-wrap">
        <div class="navbar container">
            <div class="navbar-top">
                {{-- <h1>{{ config('app.name') }}</h1> --}}
                <a href="{{ route('home') }}"><img src="{{ asset('logo/' . app()->getLocale() . '.png') }}" width="212" height="57"></a>
                <div class="navbar-top-contact">
                    <a href="{{ $socials->where('key', 'phone')->first()->value }}">{{ $phone_number }}</a>

                    <div class="navbar-top-contact-{{ $contact_button['icon'] }}">
                        <a href='{{ $contact_button['url'] }}'>
                            <i class="fa-brands fa-{{ $contact_button['icon'] }}" style="color: #FFFFFF;"></i>
                            <span>{{ __('general.contact', ['social' => $contact_button['label']]) }}</span>
                        </a>
                    </div>

                    <div class="language" onclick="toggleLanguageMenu()">
                        <img src="/assets/translate-icon-md-white.png" alt="" class="navbar-top-contact-transalte-icon">
                        <span> {{ __('general.language') }}</span>

                        <div class="language-switch" id="languageSwitch">
                            <a href='{{ route('locale', 'uz-latn') }}'>
                                <h1>🇺🇿 O'zbek</h1>
                            </a>
                            <a href='{{ route('locale', 'uz-cyrl') }}'>
                                <h1>🇺🇿 Узбек</h1>
                            </a>
                            <a href='{{ route('locale', 'ru') }}'>
                                <h1>🇷🇺 Русский</h1>
                            </a>
                        </div>
                    </div>
                </div>
                <img src="/assets/icons8-menu-100.png" alt="menu-icon" class="menu" onclick="menu()">
            </div>
            <div class="navbar-bottom-menu">
                <ul>
                    <li><a href="{{ route('home') }}">{{ __('general.home') }}</a></li>
                    <li><a href="{{ route('about') }}">{{ __('general.about') }}</a></li>
                    <li><a href="{{ route('catalog.index') }}">{{ __('general.catalog') }}</a></li>
                    <li><a href="{{ route('services.index') }}">{{ __('general.services') }}</a></li>
                    <li><a href="{{ route('faq') }}">{{ __('general.faq') }}</a></li>
                    <li><a href="{{ route('contacts') }}">{{ __('general.contacts') }}</a></li>
                    <li><a href="{{ route('blog.index') }}">{{ __('general.blog') }}</a></li>
                </ul>
            </div>
        </div>

        <div class="hidden mobile-menu container " id="menu">
            <ul>
                <li><a href="{{ route('home') }}">{{ __('general.home') }}</a></li>
                <li><a href="{{ route('about') }}">{{ __('general.about') }}</a></li>
                <li><a href="{{ route('catalog.index') }}">{{ __('general.catalog') }}</a></li>
                <li><a href="{{ route('services.index') }}">{{ __('general.services') }}</a></li>
                <li><a href="{{ route('faq') }}">{{ __('general.faq') }}</a></li>
                <li><a href="{{ route('contacts') }}">{{ __('general.contacts') }}</a></li>
                <li><a href="{{ route('blog.index') }}">{{ __('general.blog') }}</a></li>
                <li onclick="mobile_language_switch()">
                    {{ __('general.language') }}
                </li>
                <ul id="language-options" class="hidden">
                    <a href='{{ route('locale', 'uz-latn') }}'>
                        <li>🇺🇿 O'zbek</li>
                    </a>
                    <a href='{{ route('locale', 'uz-cyrl') }}'>
                        <li>🇺🇿 Узбек</li>
                    </a>
                    <a href='{{ route('locale', 'ru') }}'>
                        <li>🇷🇺 Русский</li>
                    </a>
                </ul>
            </ul>
        </div>

        @yield('content')

        <!-- footer -->

        @if($show_question_banner ?? false)
        <div class="footer container">
            <div class="footer-detalies">
                <h1>{{ __('general.questions') }}</h1>
                <a href="{{ $socials->where('key', 'phone')->first()->value }}">{{ $phone_number }}</a>
            </div>
            <a href="{{ $contact_button['url'] }}"><button>{{ __('general.question_btn') }}</button></a>
        </div>
        @endif

        <!-- footer 2 -->

        <div class="footer2 container">
            <div class="footer2-o-kompany">
                <h1>{{ __('general.home') }}</h1>
                <ul>
                    <li><a href="{{ route('home') }}">{{ __('general.home') }}</a></li>
                    <li><a href="{{ route('about') }}">{{ __('general.about') }}</a></li>
                    <li><a href="{{ route('catalog.index') }}">{{ __('general.catalog') }}</a></li>
                    <li><a href="{{ route('services.index') }}">{{ __('general.services') }}</a></li>
                    <li><a href="{{ route('faq') }}">{{ __('general.faq') }}</a></li>
                    <li><a href="{{ route('contacts') }}">{{ __('general.contacts') }}</a></li>
                    <li><a href="{{ route('blog.index') }}">{{ __('general.blog') }}</a></li>
                </ul>
            </div>
            <div class="footer2-uslugi">
                <h1>{{ __('general.services') }}</h1>
                <ul>
                    @foreach($services as $service)
                    <li><a href="{{ route('services.show', $service->slug) }}">{{ $service->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="footer2-kontakti">
                <h1>{{ __('general.contacts') }}</h1>
                <a href="{{ route('home') }}">{!! __('general.company') !!}</a>
                <span><a href="{{ $socials->where('key', 'phone')->first()->value }}">{{ $phone_number }}</a></span>

                <div class="footer2-kontakti-social">
                    @foreach($socials->where('status', 1) as $social)
                    <a href="{{ $social->value }}">
                        <i aria-hidden="true" class="{{ $social->icon }}" style="color: {{ $social->color }};"></i>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="fabmenu">
        <a href="{{ $socials->where('key', 'instagram')->first()->value }}" class="hidden"><i class="fa-brands fa-instagram"></i></a>
        <a href="{{ $socials->where('key', 'whatsapp')->first()->value }}" class="hidden"><i class="fa-brands fa-whatsapp"></i></a>
        <i class="fa-solid fa-comments" onclick="fabmenuopen()"></i>
    </div>

    <script>
        // languages-switchers
        function toggleLanguageMenu() {
            document.getElementById("languageSwitch").classList.toggle("active");
        }

        // Tashqaridan bosilganda menyuni yopish
        document.addEventListener("click", function(event) {
            const languageDiv = document.querySelector(".language");
            const languageMenu = document.getElementById("languageSwitch");

            if (!languageDiv.contains(event.target)) {
                languageMenu.classList.remove("active");
            }
        });

        function menu() {
            let menu = document.getElementById("menu");
            menu.classList.toggle("hidden");
        }

        function mobile_language_switch() {
            let menu = document.getElementById("language-options");
            menu.classList.toggle("hidden");
        }

        // catalog menu ochish
        function catologListbtn() {
            const modal = document.querySelector('.catalog-list-modal');
            modal.classList.toggle('hidden'); // Agar "hidden" bo‘lsa olib tashlaydi, yo‘q bo‘lsa qo‘shadi
        }

        function fabmenuopen() {
            let links = document.querySelectorAll(".fabmenu a:not(:last-child)");
            links.forEach((link, index) => {
                if (link.classList.contains("hidden")) {
                    link.style.transitionDelay = `${index * 0.1}s`; // Animatsiya kechikishi
                } else {
                    link.style.transitionDelay = `${(links.length - index - 1) * 0.1}s`;
                }
                link.classList.toggle("hidden");
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
