@extends('layout.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sindicat/blog.css') }}">
@endpush

@section('content')
<!-- cards -->
<div class="cards container">
    @foreach($posts as $post)
    <div class="cards-item">
        <a href="{{ route('blog.show', $post->slug) }}">
            <img src="{{ $post->path() }}" alt="{{ $post->title }}">
            <h1>{{ $post->title }}</h1>
            <button>{{ __('general.in_detail') }}</button>
        </a>
    </div>
    @endforeach
</div>
@endsection
