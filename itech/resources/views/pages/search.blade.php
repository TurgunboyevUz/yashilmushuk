@extends('layouts.app')

@php
    use App\Models\Product\Color;
@endphp

@section('content')
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        @if($products->isEmpty())
        <div class="col-12 pb-1" id="noResults">
            <div class="text-center py-5">
                <i class="fas fa-search fa-4x text-primary mb-4"></i>
                <h3 class="font-weight-semi-bold mb-3">Hech qanday natija topilmadi</h3>
                <p class="mb-4">Afsuski, "{{ $query }}" so'zi bo'yicha hech qanday mahsulot topilmadi.</p>
                <p>Qidiruv bo'yicha tavsiyalar:</p>
                <ul class="list-unstyled">
                    <li>- So'zlarni to'g'ri yozganingizni tekshiring</li>
                    <li>- Boshqa kalit so'zlardan foydalanib ko'ring</li>
                    <li>- Umumiyroq so'zlar bilan qidirib ko'ring</li>
                </ul>
                <a href="{{ route('products') }}" class="btn btn-primary py-2 px-4 mt-3">
                    <i class="fas fa-angle-double-right mr-2"></i>Barcha mahsulotlarni ko'rish
                </a>
            </div>
        </div>
        @else
        <div class="col-12 pb-1" id="resultsFound">
            <h5 class="mb-4">"{{ $query }}" so'zi bo'yicha <span class="text-primary">{{ $products->count() }} ta</span> natija topildi</h5>

            <div class="row">
                @foreach($products as $product)
                <div class="col-lg-4 col-md-6 col-sm-12 pb-1" data-aos="fade-up">
                    <div class="card product-item border-0 mb-4">
                        <div
                            class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="{{ asset('storage/'.$product->image_path[0]) }}" alt="">
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
                                    $price = number_format($price->price, 0, '.', ',');
                                    $data .= $price . ' so\'m | ';
                                }

                                $data = substr($data, 0, -3);
                                @endphp
                                {{ $data }}
                                @endif
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-center bg-light border">
                            <a href="{{ route('product.detail', $product->id) }}" class="btn btn-sm text-dark p-0">
                                <i class="fas fa-shopping-cart text-primary mr-1"></i>Buyurtma qilish
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

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
            </div>
        </div>
        @endif
    </div>
</div>
@endsection