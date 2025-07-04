<!DOCTYPE html>
<html lang="uz">

@include('layouts.head')

<body>
    @include('layouts.topbar')
    @include('layouts.navbar')

    @yield('content')
    
    <!-- Order Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">
                        <i class="fas fa-shopping-cart mr-2"></i> Buyurtma berish
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name"><i class="fas fa-user mr-2"></i> Ismingiz va Familyangiz</label>
                            <input type="text" class="form-control" value="" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="phone"><i class="fas fa-phone mr-2"></i> Telefon raqamingiz</label>
                            <input type="tel" class="form-control" value="" id="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="telegram"><i class="fab fa-telegram mr-2"></i> Telegram manzilingiz (Masalan:
                                @inforte)</label>
                            <input type="text" class="form-control" id="telegram">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane mr-2"></i> Yuborish
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Order Modal End -->
    @include('layouts.footer')
    @include('layouts.scripts')

    @yield('scripts')
</body>

</html>
