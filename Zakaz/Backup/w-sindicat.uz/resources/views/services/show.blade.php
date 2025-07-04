@extends('layout.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sindicat/services.show.css') }}">
@endpush

@section('content')
<!-- header -->
<div class="blogsinglepage-header container">
    <h1>{{ $service->name }}</h1>
    <h2>{{ $service->title }}</h2>
</div>

<div class="blogsinglepage-content container">
    {!! $service->body !!}

    <button><a href="{{ $contact_button['url'] }}">{{ __('services.consultation') }}</a></button>
</div>

<div class="blogsinglepage-contact">
    <h1>{{ __('general.in_socials') }}</h1>
    <a href="{{ $socials->where('key', 'telegram')->first()->value }}"><i class="fa-brands fa-telegram"></i>Telegram</a>
    <a href="{{ $socials->where('key', 'instagram')->first()->value }}"><i class="fa-brands fa-instagram"></i></i>Instagram</a>
    <a href="{{ $socials->where('key', 'youtube')->first()->value }}"><i class="fa-brands fa-youtube"></i>YouTube</a>
</div>

<div class="chto-mi-predlagaem container">
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
@endsection
