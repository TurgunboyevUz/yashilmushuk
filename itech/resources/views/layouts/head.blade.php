@php
    use App\Models\Page\Meta;

    $metas = Meta::all();

    $titles = [
        'index' => 'Bosh sahifa',
        'products' => 'Mahsulotlar',
        'product.detail' => 'Mahsulot haqida',
        'news' => 'Yangiliklar',
        'news.category' => 'Yangiliklar',
        'page' => 'Blog',
        'about' => 'Biz haqimizda',
        'contact' => 'Aloqa',
        'search' => "Mahsulotlarni qidirish"
    ];

    $route = request()?->route()?->getName();
    $title = $titles[$route] ?? $titles['index'];
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @foreach($metas as $meta)
        <meta name="{{ $meta->key }}" content="{{ $meta->value }}">
    @endforeach
    
    <title>Texno Innovator | {{ $title ?? 'Bosh sahifa'}}</title>

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link href="{{ asset('css/page.css') }}" rel="stylesheet">

    <!-- AOS CSS -->
    <link href="{{ asset('css/aos.css') }}" rel="stylesheet">
</head>