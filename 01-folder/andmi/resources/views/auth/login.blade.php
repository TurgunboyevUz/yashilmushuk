<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BMI Platforma | Tizimga kirish</title>

    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <style>
        :root {
            --student-color: #17a2b8;
            --student-hover: #138496;
            --teacher-color: #28a745;
            --teacher-hover: #218838;
        }

        .login-button {
            display: inline-block;
            font-size: 1.125rem;
            margin: 0.625rem 0.125rem;
            border-radius: 1.5625rem;
            transition: all 0.3s ease;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
            border: none;
            color: #fff;
            padding: 0.9375rem 1.875rem;
            text-align: center;
            text-decoration: none;
            width: 100%;
        }

        .btn-student {
            background-color: var(--student-color);
        }

        .btn-student:hover,
        .btn-student:focus {
            background-color: var(--student-hover);
            box-shadow: 0 0.375rem 0.75rem rgba(0, 0, 0, 0.2);
            transform: translateY(-0.125rem);
            color: #fff;
        }

        .btn-teacher {
            background-color: var(--teacher-color);
        }

        .btn-teacher:hover,
        .btn-teacher:focus {
            background-color: var(--teacher-hover);
            box-shadow: 0 0.375rem 0.75rem rgba(0, 0, 0, 0.2);
            transform: translateY(-0.125rem);
            color: #fff;
        }

        .login-header {
            text-align: center;
            position: relative;
            padding: 1rem;
        }

        .login-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin: 1rem 0;
        }

        .menu-button {
            position: absolute;
            top: 0.625rem;
            right: 0.625rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            transition: opacity 0.2s;
        }

        .menu-button:hover {
            opacity: 0.8;
        }

        .menu-button:focus {
            outline: none;
        }

        .logo-container img {
            max-width: 50%;
            height: auto;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .logo-container img {
                max-width: 70%;
            }
        }

    </style>
</head>
<body class="hold-transition login-page">
    @include('sweetalert::alert')
    <div class="container d-flex align-items-center min-vh-100">
        <div class="row w-100 justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-outline card-primary">
                    <div class="card-header login-header">
                        <div class="logo-container">
                            <a href="/" aria-label="Bosh sahifa">
                                <img src="{{ asset('img/logo.png') }}" alt="BMI Platform logotipi" class="img-fluid">
                            </a>
                        </div>
                        <h1 class="login-title">BMI platformasi</h1>
                        <button class="menu-button" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Qo'shimcha menyuni ochish">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="https://student.andmiedu.uz/stat">
                                <i class="fas fa-chart-bar mr-2"></i>Statistika dashboardi
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 class="login-title text-center">Hisobga kirish</h2>
                        <div class="d-grid gap-3">
                            <a href="{{ route('student.login') }}" class="login-button btn-student">
                                <i class="fas fa-user-graduate mr-2"></i>Talaba HEMIS orqali kirish
                            </a>
                            <a href="{{ route('employee.login') }}" class="login-button btn-teacher">
                                <i class="fas fa-chalkboard-teacher mr-2"></i>Xodim HEMIS orqali kirish
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>
