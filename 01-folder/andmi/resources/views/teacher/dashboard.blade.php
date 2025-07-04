@extends('layouts::employee.teacher.app')

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
                            <h3 class="widget-user-username">{{ $user->surname . ' ' . $user->name }}</h3>
                            <h5 class="widget-user-desc">{{ $department->pivot->staff_position ?? '' }}</h5>
                        </div>
                        <div class="card-body">
                            <!-- Progress Bar with Count -->
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
                                            <i class="fas fa-university"></i> Fakultet
                                        </td>
                                        <td>{{ $faculty->name ?? '' }}</td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            <i class="fas fa-graduation-cap"></i> Kafedra
                                        </td>
                                        <td>{{ $department->name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-level-up-alt"></i> Toifasi
                                        </td>
                                        <td> {{ $department->pivot->staff_position ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-passport"></i> Pasport seriyasi
                                        </td>
                                        <td>{{ $user->passport_number ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-id-card"></i> JSHSHIR raqami
                                        </td>
                                        <td>{{ $user->passport_pin ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fas fa-calendar-alt"></i> Tug'ilgan sanasi
                                        </td>
                                        <td>{{ Carbon\Carbon::parse($user->birth_date)->format('d-m-Y') }}</td>
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
                <!-- Right Side Cards -->
                <div class="col-md-8">
                    <div class="row">
                        <!-- O'qituvchiga Biriktirilgan Talabalar Card -->
                        <div class="col-md-6 mt-3">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h3 class="card-title">O'qituvchiga biriktirilgan TOP 3 talaba</h3>
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
                                        @if(count($data['top3_att']) == 0)
                                            <h5 class="text-center">O'qituvchiga biriktirilgan talabalar mavjud emas.</h5>
                                        @endif
                                        @foreach($data['top3_att'] as $item)
                                        <div class="list-group-item d-flex align-items-start mb-3">
                                            <img src="{{ $item['picture_path'] }}" alt="User Avatar" class="img-circle elevation-2" style="width: 60px; height: 60px;">
                                            <div class="ml-3">
                                                <h5 class="mb-0">{{ $item['fio'] }}</h5>
                                                <small class="text-muted">Yo'nalish: {{ $item['direction'] }}</small>
                                                <div>
                                                    <small class="text-muted">Kurs: {{ $item['level'] }}</small>
                                                </div>
                                            </div>
                                            <span class="badge bg-primary ml-auto">{{ $item['total_score'] }}</span>
                                            <!-- Ballni right-aligned qildik -->
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Kafedra Reytingi Card -->
                        <div class="col-md-6 mt-3">
                            <div class="card border-info">
                                <div class="card-header bg-warning">
                                    <h3 class="card-title">Kafedra reytingi</h3>
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
                                        @foreach($data['top3_dep'] as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="mr-2">
                                                <img src="{{ $item['picture_path'] }}" alt="User Avatar" class="img-circle elevation-2" style="width: 50px; height: 50px;">
                                            </span>
                                            <div class="flex-grow-1">
                                                <span style="font-weight: bold;">{{ $item['fio'] }}</span>
                                                <br>
                                                <small class="text-muted">Mutaxasislik: {{ $item['specialty'] }}</small>
                                                <br>
                                                <small class="text-muted">Toifa: {{ $item['staff_position'] }}</small>
                                            </div>
                                            <span class="badge bg-primary">{{ $item['total_score'] }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
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
                                        @foreach($data['top3_fac'] as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="mr-2">
                                                <img src="{{ $item['picture_path'] }}" alt="User Avatar" class="img-circle elevation-2" style="width: 50px; height: 50px;">
                                            </span>
                                            <div class="flex-grow-1">
                                                <span style="font-weight: bold;">{{ $item['fio'] }}</span>
                                                <br>
                                                <small class="text-muted">Mutaxasislik: {{ $item['specialty'] }}</small>
                                                <br>
                                                <small class="text-muted">Toifa: {{ $item['staff_position'] }}</small>
                                            </div>
                                            <span class="badge bg-primary">{{ $item['total_score'] }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Institut Reytingi Card -->
                        <div class="col-md-6 mt-3">
                            <div class="card border-info">
                                <div class="card-header bg-success">
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
                                        @foreach($data['top3_ins'] as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="mr-2">
                                                <img src="{{ $item['picture_path'] }}" alt="User Avatar" class="img-circle elevation-2" style="width: 50px; height: 50px;">
                                            </span>
                                            <div class="flex-grow-1">
                                                <span style="font-weight: bold;">{{ $item['fio'] }}</span>
                                                <br>
                                                <small class="text-muted">Fakultet: {{ $item['faculty'] }} <br>Kafedra: {{ $item['department'] }} </small>
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
