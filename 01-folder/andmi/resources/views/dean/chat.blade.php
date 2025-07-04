@extends('layouts::teacher.app')

@section('content')
<div class="content-wrapper" style="padding: 0;">
    <section class="content-header">
        <h1>Talabalar bilan Chat</h1>
    </section>

    <section class="content" style="padding: 0;">
        <div class="container-fluid my-6">
            <div class="card mt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Chat</h3>
                    <div class="ml-auto">
                        <select id="studentSelect" class="form-control" required>
                            <option value="" disabled selected>Talabani tanlang</option>
                            <option value="1" data-course="2-kurs" data-direction="Algebra va matematik analiz">Abdullayev Muhammad (2-kurs, Algebra va matematik analiz)</option>
                            <option value="2" data-course="3-kurs" data-direction="Fizika va astronomiya">Qodirova Xadicha (3-kurs, Fizika va astronomiya)</option>
                            <option value="3" data-course="4-kurs" data-direction="Kompyuter fanlari">Anvarov Oyatillo (4-kurs, Kompyuter fanlari)</option>
                            <option value="4" data-course="1-kurs" data-direction="Botanika va o'simlik fiziologiyasi">Saidov Muhammad (1-kurs, Botanika va o'simlik fiziologiyasi)</option>
                            <option value="5" data-course="3-kurs" data-direction="Anorganik kimyo">Nazarov Diyorbek (3-kurs, Anorganik kimyo)</option>
                        </select>
                    </div>
                </div>
                <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                    <!-- Chat Message Area -->
                    <div id="chatMessages" class="p-3" style="height: 400px; overflow-y: auto;">
                        <!-- Professor va talaba xabarlari -->
                        <div class="message my-2 d-flex align-items-start flex-row-reverse">
                            <img src="dist/img/user3-128x128.jpg" alt="Professor Profil" class="rounded-circle ml-2" style="width: 40px; height: 40px;">
                            <div>
                                <strong>Professor:</strong>
                                <p>Salom Hurmatli talaba! Bugungi mavzu sizga tushunarli bo'ldimi mavzuga oid qandaydir savollaringiz bormi?</p>
                            </div>
                        </div>
                        <div class="message my-2 d-flex align-items-start">
                            <img src="img/image.jpg" alt="Talaba Profil" class="rounded-circle mr-2" style="width: 40px; height: 40px;">
                            <div>
                                <strong>Talaba:</strong>
                                <p>Assalomu alaykum, Professor. Ha menda bugungi uyga vazifa borasida bir nechta savollarim bor edi. mumkinmi?!</p>
                            </div>
                        </div>
                        <!-- Yangi xabarlar shu joyga qo'shiladi -->
                    </div>
                </div>

                <!-- Xabar yozish maydoni va jo'natish tugmasi -->
                <div class="card-footer">
                    <form id="chatForm" class="d-flex">
                        <input type="text" id="messageInput" class="form-control" placeholder="Xabar yozing..." required>
                        <button type="submit" class="btn btn-primary ml-2">
                            <i class="fas fa-paper-plane"></i> Jo'natish
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection