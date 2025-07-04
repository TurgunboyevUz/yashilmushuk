@extends('layout.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sindicat/blog.show.css') }}">
@endpush

@section('content')
<div class="blogsinglepage-content container">
    <h1 class="title">{{ $post->title }}</h1>
    <h2 class="subtitle">{{ $post->subtitle }}</h2>

    <p>{!! str_replace(['<pre>', '</pre>'], ['<p>', '</p>'], $post->body) !!}<p>

    <style>
        p {
            max-width: 1200px;
            margin: 0 auto; /* sahifa markaziga chiqaradi */
            text-align: center; /* matnni markazlaydi */
            word-wrap: break-word;
            line-height: 1.6;
            font-size: 18px;
            color: #333;
            justify-content: center;
        }
    </style>

    <a href="{{ route('catalog.index') }}">{{ __('catalog.see_all') }}</a>
</div>

<div class="blogsinglepage-contact">
    <h1>Мы в социальных сетях:</h1>
    <a href="{{ $socials->where('key', 'telegram')->first()->value }}"><i class="fa-brands fa-telegram"></i>Telegram</a>
    <a href="{{ $socials->where('key', 'instagram')->first()->value }}"><i class="fa-brands fa-instagram"></i></i>Instagram</a>
    <a href="{{ $socials->where('key', 'youtube')->first()->value }}"><i class="fa-brands fa-youtube"></i>YouTube</a>
</div>
@endsection
