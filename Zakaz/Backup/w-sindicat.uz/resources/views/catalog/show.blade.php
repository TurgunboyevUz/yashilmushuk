@extends('layout.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sindicat/catalog.css') }}">
@endpush

@push('scripts')
<script>
    function catologListbtn() {
        const modal = document.querySelector('.catalog-list-modal');
        modal.classList.toggle('hidden'); // Agar "hidden" bo‘lsa olib tashlaydi, yo‘q bo‘lsa qo‘shadi
    }

    document.addEventListener("DOMContentLoaded", function () {
    // Modal slider initialization
    let modal = document.getElementById("modal");
    let modalSlider = document.getElementById("modal-slider");
    let modalPrev = document.getElementById("modal-prev");
    let modalNext = document.getElementById("modal-next");
    let modalDots = document.getElementById("modal-dots");
    let closeBtn = document.querySelector(".close-btn");

    let currentIndex = 0;
    let images = [];

    // Modal open and image load
    document.querySelectorAll(".slider-img").forEach(img => {
        img.addEventListener("click", function () {
            images = Array.from(this.parentElement.querySelectorAll(".slider-img")).map(img => img.src);
            currentIndex = parseInt(this.getAttribute("data-index"));

            renderImages();
            modal.style.display = "flex";
        });
    });

    // Render images in modal
    function renderImages() {
        modalSlider.innerHTML = "";
        modalDots.innerHTML = "";

        images.forEach((src, index) => {
            let img = document.createElement("img");
            img.src = src;
            img.classList.add("modal-img-slide");
            if (index === currentIndex) img.classList.add("active");
            modalSlider.appendChild(img);

            let dot = document.createElement("span");
            dot.classList.add("dot");
            dot.addEventListener("click", () => {
                currentIndex = index;
                updateSlide();
            });
            modalDots.appendChild(dot);
        });

        updateSlide();
    }

    // Update the modal image and dot
    function updateSlide() {
        document.querySelectorAll(".modal-img-slide").forEach((img, index) => {
            img.classList.toggle("active", index === currentIndex);
        });

        document.querySelectorAll(".dot").forEach((dot, index) => {
            dot.classList.toggle("active", index === currentIndex);
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener("click", function () {
            modal.style.display = "none";
        });
    }

    modalNext.addEventListener("click", function () {
        if (currentIndex < images.length - 1) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        updateSlide();
    });

    modalPrev.addEventListener("click", function () {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = images.length - 1;
        }
        updateSlide();
    });

    window.onload = function () {
        modal.style.display = "none";
    };

    let cardSliders = document.querySelectorAll('.catalog-catalog-card-item');

    cardSliders.forEach((sliderContainer, index) => {
        let slider = sliderContainer.querySelector('.slider');
        let images = slider.querySelectorAll('img');
        let dots = sliderContainer.querySelector('.dots');
        let prevButton = sliderContainer.querySelector(`#card-prev-${index}`);
        let nextButton = sliderContainer.querySelector(`#card-next-${index}`);

        let currentIndex = 0;

        images.forEach((image, i) => {
            let dot = document.createElement('span');
            dot.classList.add('dot');
            dot.addEventListener('click', () => {
                currentIndex = i;
                updateCardSlide();
            });
            dots.appendChild(dot);
        });

        function updateCardSlide() {
            images.forEach((image, i) => {
                image.classList.toggle('active', i === currentIndex);
            });

            let allDots = dots.querySelectorAll('.dot');
            allDots.forEach((dot, i) => {
                dot.classList.toggle('active', i === currentIndex);
            });
        }

        nextButton.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % images.length;
            updateCardSlide();
        });

        prevButton.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateCardSlide();
        });

        updateCardSlide();
    });
});
</script>
@endpush

@section('content')
<!-- /catalog header -->

<div class="catalog-header container" style="background: url({{ asset('storage/' . $banners->where('key', 'catalog')->first()->image) }})">
    <h1>{!! __('catalog.title') !!}</h1>
    <h2>{{ __('catalog.subtitle') }}</h2>
</div>

<div class="catalog-catalog container">
    <div class="catalog-menu" onclick="catologListbtn()">
        <h1>{{ __('catalog.assortiment') }}</h1>
        <i class="fa-solid fa-bars"></i>
    </div>
    <div class="catalog-catalog-list">
        @foreach($sidebar as $catalog)
        <h1>{{ $catalog->name }}</h1>
        <ul>
            @foreach($catalog->categories as $category)
            <li><a href="{{ route('catalog.show', [$catalog->slug, $category->slug ]) }}">
                    <i class="fas fa-chevron-right"></i> {{ $category->name }}
                </a></li>
            @endforeach
        </ul>
        @endforeach
    </div>
    <div class="catalog-catalog-card">
        <div id="modal" class="modal">
            <span class="close-btn" id="close-btn">&times;</span>
            <div class="modal-content">
                <button class="prev" id="modal-prev">&#60;</button>
                <div id="modal-slider" class="modal-slider"></div>
                <button class="next" id="modal-next">&#62;</button>
                <div id="modal-dots" class="dots"></div>
            </div>
        </div>

        @foreach($products as $product)
        <div class="catalog-catalog-card-item">
            <div class="slider" id="slider-{{ $loop->index }}">
                @foreach($product->images as $image)
                <img src="{{ asset('storage/' . $image) }}" alt="" class="slider-img" data-index="{{ $loop->index }}">
                @endforeach
            </div>

            <!-- Navigation buttons for catalog -->
            <button class="prev" id="card-prev-{{ $loop->index }}">&#60;</button>
            <button class="next" id="card-next-{{ $loop->index }}">&#62;</button>

            <!-- DOTS -->
            <div class="dots" id="dots-{{ $loop->index }}"></div>

            <p>{{ __('catalog.cost') }}: {{ $product->price_formatted() }}</p>
            <p>{{ __('catalog.size') }}: {{ $product->size }}</p>
            <p>{{ __('catalog.color') }}: {{ $product->color }}</p>
            <p>{{ __('catalog.code') }}: {{ $product->code }}</p>

            @if(!empty($product->brands))
            <p>{{ __('catalog.brand') }}: {{ implode(',', $product->brands) }}</p>
            @endif

            <p>{{ $product->is_available ? __('catalog.available') : __('catalog.by_order') }}</p>

            <br>
            
            <h1>{{ $product->name }}</h1>
            <a href="{{ $product->url . "?text=" . $product->text }}"><button>{{ __('catalog.order') }}</button></a>
        </div>
        @endforeach
    </div>

</div>

<div class="catalog-list-modal hidden">
    <i class="fa-solid fa-xmark" onclick="catologListbtn()"></i>
    <div class="catalog-list-modal-list">
        @foreach($sidebar as $catalog)
        <h1>{{ $catalog->name }}</h1>
        <ul>
            @foreach($catalog->categories as $category)
            <li><a href="{{ route('catalog.show', [$catalog->slug, $category->slug ]) }}">
                    <i class="fas fa-chevron-right"></i> {{ $category->name }}
                </a></li>
            @endforeach
        </ul>
        @endforeach
    </div>
</div>
@endsection
