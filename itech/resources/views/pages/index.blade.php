@extends('layouts.app')

@php
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\Product\Size;
use App\Models\Product\Color;
@endphp

@section('content')
<!-- Korxonaning afzalliklari boshlanadi -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3 justify-content-center align-items-center">
        @foreach($advantages as $advantage)
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1" data-aos="fade-right">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa {{ $advantage->icon }} text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">{{ $advantage->content }}</h5>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Korxonaning afzalliklari tugadi -->

<!-- Categories Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Ommabop kategoriyalar</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        @foreach ($categories as $category)
        <div class="col-lg-4 col-md-6 pb-1" data-aos="fade-up" data-aos-delay="100">
            <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                <p class="text-right">{{ $category->products_count }} ta mahsulotlar</p>
                <a href="{{ route('category', $category->id) }}" class="cat-img position-relative overflow-hidden mb-3">
                    <img class="img-fluid" src="{{ asset('storage/' . $category->image_path) }}" alt="Kategoriya">
                </a>
                <h5 class="font-weight-semi-bold m-0">{{ $category->name }}</h5>
                <br>
                <p class="text-muted mb-3">So'nggi yangilanish: {{ Carbon\Carbon::parse($category->products->sortByDesc('updated_at')->first()?->updated_at ?? $category->updated_at)->format("d.m.Y | H:i") }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Categories End -->

<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Ommabop mahsulotlarimiz</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        @foreach ($top_products as $product)
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1" data-aos="fade-up" data-aos-delay="100">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <img class="img-fluid w-100" src="{{ asset('storage/' . $product->image_path[0]) }}" alt="">
                </div>
                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                    <h6 class="text-truncate mb-3">{{ $product->name }}</h6>
                    <p class="text-muted mb-3"><strong>Kategoriyasi:</strong> {{ $product->category->name }}</p>
                    <p class="text-muted mb-3">
                        <strong>Ranglar:</strong>
                        @php
                        $data = "";

                        foreach($product->colors as $color){
                            $data .= Color::find($color)->name . ', ';
                        }

                        $data = substr($data, 0, -2);
                        @endphp

                        {{ $data }}
                    </p>
                    <p class="text-muted mb-3">
                        <strong>O'lchamlar:</strong>
                        @if($product->prices->pluck('size_id')->filter()->isEmpty())
                        O'lchamlar mavjud emas
                        @else
                        @php
                        $data = "";
                        foreach($product->prices as $price){
                        $data .= $price->size->name . ', ';
                        }

                        $data = substr($data, 0, -2);
                        @endphp

                        {{ $data }}
                        @endif
                    </p>

                    <p class="text-muted mb-3">
                        <strong>Narxlar:</strong>
                        @if($product->prices->pluck('price')->filter()->isEmpty())
                        Narxlar mavjud emas
                        @else
                        @php
                        $data = "";
                        foreach($product->prices as $price){
                            if(empty($price->price)){
                                continue;
                            }

                            $data .= number_format($price->price, 0, '.', ',') . ' so\'m | ';
                        }

                        $data = substr($data, 0, -3);
                        @endphp
                        {{ $data }}
                        @endif
                    </p>
                </div>
                <div class="card-footer d-flex justify-content-between bg-light border">
                    <a href="{{ route('product.detail', $product->id) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Batafsil ko'rish</a>
                    <a href="#" class="btn btn-sm text-dark p-0 order-btn" 
                       data-id="{{ $product->id }}"
                       data-toggle="modal" 
                       data-target="#orderModal">
                        <i class="fas fa-shopping-cart text-primary mr-1"></i>Buyurtma qilish
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Products End -->

<!-- Subscribe Start -->
<div class="container-fluid bg-secondary my-5">
    <div class="row justify-content-md-center py-5 px-xl-5">
        <div class="col-md-6 col-12 py-5 text-center" data-aos="fade-up" data-aos-delay="100">
            <div class="mb-2 pb-2">
                <h2 class="section-title px-5 mb-3"><span class="bg-secondary px-2"> <i class="fab fa-telegram-plane mr-2"></i> Telegram</span></h2>
                <p>Texno Innovator korxonasining Telegram kanaliga obuna bo'lib, barcha yangiliklarni kuzatib
                    boring.</p>
            </div>
            <a href="{{ $telegram }}" class="btn btn-primary px-4 d-inline-flex align-items-center">
                <i class="fab fa-telegram-plane mr-2"></i>Obuna bo'ling
            </a>
        </div>
    </div>
