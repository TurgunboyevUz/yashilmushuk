@extends('layouts::student.app')

@section('content')
<div class="content-wrapper" style="padding: 5px;">
    <section class="content-header">
        <h1>Til Sertifikati</h1>
    </section>

    <section class="content" style="padding: 5px;">
        <div class="container-fluid my-4">
            <!-- Til Sertifikati Tafsilotlari -->
            <div class="card mt-3 p-4">
                <h3 class="card-title mb-3">Til Sertifikati Tafsilotlari</h3>
                <form id="languageCertificateForm" action="{{ route('student.lang-certificate') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Chet tili -->
                        <div class="col-md-6 mb-3">
                            <label for="language" class="form-label">
                                <i class="fas fa-language"></i> Chet tili
                            </label>
                            <select id="language" name="lang" class="form-control" required>
                                <option value="" disabled selected>Tanlang</option>
                                <option value="en">Ingliz tili</option>
                                <option value="ru">Rus tili</option>
                                <option value="de">Nemis tili</option>
                                <option value="other">Boshqa</option>
                            </select>
                            @if($errors->has('lang'))
                            <span class="text-danger">{{ $errors->first('lang') }}</span>
                            @endif
                        </div>

                        <!-- Sertifikat turi -->
                        <div class="col-md-6 mb-3">
                            <label for="certificateType" class="form-label">
                                <i class="fas fa-certificate"></i> Sertifikat turi
                            </label>
                            <select id="certificateType" name="type" class="form-control" required>
                                <option value="" disabled selected>Tanlang</option>
                                <option value="national">Milliy sertifikat</option>
                                <option value="cambridge">Cambridge Assessment English (FCE, CAE, CPE)</option>
                                <option value="toefl-itp">Test of English Foreign Language (TOEFL, ITP)</option>
                                <option value="toefl-ibt">Test of English Foreign Language (TOEFL, IBT)</option>
                                <option value="ielts">International English Language Testing System (IELTS)</option>
                                <option value="itep">iTEP Academic — Plus</option>
                            </select>
                            @if($errors->has('type'))
                            <span class="text-danger">{{ $errors->first('type') }}</span>
                            @endif
                        </div>

                        <!-- Sertifikat darajasi -->
                        <div class="col-md-6 mb-3">
                            <label for="certificateLevelType" class="form-label">
                                <i class="fas fa-landmark"></i> Sertifikat darajasi
                            </label>
                            <select id="certificateLevelType" name="criteria_id" class="form-control" required>
                                <option value="" disabled selected>Tanlang</option>
                                @foreach ($criterias as $criteria)
                                <option value="{{ $criteria->id }}">{{ $criteria->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('criteria_id'))
                            <span class="text-danger">{{ $errors->first('criteria_id') }}</span>
                            @endif
                        </div>

                        <!-- Sertifikat berilgan sana -->
                        <div class="col-md-6 mb-3">
                            <label for="certificateDate" class="form-label">
                                <i class="fas fa-calendar"></i> Sertifikat berilgan sana
                            </label>
                            <input type="date" id="certificateDate" name="given_date" class="form-control" required>
                            @if($errors->has('given_date'))
                            <span class="text-danger">{{ $errors->first('given_date') }}</span>
                            @endif
                        </div>

                        <!-- Sertifikat yuklash -->
                        <div class="col-md-6 mb-3">
                            <label for="certificateFile" class="form-label">
                                <i class="fas fa-file-upload"></i> Sertifikatni PDF formatda yuklash
                            </label>
                            <input type="file" id="certificateFile" name="file" class="form-control" accept=".pdf" required>
                            @if($errors->has('file'))
                            <span class="text-danger">{{ $errors->first('file') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Saqlash tugmasi -->
                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="fas fa-save"></i> Saqlash
                    </button>
                </form>
            </div>

            <!-- Til Sertifikati Ro'yxati Jadvali -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Yuklangan Til Sertifikatlari Ro'yxati</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Chet tili</th>
                                <th>Sertifikat turi</th>
                                <th>Darajasi</th>
                                <th>Berilgan sana</th>
                                <th>Fayl nomi</th>
                                <th>Holati</th>
                                <th>Harakatlar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->lang() }}</td>
                                <td>{{ $item->type() }}</td>
                                <td>{{ $item->criteria->name }}</td>
                                <td>{{ $item->given_date }}</td>
                                <td>{!! $item->file->download_tag() !!}</td>
                                <td><span class="badge badge-{{ $item->status()['color'] }}">{{ $item->status()['name'] }}</span></td>

                                @if($item->file->status == 'pending')
                                <td>
                                    <form action="{{ route('student.lang-certificate.destroy') }}" method="POST">
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
                            <!-- Qo'shimcha sertifikatlar qo'shiladi -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
