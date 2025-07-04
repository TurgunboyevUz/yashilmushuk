@extends('layouts.app')

@php
use App\Models\Product\Color;
@endphp
@section('content')
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 pb-5">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner border">
                    @php $i = 1; @endphp
                    @foreach ($product->image_path as $image)
                    <div class="carousel-item {{ $i++ == 1 ? 'active' : '' }}">
                        <img class="w-100 h-100 zoom-image" src="{{ asset('storage/' . $image) }}" alt="Image">
                    </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                </a>
                <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-7 pb-5">
            <h3 class="font-weight-semi-bold">{{ $product->name }}</h3>
            <div class="d-flex mb-3">
                <div class="text-primary mr-2">
                    @php
                    $averageScore = $comments->avg('score');
                    $fullStars = floor($averageScore);
                    $halfStar = ($averageScore - $fullStars) >= 0.5 ? 1 : 0;
                    $emptyStars = 5 - $fullStars - $halfStar;
                    @endphp
                    @for ($i = 0; $i < $fullStars; $i++) <small class="fas fa-star"></small>
                        @endfor
                        @if ($halfStar)
                        <small class="fas fa-star-half-alt"></small>
                        @endif
                        @for ($i = 0; $i < $emptyStars; $i++) <small class="far fa-star"></small>
                            @endfor
                </div>
                <small class="pt-1">({{ $comments->count() }} ta sharh)</small>
            </div>
            <h3 class="font-weight-semi-bold mb-4">
                @php
                $price = (int) $product->prices->pluck('price')->sortDesc()->filter()->first();

                if($price){
                $price = number_format($price, 0, '.', ',');
                $price .= " so'm";
                }else{
                $price = "Narx belgilanmagan";
                }
                @endphp
                {{ $price }}
            </h3>
            <p class="mb-4">{{ $product->description }}</p>
            <div class="d-flex mb-3">
                <p class="text-dark font-weight-medium mb-0 mr-3">O'lchamlar:</p>
                <form>
                    @if($product->prices->pluck('size_id')->filter()->isEmpty())
                    O'lchamlar mavjud emas
                    @else
                    @php
                    $data = [];
                    foreach($product->prices as $price){
                    $data[] = [
                    'id' => $price->size_id,
                    'name' => $price->size->name,
                    ];
                    }
                    @endphp

                    @foreach ($data as $size)
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="size-{{ $size['id'] }}" name="size" value="{{ $size['id'] }}">
                        <label class="custom-control-label" for="size-{{ $size['id'] }}">{{$size['name']}}</label>
                    </div>
                    @endforeach
                    @endif
                </form>
            </div>
            <div class="d-flex mb-4">
                <p class="text-dark font-weight-medium mb-0 mr-3">Ranglar:</p>
                <form>
                    @foreach($product->colors as $color)
                    @php $color = Color::find($color); @endphp
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="color-{{ $color->id }}" name="color" value="{{ $color->id }}">
                        <label class="custom-control-label" for="color-{{ $color->id }}">{{ $color->name }}</label>
                    </div>
                    @endforeach
                </form>
            </div>
            <div class="d-flex align-items-center mb-4 pt-2">
                <div class="input-group quantity mr-3" style="width: 130px;">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-minus">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control bg-secondary text-center" value="1">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-plus">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <button class="btn btn-primary px-3" data-toggle="modal" data-target="#orderModal"><i class="fa fa-shopping-cart mr-1"></i> Buyurtma berish</button>
            </div>
        </div>
    </div>
</div>

