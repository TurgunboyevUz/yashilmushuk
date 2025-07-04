@extends('layouts::student.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Ixtro/DGU/Foydali model</h1>
    </section>

    <!-- Intellektual mulk yaratish shakli -->
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Intellektual Mulk Yaratish</h3>
        </div>
        <div class="card-body">
            <form id="inventionForm" action="{{ route('student.invention') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Talaba FIO -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="studentName"><i class="fas fa-user"></i> Talaba FIO</label>
                        <input type="text" id="studentName" name="student_name" class="form-control" placeholder="{{ $user->fio() }}" disabled required>
                    </div>
                    <!-- Intellektual Mulk Nomi -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="propertyTitle"><i class="fas fa-book"></i> Intellektual Mulk Nomi</label>
                        <input type="text" id="propertyTitle" name="title" class="form-control" placeholder="Intellektual mulk nomi" required>
                    </div>
                    <!-- Intellektual Mulk Turi -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="propertyType"><i class="fas fa-file-alt"></i> Intellektual Mulk Turi</label>
                        <select id="propertyType" name="criteria_id" class="form-control" required>
                            <option value="" disabled selected>Tanlang...</option>
                            @foreach ($criterias as $criteria)
                                <option value="{{ $criteria->id }}">{{ $criteria->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Intellektual Mulk Raqami -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="propertyNumber"><i class="fas fa-hashtag"></i> Intellektual Mulk Raqami</label>
                        <input type="text" id="propertyNumber" name="property_number" class="form-control" placeholder="12345" required>
                    </div>
                    <!-- Mualliflar soni -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="authorCount"><i class="fas fa-users"></i> Mualliflar soni</label>
                        <input type="number" id="authorCount" name="authors_count" class="form-control" placeholder="Mualliflar soni" required>
                    </div>
                    <!-- Mualliflar -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="authors"><i class="fas fa-user-friends"></i> Mualliflar</label>
                        <input type="text" id="authors" name="authors" class="form-control" placeholder="Samadov Fahriddin, Anvarov Oyatillo" required>
                        <small class="form-text text-muted">Masalan: Samadov, Anvarov Oyatillo, Diyorbek Turg'unboyev</small>
                    </div>
                    <!-- Nashr Parametrlari -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="publicationParams"><i class="fas fa-newspaper"></i> Nashr Parametrlari</label>
                        <input type="text" id="publicationParams" name="publish_params" class="form-control" placeholder="Nashr haqida ma'lumot" required>
                    </div>
                    <!-- O'quv yili -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="academicYear"><i class="fas fa-calendar"></i> O'quv yili</label>
                        <select class="form-control" id="academicYear" name="education_year">
                            <option value="" disabled selected>Tanlang</option>
                            @foreach ($education_year as $year)
                                <option value="{{ $year->id }}">{{ $year->name }}</option>                                        
                            @endforeach
                        </select>
                    </div>
                    <!-- Fayl Yuklash -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="fileUpload"><i class="fas fa-upload"></i> Fayl Yuklash</label>
                        <input type="file" id="fileUpload" name="file" class="form-control-file" required>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Saqlash</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Jadval: Intellektual mulklar ro'yxati -->
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Yuklangan Intellektual Mulklar ro'yxati</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Talaba FIO</th>
                        <th>Intellektual Mulk Nomi</th>
                        <th>Turi</th>
                        <th>Raqami</th>
                        <th>Mualliflar soni</th>
                        <th>Mualliflar</th>
                        <th>Nashr Parametrlari</th>
                        <th>O'quv yili</th>
                        <th>Fayl nomi</th>
                        <th>Holati</th>
                        <th>Harakatlar</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                    <tr>        
                        <td>{{ $user->fio() }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->criteria->name }}</td>
                        <td>{{ $item->property_number }}</td>
                        <td>{{ $item->authors_count }}</td>
                        <td>{{ $item->authors }}</td>
                        <td>{{ $item->publish_params }}</td>
                        <td>{{ $item->education_year->name }}</td>
                        <td>{!! $item->file->download_tag() !!}</td>
                        <td><span class="badge badge-{{ $item->status()['color'] }}">{{ $item->status()['name'] }}</span></td>
                                    
                        @if($item->file->status == 'pending')
                            <td>
                                <form action="{{ route('student.invention.destroy') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> O'chirish</button>
                                </form>
                            </td>
                        @elseif($item->file->status == 'rejected')
                            <td>
                                <button id="reject-eye-button" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal" data-reason="{{ $item->file->reject_reason }}">
                                    <i class="fa fa-eye fa-sm"></i>
                                </button>
                            </td>
                        @else
                            <td>
                                Bu fayl uchun harakat imkonsiz
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