</div>
<!-- Subscribe End -->
<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4" data-aos="fade-down">
        <h2 class="section-title px-5"><span class="px-2">Yangi mahsulotlarimiz</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        @foreach ($new_products as $product)
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1" data-aos="fade-up" data-aos-delay="100">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <img class="img-fluid w-100" src="{{ asset('storage/' . $product->image_path[0]) }}" alt="">
                </div>
                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                    <h6 class="text-truncate mb-3">{{ $product->name }}</h6>
                    <p class="text-muted mb-3"><strong>Kategoriyasi:</strong> {{ $product->category->name }}</p>
                    <p class="text-muted mb-3">
                        <strong>Ranglar:</strong>
                        @php
                        $data = "";

                        foreach($product->colors as $color){
                            $data .= Color::find($color)->name . ', ';
                        }

                        $data = substr($data, 0, -2);
                        @endphp

                        {{ $data }}
                    </p>
                    <p class="text-muted mb-3">
                        <strong>O'lchamlar:</strong>
                        @if($product->prices->pluck('size_id')->filter()->isEmpty())
                        O'lchamlar mavjud emas
                        @else
                        @php
                        $data = "";
                        foreach($product->prices as $price){
                        $data .= $price->size->name . ', ';
                        }

                        $data = substr($data, 0, -2);
                        @endphp

                        {{ $data }}
                        @endif
                    </p>

                    <p class="text-muted mb-3">
                        <strong>Narxlar:</strong>
                        @if($product->prices->pluck('price')->filter()->isEmpty())
                        Narxlar mavjud emas
                        @else
                        @php
                        $data = "";
                        foreach($product->prices as $price){
                            if(empty($price->price)){
                                continue;
                            }
                            $data .= number_format($price->price, 0, '.', ',') . ' so\'m | ';
                        }

                        $data = substr($data, 0, -3);
                        @endphp
                        {{ $data }}
                        @endif
                    </p>
                </div>
                <div class="card-footer d-flex justify-content-between bg-light border">
                    <a href="{{ route('product.detail', $product->id) }}" class="btn btn-sm text-dark p-0">
                        <i class="fas fa-eye text-primary mr-1"></i>Batafsil ko'rish
                    </a>
                    <a href="#" class="btn btn-sm text-dark p-0 order-btn" 
                       data-id="{{ $product->id }}"
                       data-toggle="modal" 
                       data-target="#orderModal">
                        <i class="fas fa-shopping-cart text-primary mr-1"></i>Buyurtma qilish
                    </a>
                </div>
                
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    let productId; // Global o'zgaruvchi sifatida e'lon qilamiz

    // Modal ochilganda mahsulot ID sini olish
    $(document).on('click', '.order-btn', function () {
        productId = $(this).data('id'); // Modal ochilganda data-id ni olish
        console.log('Product ID:', productId); // Debug uchun
    });

    $('#orderModal form').submit(function (e) {
        e.preventDefault();

        // Modal kontekstida input elementlarini olish
        const modal = $('#orderModal');
        const name = modal.find('#name').val();
        const phone = modal.find('#phone').val();
        const telegram = modal.find('#telegram').val();

        // Ma'lumotlarni tekshirish
        if (!name || !phone) {
            alert('Ismingiz va telefon raqamingizni to\'ldiring!');
            return;
        }

        // Route URL'ni dinamik o'zgartirish
        let url = '{{ route("product.modal", ["id" => ":productId"]) }}';
        url = url.replace(':productId', productId); // `productId` ni URL'ga qo'shish

        // AJAX so'rovini jo'natish
        $.ajax({
            url: url, // Yangi URL
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                name: name,
                phone: phone,
                telegram: telegram,
            },
            success: function (response) {
                alert('Buyurtma muvaffaqiyatli yuborildi!');
                modal.modal('hide'); // Modalni yopish
                modal.find('form')[0].reset(); // Formani tozalash
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Buyurtma yuborishda xatolik yuz berdi.');
            }
        });
    });
});

</script>
@endsection