@extends('layouts.app')

@section('content')
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Savollaringiz bo'lsa biz bilan bog'laning</span></h2>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success text-center" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="row px-xl-5">
        <div class="col-lg-7 mb-5">
            <div class="contact-form">
                <div id="success"></div>
                <form name="sentMessage" id="contactForm" method="POST" action="{{ route('contact') }}">
                    @csrf
                    <div class="control-group">
                        <input name="name" type="text" class="form-control" id="name" placeholder="Ismingiz" required="required"/>
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input name="phone_number" type="phone" class="form-control" id="phone" placeholder="Telefon raqamingiz" required="required"/>
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input name="title" type="text" class="form-control" id="subject" placeholder="Mavzu" required="required"/>
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <textarea name="message" class="form-control" rows="6" id="message" placeholder="Xabaringiz" required="required"></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                    <div>
                        <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">Xabarni yuborish</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-5 mb-5">
            <h5 class="font-weight-semi-bold mb-3">Biz bilan bog'laning</h5>
            <p>Savollaringiz yoki takliflaringiz bo'lsa, quyidagi ma'lumotlar orqali biz bilan bog'lanishingiz mumkin.</p>
            <div class="d-flex flex-column mb-3">
                <h5 class="font-weight-semi-bold mb-3">Ofis manzili</h5>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>{{ $address }}</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>{{ $email }}</p>
                <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>{{ $phone }}</p>
            </div>
            <div class="d-flex flex-column">
                <h5 class="font-weight-semi-bold mb-3">Ijtimoiy tarmoqlar</h5>
                <a class="text-dark mb-2" href="{{ $telegram }}"><i class="fab fa-telegram mr-2"></i>Telegram</a>
                <a class="text-dark mb-2" href="{{ $instagram }}"><i class="fab fa-instagram mr-2"></i>Instagram</a>
                <a class="text-dark mb-2" href="{{ $whatsapp }}"><i class="fab fa-whatsapp mr-2"></i>WhatsApp</a>
                <a class="text-dark mb-2" href="{{ $youtube }}"><i class="fab fa-youtube mr-2"></i>YouTube</a>
            </div>
        </div>
    </div>
</div>
@endsection
