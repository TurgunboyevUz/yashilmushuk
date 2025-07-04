@extends('layouts::employee.dean.app')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Biriktilgan talabalar ro'yxati</h3>
                            <div class="ml-auto d-flex">
                                <button id="excelDownload" class="btn btn-success" onclick="window.location = '{{ route('excel.attached-students-list') }}';">
                                    <i class="fas fa-file-excel"></i> Excel yuklash
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                                <table class="table table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">#</th>
                                            <th>Rasmi</th>
                                            <th>Talaba ismi, familiyasi</th>
                                            <th>Yo'nalishi</th>
                                            <th>Guruhi</th>
                                            <th>Kursi</th>
                                            <th>Biriktirilgan o'qituvchi</th>
                                            <th>Harakatlar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $id = 1; @endphp

                                        @foreach($students as $student)
                                        <tr>
                                            <td>{{ $id++ }}</td>
                                            <td><img src="{{ $student->user->picture_path() }}" alt="User" class="img-circle" style="height: 30px;"></td>

                                            <td>{{ $student->user->short_fio() }}</td>
                                            <td>{{ $student->direction->name }}</td>
                                            <td>{{ $student->group->name }}</td>
                                            <td>{{ $student->level }}</td>
                                            <td>{{ $student->employee->user->short_fio() }}</td>
                                            <td>
                                                <form action="{{ route('employee.dean.detach-student') }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $student->id }}">
                                                    <button class="btn btn-danger btn-sm" type="submit">
                                                        <i class="fas fa-trash-alt"></i> O'chirish
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <!-- Qo'shimcha talabalar ma'lumotlari qo'shiladi -->
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