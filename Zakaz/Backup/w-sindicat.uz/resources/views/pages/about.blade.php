@extends('layout.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sindicat/about.css') }}">
@endpush

@push('scripts')
<script>
    // slider

    const slider = document.querySelector(".nasha-komanda-slider");

    function duplicateLogos() {
        let logos = slider.innerHTML;
        slider.innerHTML += logos; // Logolarni takrorlaymiz
    }

    duplicateLogos(); // Funksiyani chaqiramiz


    // modal
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("imageModal");
        const modalImg = document.getElementById("modalImg");
        const closeBtn = document.querySelector(".close");

        document.querySelectorAll(".gallery-img").forEach(img => {
            img.addEventListener("click", function() {
                modal.style.display = "flex";
                modalImg.src = this.src;
            });
        });

        closeBtn.addEventListener("click", () => {
            modal.style.display = "none";
        });

        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.style.display = "none";
            }
        });
    });


    // acardion

    document.querySelectorAll(".vapros-otveti-item-header").forEach(button => {
        button.addEventListener("click", () => {
            const content = button.nextElementSibling;

            // Yopish va ochish
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                document.querySelectorAll(".vapros-otveti-item-content").forEach(item => {
                    item.style.display = "none";
                });
                content.style.display = "block";
            }
        });
    });
</script>
@endpush

@section('content')

<!-- header-section -->

<div class="header-section container" style="background: url({{ asset('storage/' . $banners->where('key', 'about')->first()->image) }})">
    <div class="header-secion-left">
        <h1>{!! __('about.title') !!}
        </h1>
        <p>{{ __('about.paragraph1') }}</p>
        <p>{{ __('about.paragraph2') }}</p>
        <p>{{ __('about.paragraph3') }}</p>

    </div>
    <div class="header-section-right">
        <video src="{{ $video->path() }}" class="header-section-right-video" controls />
    </div>
</div>

<!-- 2-section -->

<div class="nasha-komanda container">
    <h1>{{ __('about.clients') }}</h1>
    <p>{{ __('about.clients_subtitle') }}</p>
    <div class="nasha-komanda-slider">
        @foreach($clients as $client)
            <img src="{{ $client->path() }}" alt="{{ $client->name }}">
        @endforeach
    </div>
</div>


<!-- 3-section -->
<div class="galler container">
    @foreach($abouts->where('type', 'fabric') as $about)
        <img src="{{ asset('storage/' . $about->image) }}" alt="" class="gallery-img">    
    @endforeach
</div>

<!-- Modal -->
<div class="modal" id="imageModal">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImg">
</div>


<!-- 4-section -->

<div class="oborudovaniye-moshnost container">
    <h1>{{ __('about.equipments') }}</h1>
    <p>{{ __('about.equipments_subtitle') }}</p>
    <div class="oborudovaniye-moshnost-galler">
        @foreach($abouts->where('type', 'equipment') as $about)
            <img src="{{ asset('storage/' . $about->image) }}" alt="" class="gallery-img">    
        @endforeach
    </div>
</div>

<!-- 5-section acardion -->
<div class="vapros-otveti container">
    <h1>{{ __('about.faq') }}</h1>
    @foreach($faqs as $faq)
    <div class="vapros-otveti-item">
        <div class="vapros-otveti-item-header">
            <h2>{{ $faq->question }}</h2>
            <i class="fa-solid fa-plus"></i>
        </div>
        <div class="vapros-otveti-item-content">
            <p>{{ $faq->answer }}</p>
        </div>
    </div>
    @endforeach
</div>

<!-- 6-section -->
<div class="na-keysi container">
    <h1>{{ __('index.case.title') }}</h1>
    <div class="na-keysi-videos">
        @foreach($youtubes as $youtube)
            <iframe class="youtube-video" src="{{ $youtube->url }}" frameborder="0" allowfullscreen></iframe>
        @endforeach
    </div>
</div>
@endsection
