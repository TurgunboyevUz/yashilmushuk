<!DOCTYPE html>
<html lang="uz">
@include('layouts.head')
<body>
    <!-- Topbar -->
    @include('layouts.topbar')

    <!-- 404 Content -->
    <div class="container-fluid pt-5" data-aos="fade-up">
        <div class="text-center pb-5">
            <h1 class="display-1 text-primary">404</h1>
            <h1 class="mb-4">Sahifa topilmadi</h1>
            <p class="mb-4">Kechirasiz, siz qidirayotgan sahifa topilmadi yoki o'chirilgan.</p>
            <a class="btn btn-primary py-3 px-5" href="{{ route('index') }}">
                <i class="fas fa-home mr-2"></i>Bosh sahifaga qaytish
            </a>
        </div>
    </div>

    @include('layouts.footer')
    @include('layouts.scripts')
</body>
</html>