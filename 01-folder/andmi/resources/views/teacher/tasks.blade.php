@extends('layouts::employee.teacher.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Topshiriq Yaratish</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Topshiriq yaratish</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Yangi Topshiriq Yaratish</h3>
                </div>
                <div class="card-body">
                    <form id="assignmentForm" action="{{ route('employee.teacher.tasks') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="studentSelect">Talabani tanlang:</label>
                            <select name="student_id" id="studentSelect" class="form-control" required>
                                <option value="" disabled selected>Talabani tanlang</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->user->fio() }} ({{ $student->level }}-kurs {{ $student->direction->name }})</option>
                                @endforeach
                            </select>
                            @if($errors->has('student_id'))
                                <span class="text-danger">{{ $errors->first('student_id') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="assignmentTitle">Topshiriq Nomi:</label>
                            <input name="title" type="text" id="assignmentTitle" class="form-control" placeholder="Topshiriq nomini kiriting" required>
                            @if($errors->has('title'))
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="assignmentDescription">Topshiriq Ta'rifi:</label>
                            <textarea name="description" id="assignmentDescription" class="form-control" rows="4" placeholder="Topshiriq ta'rifini kiriting" required></textarea>
                            @if($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="assignmentFile">Fayl yuklash:</label>
                            <input name="file" type="file" id="assignmentFile" class="form-control-file" required>
                            @if($errors->has('file'))
                                <span class="text-danger">{{ $errors->first('file') }}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary"> <i class="fas fa-plus"></i> Yaratish</button>
                    </form>
                </div>
            </div>

            <!-- Yaratilgan topshiriqlar jadvai -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Yaratilgan topshiriqlar</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-responsive table-bordered" id="assignmentTasks">
                        <thead>
                            <tr>
                                <th style="width: 3%;">#</th>
                                <th>Topshiriq Nomi</th>
                                <th>Talaba</th>
                                <th>Topshiriq ta'rifi</th>
                                <th>Fayl</th>
                                <th>Vaqti</th>
                                <th>Harakatlar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp

                            @foreach ($files as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->student->user->short_fio() }}</td>
                                <td>{{ $item->description }}</td>
                                <td><a href="{{ route('storage.download', ['uuid' => $item->file->uuid]) }}" target="_blank">{{ $item->file->name }}</a></td>
                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s') }}</td>
                                <td>
                                    <form action="{{ route('employee.teacher.tasks.destroy') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> O'chirish</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection