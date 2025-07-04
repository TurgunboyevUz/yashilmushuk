@extends('layout.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sindicat/faq.css') }}">
@endpush

@push('scripts')
<script>
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

<div class="catalog-header container" style="background: url({{ asset('storage/' . $banners->where('key', 'faq')->first()->image) }})">
    <h1>{!! __('faq.title') !!}</h1>
</div>

<!-- acardion -->
<div class="vapros-otveti container">
    <h1>{{ __('faq.questions') }}</h1>
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
@endsection
