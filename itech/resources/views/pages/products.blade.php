@extends('layouts.app')

@php
use App\Models\Product\Product;
use App\Models\Product\Color;
use App\Models\Product\Size;
@endphp

@section('content')
<div class="container-fluid pt-5" data-aos="fade-up">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-12">
            <!-- Kategoriya bo'yicha filtrlash -->
            <div class="border-bottom mb-4 pb-4" data-aos="fade-up" data-aos-delay="800">
                <h5 class="font-weight-semi-bold mb-4">Kategoriya bo'yicha filtrlash</h5>
                <form method="GET" action="{{ url()->current() }}">
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3" data-aos="fade-up">
                        <input type="checkbox" class="custom-control-input" id="category-all" name="category[]">
                        <label class="custom-control-label" for="category-all">Barcha kategoriyalar</label>
                        <span class="badge border font-weight-normal">{{ $categories->sum('products_count') }}</span>
                    </div>
                    @foreach ($categories as $category)
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3" data-aos="fade-up">
                        <input type="checkbox" class="custom-control-input" id="category-{{ $category->id }}" name="category[]" value="{{ $category->id }}" {{ in_array($category->id, request('category', [])) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="category-{{ $category->id }}">{{ $category->name }}</label>
                        <span class="badge border font-weight-normal">{{ $category->products_count }}</span>
                    </div>
                    @endforeach

                    <!-- Price Filter -->
                    <div class="border-bottom mb-4 pb-4" data-aos="fade-right">
                        <h5 class="font-weight-semi-bold mb-4">Narx bo'yicha filtrlash</h5>
                        <div class="form-group">
                            <label for="min-price">Min Narx</label>
                            <input type="number" name="min_price" id="min-price" class="form-control" value="{{ request('min_price') }}">
                        </div>
                        <div class="form-group">
                            <label for="max-price">Max Narx</label>
                            <input type="number" name="max_price" id="max-price" class="form-control" value="{{ request('max_price') }}">
                        </div>
                    </div>

                    <!-- Color Filter -->
                    <div class="border-bottom mb-4 pb-4" data-aos="fade-up">
                        <h5 class="font-weight-semi-bold mb-4">Rang bo'yicha filtrlash</h5>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-all" name="color[]">
                            <label class="custom-control-label" for="color-all">Barcha ranglar</label>
                            <span class="badge border font-weight-normal">{{ Product::count() }}</span>
                        </div>
                        @foreach ($colors as $color)
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-{{ $color->id }}" name="color[]" value="{{ $color->id }}" {{ in_array($color->id, request('color', [])) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="color-{{ $color->id }}">{{ $color->name }}</label>
                            <span class="badge border font-weight-normal">{{ $color->products_count }}</span>
                        </div>
                        @endforeach
                    </div>

                    <!-- Size Filter -->
                    <div class="mb-5" data-aos="fade-up">
                        <h5 class="font-weight-semi-bold mb-4">O'lcham bo'yicha filtrlash</h5>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-all" name="size[]">
                            <label class="custom-control-label" for="size-all">Barchasi</label>
                            <span class="badge border font-weight-normal">{{ Product::count() }}</span>
                        </div>
                        @foreach ($sizes as $size)
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-{{ $size->id }}" name="size[]" value="{{ $size->id }}" {{ in_array($size->id, request('size', [])) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="size-{{ $size->id }}">{{ $size->name }}</label>
                            <span class="badge border font-weight-normal">{{ $size->products_count }}</span>
                        </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Filtrlash</button>
                </form>
            </div>
        </div>
        <!-- Shop Product Start -->
        @if($products->count() > 0)
        <div class="col-lg-9 col-md-12" data-aos="fade-up">
            <div class="row pb-3">
                <!-- Product Items Start -->
                @foreach ($products as $product)
                <div class="col-lg-4 col-md-6 col-sm-12 pb-1" data-aos="fade-up" data-aos-delay="100">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="{{ asset('storage/' . $product->image_path[0]) }}" alt="{{ $product->name }}">
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
                        <div class="card-footer d-flex justify-content-center bg-light border">
                            <a href="{{ route('product.detail', $product->id) }}" class="btn btn-sm text-dark p-0">
                                <i class="fas fa-shopping-cart text-primary mr-1"></i>Buyurtma qilish</a>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- Product Items End -->
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
        </div>
        <!-- Shop Product End -->
        @else
        <div class="d-flex justify-content-center align-items-center" style="height: 70vh; text-align: center;">
            <div>
                <i class="fas fa-box-open fa-3x mb-3 text-primary"></i>
                <h5 class="text-muted">Bu kategoriyada mahsulotlar mavjud emas</h5>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
