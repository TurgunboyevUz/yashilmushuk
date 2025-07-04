<title>{{ $seo['title'] ?? config('app.name') }}</title>
<meta name="description" content="{{ $seo['description'] ?? 'Default description' }}">
<meta name="keywords" content="{{ $seo['keywords'] ?? '' }}">
<meta name="robots" content="{{ $seo['robots'] ?? 'index, follow' }}">

<link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">

<meta property="og:title" content="{{ $seo['title'] ?? config('app.name') }}">
<meta property="og:description" content="{{ $seo['description'] ?? 'Default description' }}">
<meta property="og:image" content="{{ $seo['image'] ?? asset('images/default.jpg') }}">
<meta property="og:url" content="{{ $seo['canonical'] ?? url()->current() }}">
<meta property="og:type" content="{{ $seo['type'] ?? 'website' }}">
<meta property="og:site_name" content="{{ config('app.name') }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seo['title'] ?? config('app.name') }}">
<meta name="twitter:description" content="{{ $seo['description'] ?? 'Default description' }}">
<meta name="twitter:image" content="{{ $seo['image'] ?? asset('images/default.jpg') }}">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "{{ config('app.name') }}",
  "url": "{{ url('/') }}",
  "logo": "{{ $seo['logo'] ?? '' }}",
  "sameAs": [
      @foreach($socials as $social)
        {{ $social }}
      @endforeach
  ]
}
</script>