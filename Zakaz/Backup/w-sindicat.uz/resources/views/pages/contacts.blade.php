@extends('layout.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sindicat/contacts.css') }}">
@endpush

@section('content')

<!-- header-section -->

<div class="catalog-header container" style="background: url({{ asset('storage/' . $banners->where('key', 'contacts')->first()->image) }})">
    <h1>{!! __('contact.title') !!}</h1>
</div>

<div class="contact-section container">
    <div class="contact-section-detalies">
        <h1> {{ __('general.contacts') }} </h1>
        <p> {!! __('general.company') !!} </p>

        <a href={{ $socials->where('key', 'phone')->first()->value }}">{{ $phone_number }}</a>
        
        <div class="contact-section-detalies-social">
            @foreach($socials->where('status', 1) as $social)
                <a href="{{ $social->value }}">
                    <i aria-hidden="true" class="{{ $social->icon }}" style="color: {{ $social->color }};"></i>
                </a>
            @endforeach
        </div>
    </div>

    <div class="contact-map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3011.3306524530763!2d71.7249665!3d40.996135499999994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38bb4f53c5f13137%3A0xf764dbe76149405f!2sBalance%20tex%20MCHJ!5e0!3m2!1suz!2s!4v1739946126374!5m2!1suz!2s" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>
@endsection