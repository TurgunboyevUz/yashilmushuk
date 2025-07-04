@extends('layouts.app')

@php
    use App\Models\Product\Color;
@endphp

@section('content')
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5" data-aos="fade-up">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Ommabop kategoriyalar - {{ $category->name }}</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('index') }}">Bosh sahifa</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Ommabop kategoriyalar</p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">{{ $category->name }}</p>
        </div>
    </div>
</div>
<!-- Page Header End -->
<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">{{ $category->name }}</span></h2>
        <p><i class="fas fa-info-circle mr-2"></i>Umumiy: {{ $category->products->count() }} ta mahsulot mavjud</p>
    </div>
    @if($category->products->count() > 0)
    <div class="row px-xl-5 pb-3">
        <!-- Mahsulot 1 -->
        @foreach($products as $product)
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1" data-aos="fade-up" data-aos-delay="100">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <img class="img-fluid w-100" src="{{ asset('storage/' . $product->image_path[0]) }}" alt="Image">
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

    <div class="col-12 pb-1">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                @if ($products->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">&laquo; Oldingi</span>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Oldingi">
                        <span aria-hidden="true">&laquo; Oldingi</span>
                    </a>
                </li>
                @endif

                @foreach ($products->links()->elements[0] as $page => $url)
                <li class="page-item {{ $products->currentPage() == $page ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
                @endforeach

                @if ($products->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Keyingi">
                        <span aria-hidden="true">Keyingi &raquo;</span>
                    </a>
                </li>
                @else
                <li class="page-item disabled">
                    <span class="page-link">Keyingi &raquo;</span>
                </li>
                @endif
            </ul>
        </nav>
    </div>
    @else
    <div class="text-center pt-5">
        <h5 class="text-muted">Bu kategoriyada mahsulotlar mavjud emas</h5>
    </div>
    @endif
</div>
<!-- Products End -->
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