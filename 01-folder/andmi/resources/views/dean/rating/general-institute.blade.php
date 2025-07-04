@extends('layouts::employee.dean.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Talabalarni institut bo'yicha umumiy reytingi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Talabalarni institut bo'yicha umumiy reytingi</li>
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
                            <h3 class="card-title">Institutdagi Talabalar Reytingi</h3>
                            <div class="ml-auto d-flex">
                                <button id="excelDownload" class="btn btn-success" onclick="window.location = '{{ route('excel.general-institute') }}';">
                                    <i class="fas fa-file-excel"></i> Excel yuklash
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                                <table id="studentsInstituteRatingTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%;">#</th>
                                            <th>Talaba FIO</th>
                                            <th>Kursi</th>
                                            <th>Kimga biriktirilgan</th>
                                            <th>Fakulteti</th>
                                            <th>Yo'nalishi</th>
                                            <th>Umumiy ball</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach($students as $student)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $student['fio'] }}</td>
                                            <td>{{ $student['level'] }}-kurs</td>
                                            <td>{{ $student['teacher'] }}</td>
                                            <td>{{ $student['faculty'] }}</td>
                                            <td>{{ $student['direction'] }}</td>
                                            <td>{{ $student['total_score'] }}</td>
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
