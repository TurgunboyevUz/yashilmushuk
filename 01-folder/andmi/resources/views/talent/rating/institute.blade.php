@extends('layouts::employee.talent.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Institut reytingi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Institut reytingi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Institut reytingi</h3>
                            <div class="ml-auto d-flex">
                                <button id="excelDownload" class="btn btn-success" onclick="window.location = '{{ route('excel.institute', ['role' => 'talent']) }}';">
                                    <i class="fas fa-file-excel"></i> Excel yuklash
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                                <table id="instituteRatingTable" class="table table-bordered table-responsive table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%;">#</th>
                                            <th>FISH</th>
                                            <th>Lavozimi</th>
                                            <th>Fakulteti</th>
                                            <th>Kafedrasi</th>
                                            <th>Biriktirilgan o’quvchilar soni</th>
                                            <th>Umumiy balli</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach ($employees as $employee)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $employee['fio'] }}</td>
                                                <td>{{ $employee['staff_position'] }}</td>
                                                <td>{{ $employee['faculty'] }}</td>
                                                <td>{{ $employee['department'] }}</td>
                                                <td>{{ $employee['student_count'] }}</td>
                                                <td>{{ $employee['total_score'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
