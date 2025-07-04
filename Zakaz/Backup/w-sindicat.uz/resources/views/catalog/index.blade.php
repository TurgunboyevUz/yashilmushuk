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
        <h1>Ассортимент</h1>
        <i class="fa-solid fa-bars"></i>
    </div>
    <div class="catalog-catalog-list">
        @foreach($catalogs as $catalog)
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
        @foreach($catalogs as $catalog)
        <a href="{{ route('catalog.show', [$catalog->slug, $catalog->categories->first()->slug ?? '' ]) }}">
            <img src="{{ $catalog->path() }}" alt="{{ $catalog->name }}">
        </a>
        @endforeach
    </div>
</div>

<div class="catalog-list-modal hidden">
    <i class="fa-solid fa-xmark" onclick="catologListbtn()"></i>
    <div class="catalog-list-modal-list">
        @foreach($catalogs as $catalog)
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
