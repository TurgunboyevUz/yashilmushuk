<!DOCTYPE html>
<html lang="uz">

@include('layouts::student.head')

<body class="hold-transition sidebar-mini layout-fixed">
    @include('sweetalert::alert')
    <div class="wrapper">
        <!-- Loader -->
        <div class="loader-wrapper">
            <div class="loader"></div>
        </div>

        @include('layouts::student.navbar')
        @include('layouts::student.sidebar')

        @yield('content')

        @include('layouts::student.footer')

        @include('layouts::student.scripts')

    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rad etilish sababi</h5>
                    <button id="reject-modal-close" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="reject-reason"></p>
                </div>
                <div class="modal-footer">
                    <button id="reject-modal-close" type="button" class="btn btn-secondary btn-close" data-bs-dismiss="modal">Yopish</button>
                </div>
            </div>
        </div>
    </div>

    @yield('scripts')

</body>

</html>
