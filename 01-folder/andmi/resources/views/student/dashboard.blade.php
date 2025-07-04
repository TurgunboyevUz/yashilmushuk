@extends('layouts::student.app')

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
                            <h3 class="widget-user-username">{{ $user->surname }} {{ $user->name }}</h3>
                            <h5 class="widget-user-desc">Talaba</h5>
                        </div>
                        <div class="card-body">
                            <hr>
                            <!-- Shaxsiy Ma'lumotlar -->
                            <h4 class="mt-4">Shaxsiy ma'lumotlar</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <i class="fas fa-user"></i> Ism
                                        </td>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-user-tag"></i> Familiya
                                        </td>
                                        <td>{{ $user->surname }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-flag"></i> Millati
                                        </td>
                                        <td>{{ $user->nation->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-graduation-cap"></i> Guruh
                                        </td>
                                        <td>{{ $user->student->group->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-level-up-alt"></i> Bosqich
                                        </td>
                                        <td>{{ $user->student->level }} kurs</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-calendar-alt"></i> Tug'ilgan sanasi
                                        </td>
                                        <td>{{ Carbon\Carbon::parse($user->birth_date)->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-passport"></i> Pasport seriyasi
                                        </td>
                                        <td>{{ $user->passport_number }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-university"></i> Fakultet
                                        </td>
                                        <td>{{ $user->student->faculty->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-home"></i> Doimiy yashash manzili
                                        </td>
                                        <td>{{ $user->student->address }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-id-card"></i> JSHSHIR raqami
                                        </td>
                                        <td>{{ $user->passport_pin }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-phone"></i> Telefon raqami
                                        </td>
                                        <td>{{ $user->phone}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Right Side Cards -->
                <div class="col-md-8">
                    <div class="row">
                        <!-- Guruh Tarkibi Card -->
                        <div class="col-md-6 mt-3">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h3 class="card-title">Guruh tarkibi</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="refresh">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body scrollable-card-body">
                                    <div class="list-group">
                                        @foreach($groupmate_scores as $item)
                                            <div class="list-group-item d-flex align-items-start mb-3">
                                            <img src="{{ $item['picture_path'] }}" alt="User Avatar" class="img-circle elevation-2" style="width: 60px; height: 60px;">
                                            <div class="ml-3 flex-grow-1">
                                                <h5 class="mb-0">{{ $item['fio'] }}</h5>
                                                <small class="text-muted">Guruh: {{ $item['group'] }}</small>
                                                <span class="badge bg-primary float-right">{{ $item['total_score'] }}</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fakultet Reytingi Card -->
                        <div class="col-md-6 mt-3">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white">
                                    <h3 class="card-title">Fakultet reytingi</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="refresh">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body scrollable-card-body">
                                    <ul class="list-group">
                                        @foreach ( $facultymate_top as $item )
                                        <li class="list-group-item d-flex align-items-center">
                                            <span class="mr-2">
                                                <img src="{{ $item['picture_path'] }}" alt="User Avatar" class="img-circle elevation-2" style="width: 60px; height: 60px;">
                                            </span>
                                            <div class="ml-3">
                                                <h5 class="mb-0">{{ $item['fio'] }}</h5>
                                                <p class="mb-0 text-muted">Yo'nalish: {{ $item['direction'] }}
                                                </p>
                                                <p class="mb-0 text-muted">Kurs: {{ $item['level'] }}-kurs</p>
                                            </div>
                                            <span class="badge bg-primary ml-auto">{{ $item['total_score'] }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Guruh Reytingi Card -->
                        <div class="col-md-6 mt-3">
                            <div class="card border-success">
                                <div class="card-header bg-success">
                                    <h3 class="card-title">Guruh reytingi</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="refresh">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body scrollable-card-body">
                                    <ul class="list-group">
                                        @foreach($groupmate_top as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="mr-2">
                                                <img src="{{ $item['picture_path'] }}" alt="User Avatar" class="img-circle elevation-2" style="width: 50px; height: 50px;">
                                            </span>
                                            <div class="flex-grow-1">
                                                <span style="font-weight: bold;">{{ $item['fio'] }}</span>
                                                <br>
                                                <small class="text-muted">Guruh: {{ $item['group'] }}</small>
                                            </div>
                                            <span class="badge bg-primary">{{ $item['total_score'] }}</span>
                                        </li>
                                        @endforeach
                                        <!-- User List -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Institut Reytingi Card -->
                        <div class="col-md-6 mt-3">
                            <div class="card border-info">
                                <div class="card-header bg-warning">
                                    <h3 class="card-title">Institut reytingi</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="refresh">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body scrollable-card-body">
                                    <ul class="list-group">
                                        @foreach($institute_top as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="mr-2">
                                                <img src="{{ $item['picture_path'] }}" alt="User Avatar" class="img-circle elevation-2" style="width: 50px; height: 50px;">
                                            </span>
                                            <div class="flex-grow-1">
                                                <span style="font-weight: bold;">{{ $item['fio'] }}</span>
                                                <br>
                                                <small class="text-muted">Fakultet: {{ $item['faculty'] }} <br>
                                                    Yo'nalish: {{ $item['direction']}} </small>
                                            </div>
                                            <span class="badge bg-primary">{{ $item['total_score'] }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
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
