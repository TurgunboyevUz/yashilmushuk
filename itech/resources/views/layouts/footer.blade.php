@php
use App\Models\Page\About;
use App\Models\Page\HotLink;
use App\Models\Page\Image;

$abouts = About::all();
$hot_links = HotLink::all();
$logo = Image::where('key', 'loader')->first();
@endphp
<div class="container-fluid bg-secondary text-dark mt-5 pt-5">
    <div class="row px-xl-5 pt-5">
        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
            <a href="" class="text-decoration-none">
                <img src="{{ asset('storage/' . $logo->path) }}" class="img-fluid" width="50%" height="50" alt="Texno-innovator">
            </a>
            <p>{{ $abouts->where('key', 'about')->first()->value }}</p>
            <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>{{ $abouts->where('key', 'address')->first()->value }}</p>
            <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>{{ $abouts->where('key', 'email')->first()->value }}</p>
            <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>{{ $abouts->where('key', 'phone')->first()->value }}</p>
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Tezkor linklar</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-dark mb-2" href="{{ route('index') }}"><i class="fa fa-angle-right mr-2"></i>Bosh sahifa</a>
                        <a class="text-dark mb-2" href="{{ route('products') }}"><i class="fa fa-angle-right mr-2"></i>Barcha mahsulotlar</a>
                        <a class="text-dark mb-2" href="{{ route('news') }}"><i class="fa fa-angle-right mr-2"></i>Yangiliklar</a>
                        <a class="text-dark mb-2" href="{{ route('about') }}"><i class="fa fa-angle-right mr-2"></i>Korxona haqida</a>
                        <a class="text-dark" href="{{ route('contact') }}"><i class="fa fa-angle-right mr-2"></i>Aloqa</a>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Qaynoq linklar</h5>
                    <div class="d-flex flex-column justify-content-start">
                        @foreach($hot_links as $link)
                        <a class="text-dark mb-2" href="{{ $link->url }}"><i class="fa fa-angle-right mr-2"></i>{{ $link->title }}</a>
                        @endforeach
                    </div>
                </div>

                <!-- START WWW.UZ TOP-RATING -->
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Reyting</h5>
                    <script language="javascript" type="text/javascript">
                        top_js = "1.0";
                        top_r = "id=47761&r=" + escape(document.referrer) + "&pg=" + escape(window.location.href);
                        document.cookie = "smart_top=1; path=/";
                        top_r += "&c=" + (document.cookie ? "Y" : "N")

                    </script>
                    <script language="javascript1.1" type="text/javascript">
                        top_js = "1.1";
                        top_r += "&j=" + (navigator.javaEnabled() ? "Y" : "N")

                    </script>
                    <script language="javascript1.2" type="text/javascript">
                        top_js = "1.2";
                        top_r += "&wh=" + screen.width + 'x' + screen.height + "&px=" +
                            (((navigator.appName.substring(0, 3) == "Mic")) ? screen.colorDepth : screen.pixelDepth)

                    </script>
                    <script language="javascript1.3" type="text/javascript">
                        top_js = "1.3";

                    </script>
                    <script language="JavaScript" type="text/javascript">
                        top_rat = "&col=D0D0CF&t=ffffff&p=24211D";
                        top_r += "&js=" + top_js + "";
                        document.write('<a href="http://www.uz/ru/res/visitor/index?id=47761" target=_top><img src="http://cnt0.www.uz/counter/collect?' + top_r + top_rat + '" width=88 height=31 border=0 alt="Топ рейтинг www.uz"></a>')

                    </script>
                    <noscript><a href="http://www.uz/ru/res/visitor/index?id=47761" target=_top><img height=31 src="http://cnt0.www.uz/counter/collect?id=47761&pg=http%3A//uzinfocom.uz&&col=D0D0CF&amp;t=ffffff&amp;p=24211D" width=88 border=0 alt="Топ рейтинг www.uz"></a></noscript>
                </div>
                <!-- FINISH WWW.UZ TOP-RATING -->

                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Ijtimoiy tarmoqlar</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-dark mb-2" href="{{ $abouts->where('key', 'telegram')->first()->value }}"><i class="fab fa-telegram mr-2"></i>Telegram</a>
                        <a class="text-dark mb-2" href="{{ $abouts->where('key', 'instagram')->first()->value }}"><i class="fab fa-instagram mr-2"></i>Instagram</a>
                        <a class="text-dark mb-2" href="{{ $abouts->where('key', 'whatsapp')->first()->value }}"><i class="fab fa-whatsapp mr-2"></i>WhatsApp</a>
                        <a class="text-dark mb-2" href="{{ $abouts->where('key', 'youtube')->first()->value }}"><i class="fab fa-youtube mr-2"></i>YouTube</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row border-top border-light mx-xl-5 py-4">
        <div class="col-md-12 text-center">
            <p class="mb-md-0 text-dark">
                &copy; <a class="text-dark font-weight-semi-bold" href="#">texno-innovator.uz</a>. Barcha huquqlar
                himoyalangan.
                Yaratuvchi <a class="text-dark font-weight-semi-bold" href="https://t.me/Oyatillo_52">Oyatillo Anvarov</a>
            </p>
        </div>
    </div>
</div>
<!-- Back to Top -->
<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
