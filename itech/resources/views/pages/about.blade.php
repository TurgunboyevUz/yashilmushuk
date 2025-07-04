@extends('layouts.app')

@section('content')
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Biz haqimizda</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('index') }}">Bosh sahifa</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Biz haqimizda</p>
        </div>
    </div>
</div>

<div class="container-fluid py-5">
    <div class="container">
        <!-- Hero Section -->
        <div class="row align-items-center mb-5" data-aos="fade-up">
            <div class="col-lg-6">
                <img src="{{ $image }}" alt="TEXNO-INNOVATOR" class="img-fluid rounded">
            </div>
            <div class="col-lg-6 pl-lg-5 text-center text-lg-left">
                <h1 class="text-primary mb-4">TEXNO-INNOVATOR</h1>
                <h3 class="mb-4">2007 yil tashkil topdi</h3>
                <p class="mb-4">Asosiy faoliyati plastmassa mahsulotlarini ishlab chiqarish (xo'jalik mollari).</p>
                <a href="{{ route('products') }}" class="btn btn-primary py-2 px-4"><i class="fa fa-shopping-basket mr-2"></i>Barcha mahsulotlar</a>
            </div>
        </div>

        <!-- Company Info -->
        <div class="row mb-5" data-aos="fade-up">
            <div class="col-lg-12">
                <div class="card border-0 bg-light">
                    <div class="card-body p-5">
                        <h4 class="mb-4">Kompaniya ma'lumotlari</h4>
                        <div class="row">
                            <div class="col-md-6">
                                {!! $company !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="row mb-5" data-aos="fade-up">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <h4 class="mb-4">Qo'shimcha ma'lumotlar</h4>
                        <ul class="list-unstyled">
                            @foreach($additional as $item)
                            <li class="mb-3">
                                <i class="fas fa-check text-primary mr-2"></i>{!! str_replace(['<p>', '</p>'], '', str($item->value)->markdown()->sanitizeHtml()) !!}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map and Contact -->
        <div class="row" data-aos="fade-up">
            <div class="col-lg-6 mb-5">
                <h4 class="mb-4">Bizning manzil</h4>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="{{ $map }}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
            <div class="col-lg-6">
                <h4 class="mb-4">Aloqa</h4>
                <div class="d-flex flex-column">
                    <a href="tel:{{ $phone }}" class="mb-3 text-dark">
                        <i class="fas fa-phone-alt text-primary mr-2"></i>
                        {{ $phone }}
                    </a>
                    <a href="{{ $telegram }}" class="mb-3 text-dark">
                        <i class="fab fa-telegram text-primary mr-2"></i>
                        Telegram kanal
                    </a>
                    <a href="{{ $instagram }}" class="mb-3 text-dark">
                        <i class="fab fa-instagram text-primary mr-2"></i>
                        Instagram
                    </a>
                    <a class="text-dark mb-3" href="{{ $whatsapp }}"><i class="fab fa-whatsapp text-primary mr-2"></i>WhatsApp</a>
                    <a class="text-dark mb-3" href="{{ $youtube }}"><i class="fab fa-youtube text-primary mr-2"></i>YouTube</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