<!-- New Tab Section Start -->
<div class="row px-xl-5">
    <div class="col">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <div class="nav nav-tabs justify-content-center border-secondary mb-4">
            <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Mahsulot tasnifi</a>
            <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Fikrlar ({{ $comments->count() }})</a>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-pane-1">
                <h4 class="mb-3">Mahsulot tavsifi</h4>
                <p>{{ $product->description }}</p>
            </div>
            <div class="tab-pane fade" id="tab-pane-3">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-4">"{{ $product->name }}" uchun {{ $comments->count() }} ta sharh</h4>
                        @foreach($comments->take(3) as $comment)
                        <div class="media mb-4">
                            <div class="media-body">
                                <h6>{{ $comment->name }}<small> - <i>{{ $comment->created_at->format('d-m-Y') }}</i></small></h6>
                                <div class="text-primary mb-2">
                                    @for($i = 1; $i <= 5; $i++) @if($i <=$comment->score)
                                        <i class="fas fa-star"></i>
                                        @elseif($i == $comment->score + 0.5)
                                        <i class="fas fa-star-half-alt"></i>
                                        @else
                                        <i class="far fa-star"></i>
                                        @endif
                                        @endfor
                                </div>
                                <p>{{ $comment->content }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="col-md-6">
                        <h4 class="mb-4">Fikr bildirish</h4>
                        <small>Sizning elektron pochta manzilingiz nashr qilinmaydi. Majburiy maydonlar * bilan belgilangan</small>

                        <form action="{{ route('product.comment', $product->id) }}" method="POST">
                            @csrf

                            <!-- Rating Section -->
                            <div class="form-group">
                                <label for="rating">Baholash * :</label>
                                <div class="text-primary" id="star-rating">
                                    <i class="far fa-star" data-index="1"></i>
                                    <i class="far fa-star" data-index="2"></i>
                                    <i class="far fa-star" data-index="3"></i>
                                    <i class="far fa-star" data-index="4"></i>
                                    <i class="far fa-star" data-index="5"></i>
                                </div>
                                <input type="hidden" id="rating-input" name="score" required>
                            </div>

                            <!-- Comment Section -->
                            <div class="form-group">
                                <label for="message">Fikr bildirish * :</label>
                                <textarea id="message" name="content" cols="30" rows="5" class="form-control" required></textarea>
                            </div>

                            <!-- Name Field -->
                            <div class="form-group">
                                <label for="name">Ismingiz * :</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <!-- Phone Field -->
                            <div class="form-group">
                                <label for="phone">Telefon raqamingiz yoki Telegram manzilingiz :</label>
                                <input type="text" class="form-control" id="phone" name="phone_number">
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary px-3">Yuborish</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- New Tab Section End -->

<!-- Shop Detail End -->

<!-- Products Start -->
<div class="container-fluid py-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Siz uchun tavsiya</span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                @foreach($random_products as $product)
                <div class="card product-item border-0">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="{{ asset('storage/' . $product->image_path[0] )}}" alt="Image">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <input type='hidden' value="{{ $product->id }}" class="product-id">
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
                        <a href="{{ route('product.detail', $product->id)}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Batafsil ko'rish</a>
                        <a href="" class="btn btn-sm text-dark p-0" data-toggle="modal" data-target="#orderModal">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i>Buyurtma berish
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const stars = document.querySelectorAll("#star-rating i");
        const ratingInput = document.getElementById("rating-input");

        stars.forEach((star, index) => {
            star.addEventListener("click", function() {
                ratingInput.value = index + 1;

                stars.forEach((s, i) => {
                    if (i <= index) {
                        s.classList.remove("far");
                        s.classList.add("fas");
                    } else {
                        s.classList.remove("fas");
                        s.classList.add("far");
                    }
                });
            });
        });
    });

    $(document).ready(function () {
        $('#orderModal form').submit(function (e) {
            e.preventDefault();

            // Modal kontekstida input elementlarini olish
            const modal = $('#orderModal');
            const name = modal.find('#name').val();
            const phone = modal.find('#phone').val();
            const telegram = modal.find('#telegram').val();
            const size = $('input[name="size"]:checked').val();
            const color = $('input[name="color"]:checked').val();
            const quantity = $('.quantity input').val();

            // Ma'lumotlarni tekshirish
            if (!name || !phone) {
                alert('Ismingiz va telefon raqamingizni to\'ldiring!');
                return;
            }

            // AJAX so'rovini jo'natish
            $.ajax({
                url: '{{ route("product.order", $product->id) }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name,
                    phone: phone,
                    telegram: telegram,
                    size: size,
                    color: color,
                    quantity: quantity,
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
<script>
    $(document).ready(function() {
        $('.btn-sm[data-target="#orderModal"]').on('click', function() {
            var productName = $(this).closest('.card').find('.text-truncate').text();
            $('#orderModal .modal-title').html('<i class="fas fa-shopping-cart mr-2"></i> ' + productName);
        });
        $('#orderModal').on('hidden.bs.modal', function() {
            $('#orderModal .modal-body p').remove();
        });
        $('.zoom-image').on('mousemove', function(e) {
            var t = $(this)
                , o = t.offset()
                , n = e.pageX - o.left
                , r = e.pageY - o.top
                , i = (n / t.width()) * 100
                , s = (r / t.height()) * 100;
            t.css({
                transform: 'scale(1.5)'
                , transformOrigin: i + '% ' + s + '%'
            });
        }).on('mouseleave', function() {
            $(this).css('transform', 'scale(1)');
        });
        $('#star-rating i').on('click', function() {
            var rating = $(this).data('index');
            $('#star-rating i').each(function() {
                if ($(this).data('index') <= rating) {
                    $(this).removeClass('far').addClass('fas');
                } else {
                    $(this).removeClass('fas').addClass('far');
                }
            });
            $('#rating-input').val(rating);
        });
    });
</script>
@endsection
