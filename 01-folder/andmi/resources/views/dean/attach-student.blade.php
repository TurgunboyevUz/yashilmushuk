<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BMI Platforma | Talabani biriktirish</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- Toastify styles -->
    <link rel="stylesheet" href="{{ asset('dist/css/toastify.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Dashboard style -->
    <link rel="stylesheet" href="{{ asset('dist/css/dashboard.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <style>
        .fade-out {
            opacity: 0;
            transition: opacity 0.5s ease-out;
        }

        .fade-in {
            animation: fadeIn 1s ease-in-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes highlight {
            0% {
                background-color: #ffffff;
            }

            50% {
                background-color: #007bff;
            }

            100% {
                background-color: #ffffff;
            }
        }

        .selected-row {
            animation: highlight 1.5s ease-in-out;
            background-color: #007bff;
            color: white;
        }

        .list-group-item {
            cursor: pointer;
        }

        .list-group-item.active {
            background-color: #007bff;
            color: white;
        }

        #professorTable th:nth-child(1),
        #studentTable th:nth-child(1),
        #professorTable td:nth-child(1),
        #studentTable td:nth-child(1) {
            width: 50px;
        }

        #professorTable tbody tr:hover,
        #studentTable tbody tr:hover {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        body.dark #professorTable tbody tr:hover,
        body.dark #studentTable tbody tr:hover {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        body.dark .selected-row {
            background-color: #007bff;
            color: white;
        }

        .table-responsive::-webkit-scrollbar {
            display: none;
        }

        .table-container {
            border-top: 2px solid #ccc;
            padding-top: 20px;
        }

        .table-container:first-child {
            border-top: none;
        }

        @media (max-width: 768px) {
            .table-responsive {
                margin: 0 auto;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-responsive table {
                width: 100%;
            }

            .table-responsive th,
            .table-responsive td {
                padding: 8px;
                font-size: 12px;
            }

            .table-responsive thead {
                background-color: #f4f4f4;
            }

            .table-responsive th {
                text-align: center;
            }
        }

        @media (max-width: 480px) {

            .table-responsive td,
            .table-responsive th {
                font-size: 10px;
            }

            .table-responsive {
                padding: 0 10px;
            }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Loader -->
        <div class="loader-wrapper">
            <div class="loader"></div>
        </div>
        <!-- Navbar -->
        @include('layouts::employee.dean.navbar')
        <!-- /.navbar -->
        <!-- Main Content -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Talabalarni biriktirish</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Sidebar Container -->
            @include('layouts::employee.dean.sidebar')
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <h4>Biriktirilgan talabalar jadvali</h4>
                            <table class="table table-responsive table-bordered" id="assignedTable">
                                <thead>
                                    <tr>
                                        <th>Professorlar ro'yxati</th>
                                        <th>Talabalar ro'yxati</th>
                                    </tr>
                                </thead>
                                <tbody id="assignedTableBody"></tbody>
                            </table>
                            <center>
                                <button class="btn btn-success btn-sm mb-2" id="saveChanges">
                                    <i class="fas fa-check mr-2"></i>O'zgarishlarni saqlash
                                </button>
                            </center>
                        </div>

                        <div class="col-md-6 table-container">
                            <h4>Professorlar</h4>
                            <table id="professorTable" class="table table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Prof F.I.O</th>
                                        <th>Kafedra</th>
                                        <th>Mutaxasisligi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach($teachers as $teacher)
                                    <tr data-id="{{ $teacher->employee->id }}">
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $teacher->employee->user->short_fio() }}</td>
                                        <td>{{ $teacher->department->name }}</td>
                                        <td>{{ (!empty($teacher->employee->specialty->name)) ? $teacher->employee->specialty->name : 'Mavjud emas' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6 table-container">
                            <h4>Talabalar</h4>
                            <table id="studentTable" class="table table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>F.I.O</th>
                                        <th>Yo'nalishi</th>
                                        <th>Kursi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach($students as $student)
                                    <tr data-id="{{ $student->id }}">
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $student->user->short_fio() }}</td>
                                        <td>{{ $student->direction->name }}</td>
                                        <td>{{ $student->level }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        @include('layouts::employee.footer')
    </div>
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Loader JS -->
    <script src="{{ asset('dist/js/loader.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- Dashboard JS -->
    <script src="{{ asset('dist/js/dashboard.js') }}"></script>
    <!-- Datatable JS -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script>const uzLocaleFile = "{{ asset('dist/js/uzbek.json') }}"; </script>
    <script src="{{ asset('js/employee/dean.js') }}"></script>
    <script src="{{ asset('js/employee/main.js')}}"></script>
</body>
</html>
