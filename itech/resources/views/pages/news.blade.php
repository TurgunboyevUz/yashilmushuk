@extends('layouts.app')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5" data-aos="fade-down">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Yangiliklar</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="">Bosh sahifa</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Yangiliklar</p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Video Yangiliklar Start -->
<div class="container-fluid pt-5" data-aos="fade-up">
    <div class="row px-xl-5">
        <div class="col-12">
            <h2 class="font-weight-semi-bold mb-4">Video Yangiliklar</h2>
            <div class="row">
                @if ($youtube_urls->isEmpty())
                <div class="col-12 text-center">
                    <p class="text-muted"><i class="fas fa-info-circle"></i> Hech narsa yo'q</p>
                </div>
                @else
                @foreach ($youtube_urls as $url)
                <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe width="560" height="315" src="{{ $url->url }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Video Yangiliklar End -->

<!-- Blog Start -->
<div class="container-fluid pt-5" data-aos="fade-up">
    <div class="row px-xl-5">
        <!-- Blog Posts Start -->
        <div class="col-lg-9 col-md-12">
            <div class="row pb-3">
                @if ($magazines->isEmpty())
                <div class="col-12 text-center">
                    <p class="text-muted"><i class="fas fa-info-circle"></i> Hech narsa yo'q</p>
                </div>
                @else
                <!-- Blog Post Item Start -->
                @foreach($magazines as $magazine)
                <div class="col-lg-4 col-md-6 col-sm-12 pb-1" data-aos="fade-up" data-aos-delay="100">
                    <div class="card blog-item border-0 mb-4">
                        <div class="card-header blog-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="{{ asset('storage/' . $magazine->image_path) }}" alt="Blog Post Image">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">{{ $magazine->title }}</h6>
                            <p class="mb-3">{{ $magazine->description }}</p>
                            <div class="post-meta">
                                <small class="text-muted"><i class="fas fa-eye"></i> {{ $magazine->views }}</small>
                                <small class="text-muted"><i class="fas fa-calendar"></i> {{ $magazine->created_at->format('d-m-Y') }}</small>
                                <small class="text-muted"><i class="fas fa-folder"></i> {{ $magazine->category->name }}</small>
                            </div>
                            <a href="{{ $magazine->url }}" class="btn-detail mt-2"><i class="fab fa-telegram-plane"></i> Batafsil o'qish</a>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                <!-- Pagination Start -->
                @if($magazines->hasPages())
                <div class="col-12 pb-1">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            @if ($magazines->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo; Oldingi</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $magazines->previousPageUrl() }}" aria-label="Oldingi">
                                    <span aria-hidden="true">&laquo; Oldingi</span>
                                </a>
                            </li>
                            @endif

                            @foreach ($magazines->links()->elements[0] as $page => $url)
                            <li class="page-item {{ $magazines->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                            @endforeach

                            @if ($magazines->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $magazines->nextPageUrl() }}" aria-label="Keyingi">
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
                @endif
                <!-- Pagination End -->
            </div>
        </div>
        <!-- Blog Posts End -->

        <!-- Sidebar Start -->
        <div class="col-lg-3 col-md-12">
            <!-- Recent Posts Start -->
            <div class="mb-5" data-aos="fade-up">
                <h5 class="font-weight-semi-bold mb-4">So'nggi yangiliklar</h5>
                <div class="d-flex flex-column justify-content-start">
                    @foreach ($magazines->sortByDesc('created_at')->take(3) as $magazine)
                    <a class="text-dark mb-2" href="?magazine={{ $magazine->id }}">
                        <i class="fa fa-angle-right mr-2"></i>{{ $magazine->title }}
                    </a>
                    @endforeach
                </div>
            </div>
            <!-- Recent Posts End -->

            <!-- Categories Start -->
            <div class="mb-5" data-aos="fade-up">
                <h5 class="font-weight-semi-bold mb-4">Kategoriyalar</h5>
                <div class="d-flex flex-column justify-content-start">
                    @foreach ($magazine_categories as $category)
                    <a class="text-dark mb-2" href="{{ route('news.category', $category->id) }}">
                        <i class="fa fa-angle-right mr-2"></i>{{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>
            <!-- Categories End -->
        </div>
        <!-- Sidebar End -->
    </div>
</div>
<!-- Blog End -->
@endsection 