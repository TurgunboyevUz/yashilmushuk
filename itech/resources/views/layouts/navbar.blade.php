@php
    use App\Models\Page\Image;
    use App\Models\Product\Category;

    $images = Image::where('key', 'slider')->get();
    $categories = Category::with('children')->whereNull('parent_id')->get();
@endphp
<div class="container-fluid">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                <h6 class="m-0 text-white">Kategoriyalar</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                <div class="navbar-nav w-100 overflow-hidden" style="height: auto;">
                    <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                        <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                            @foreach ($categories as $category)
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link" data-toggle="dropdown">
                                        {{ $category->name }} <i class="fa fa-angle-down float-right mt-1"></i>
                                    </a>
                                    <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
                                        @foreach ($category->children as $child)
                                            <a href="{{ route('products', ['category[]' => $child->id]) }}" class="dropdown-item">
                                                {{ $child->name }}
                                            </a>
                                            <!-- If the child category has its own children, display them in a nested dropdown -->
                                            @if ($child->children->isNotEmpty())
                                                <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
                                                    @foreach ($child->children as $grandchild)
                                                        <a href="{{ route('products', ['category[]' => $grandchild->id]) }}" class="dropdown-item">
                                                            {{ $grandchild->name }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </nav>                        
                </div>
            </nav>
        </div>
        <div class="col-lg-9" data-aos="fade-left">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <h3 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">TEXNO</span>INNOVATOR</h3>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="{{ route('index') }}" class="nav-item nav-link" data-aos="zoom-in">Bosh sahifa</a>
                        <a href="{{ route('products') }}" class="nav-item nav-link" data-aos="zoom-in">Mahsulotlar</a>
                        <a href="{{ route('news') }}" class="nav-item nav-link" data-aos="zoom-in">Yangiliklar</a>
                        <a href="{{ route('about') }}" class="nav-item nav-link">Biz haqimizda</a>
                        <a href="{{ route('contact') }}" class="nav-item nav-link" data-aos="zoom-in">Aloqa</a>
                    </div>
                    <div class="navbar-nav ml-auto py-0">
                        <a href="login.html"><button class="btn btn-link nav-item nav-link text-decoration-none">
                                <i class="fa fa-sign-in-alt"></i> Kirish
                            </button></a>
                    </div>
                </div>
            </nav>

            @if(request()->route()->getName() == 'index')
            <div id="header-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @php $i = 1; @endphp
                    @foreach ($images as $image)

                    <div class="carousel-item @if($i++ == 1) active @endif" style="height: 510px;">
                        <img class="img-fluid" src="{{ asset('storage/' . $image->path) }}" alt="Slayder">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            @if(isset($image->carousel))
                            <div class="p-3" style="max-width: 700px;">
                                @if($image->carousel->secondary_text)
                                <h4 class="text-light text-uppercase font-weight-medium mb-3">{{ $image->carousel->secondary_text }}</h4>
                                @endif
                                
                                <h3 class="display-4 text-white font-weight-semi-bold mb-4">{{ $image->carousel->primary_text }}</h3>

                                @if($image->carousel->button)
                                    <a href="{{ $image->carousel->button_url }}" class="btn btn-light py-2 px-3">{{ $image->carousel->button_text }}</a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>    
                    @endforeach
                </div>

                <!-- TEGMA -->
                <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                    <div class="btn btn-dark" style="width: 45px; height: 45px;">
                        <span class="carousel-control-prev-icon mb-n2"></span>
                    </div>
                </a>
                <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                    <div class="btn btn-dark" style="width: 45px; height: 45px;">
                        <span class="carousel-control-next-icon mb-n2"></span>
                    </div>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
