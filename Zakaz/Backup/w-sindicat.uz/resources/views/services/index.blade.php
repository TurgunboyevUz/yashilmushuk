@extends('layout.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sindicat/services.css') }}">
@endpush

@section('content')
<!-- services header -->
<div class="services-header container" style="background: url({{ asset('storage/' . $banners->where('key', 'services')->first()->image) }})">
    <h1>{!! __('services.title') !!}</h1>
    <h2>{{ __('services.subtitle') }}</h2>
</div>
<!-- services card -->

<div class="services-cards container">
    @foreach($services as $service)
        <div class="services-cards-item" style="background-image: url({{ $service->path() }})">
            <div class="services-cards-item-detalies">
                <h1>{{ $service->name }}</h1>
                <a href="{{ route('services.show', $service->slug) }}">{{ __('general.in_detail') }} ></a>
            </div>
        </div>
    @endforeach
</div>
@endsection
