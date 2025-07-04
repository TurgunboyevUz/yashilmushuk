@php
    use App\Models\Page\Image;

    $loader = Image::where('key', 'loader')->first();
    $logo = Image::where('key', 'logo')->first();
@endphp

<div id="loader" class="loader">
    <img src="{{ asset('storage/' . $loader->path) }}" alt="Logo" class="logo">
</div>

<div class="row align-items-center py-3 px-xl-5" data-aos="fade-up">
    <div class="col-lg-3 d-none d-lg-block">
        <a href="{{ route('index') }}" class="text-decoration-none">
            <img src="{{ asset('storage/' . $logo->path) }}" alt="Logo" class="img-fluid">
        </a>
    </div>
    <div class="col-lg-6 col-6 text-left">
        <form action="{{ route('search') }}" method="GET">
            <div class="input-group">
                <input type="text" class="form-control" name="q" placeholder="Mahsulotlarni izlash" value="" required>
                <div class="input-group-append">
                    <button type="submit" class="input-group-text bg-transparent text-primary">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-lg-3 col-6 text-right">
        <a href="" class="btn border">
            <i class="fas fa-shopping-cart text-primary"></i>
            <span class="badge">{{ session('order', 0) }}</span>
        </a>
    </div>
</div>