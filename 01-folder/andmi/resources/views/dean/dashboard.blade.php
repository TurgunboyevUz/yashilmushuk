@extends('layouts::employee.dean.app')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bosh sahifa</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Profil Card -->
                <div class="col-md-4">
                    <div class="card card-widget widget-user">
                        <div class="widget-user-header bg-info">
                            <div class="widget-user-image">
                                <img class="img-circle elevation-2" src="{{ $user->picture_path() }}" alt="User Avatar">
                            </div>
                            <h3 class="widget-user-username">Dekan</h3>
                            <h5 class="widget-user-desc">{{ $department->name ?? ''}} dekani</h5>
                        </div>
                        <div class="card-body">
                            <br>
                            <hr>
                            <!-- Shaxsiy Ma'lumotlar -->
                            <h4 class="mt-4">Shaxsiy Ma'lumotlar</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <i class="fas fa-user"></i> Ism
                                        </td>
                                        <td>{{ $user->name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-user-tag"></i> Familiya
                                        </td>
                                        <td>{{ $user->surname ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-flag"></i> Millati
                                        </td>
                                        <td>{{ $user->nation->name ?? "O'zbek" }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-graduation-cap"></i> Lavozimi
                                        </td>
                                        <td>{{ $department->pivot->staff_position ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-calendar-alt"></i> Tug'ilgan yili
                                        </td>
                                        <td>{{ Carbon\Carbon::parse($user->birth_date)->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-passport"></i> Pasport seriyasi
                                        </td>
                                        <td>{{ $user->passport_number ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-university"></i> Fakultet
                                        </td>
                                        <td>{{ $department->name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-id-card"></i> JSHSHIR raqami
                                        </td>
                                        <td>{{ $user->passport_pin ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-phone"></i> Telefon raqami
                                        </td>
                                        <td>{{ $user->phone ?? '' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Statistika Cardlari -->
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-widget widget-user-2">
                                <div class="widget-user-header bg-gradient-secondary">
                                    <h3 class="widget-user-username">Umumiy talabalar</h3>
                                    <h5 class="widget-user-desc">Talabalar soni</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header">{{ $counts['students']['male'] + $counts['students']['female'] }}</h5>
                                                <span class="description-text">talaba</span>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-4">
                                            <div class="description-block">
                                                <h5 class="description-header">{{ $counts['students']['male'] }}</h5>
                                                <span class="description-text">erkak talaba</span>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header">{{ $counts['students']['female'] }}</h5>
                                                <span class="description-text">ayol talaba</span>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-widget widget-user-2">
                                <div class="widget-user-header bg-gradient-info">
                                    <h3 class="widget-user-username">Nomdor stipendiyaga tushgan arizalar</h3>
                                    <h5 class="widget-user-desc">Arizalar soni</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header">{{ $counts['file']['male'] + $counts['file']['female'] }}</h5>
                                                <span class="description-text">ariza</span>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-4">
                                            <div class="description-block">
                                                <h5 class="description-header">{{ $counts['file']['male'] }}</h5>
                                                <span class="description-text">erkak talaba arizasi</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header">{{ $counts['file']['female'] }}</h5>
                                                <span class="description-text">ayol talaba arizasi</span>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
