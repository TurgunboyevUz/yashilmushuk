@extends('layouts::employee.teacher.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Stipendiya Yutuqlari</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Stipendiya Yutuqlari</li>
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
                            <h3 class="card-title">Barcha Stipendiya Yutuqlari</h3>
                            <div class="ml-auto d-flex">
                                <button id="zipDownload" class="btn btn-success" data-url="{{ route('storage.zip') }}"  data-name="scholarships">
                                    <i class="fas fa-file-archive"></i> ZIP Yuklash
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="max-width: 105%; overflow-x: auto;">
                                <table id="scholarshipsTable" class="table table-bordered table-responsive table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;"><input type="checkbox" id="checkAll"></th>
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 7%;">Rasmi</th>
                                            <th>Talaba Ism, Familiyasi</th>
                                            <th>Yutuq Turi</th>
                                            <th>Berilgan Sana</th>
                                            <th>Guvohnoma Raqami</th>
                                            <th>Nomi</th>
                                            <th>Fayl Nomi</th>
                                            <th>Holati</th>
                                            <th>Harakatlar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $id = 1; @endphp
                                        @foreach($files as $item)
                                        <tr>
                                            <td><input type="checkbox" class="checkItem" data-uuid="{{ $item->uuid }}"></td>
                                            <td>{{ $id++ }}</td>
                                            <td><img src="{{ $item->user->picture_path() }}" alt="User" class="img-circle" style="height: 30px;"></td>
                                            <td>{{ $item->user->fio() }}</td>
                                            <td>{{ $item->scholarship->criteria->name }}</td>
                                            <td>{{ $item->scholarship->given_date }}</td>
                                            <td>{{ $item->scholarship->certificate_number }}</td>
                                            <td>{{ $item->scholarship->title }}</td>
                                            <td>{!! $item->download_tag() !!}</td>
                                            <td><span class="badge badge-{{ $item->status()['color'] }}">{{ $item->status()['name'] }}</span></td>|
                                            @if($item->status == 'pending')
                                            <td>
                                                <button class="btn btn-sm btn-success confirmAction" data-id="{{ $item->scholarship->id }}" data-url="{{ route('employee.teacher.scholarship.review') }}" ><i class="fas fa-check"></i></button>
                                                <button class="btn btn-sm btn-danger cancelAction" data-id="{{ $item->scholarship->id }}" data-url="{{ route('employee.teacher.scholarship.reject') }}" ><i class="fas fa-ban"></i></button>
                                            </td>
                                            @elseif($item->status == 'rejected')
                                            <td>
                                                <button id="reject-eye-button" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal" data-reason="{{ $item->reject_reason }}">
                                                    <i class="fa fa-eye fa-sm"></i>
                                                </button>
                                            </td>
                                            @else
                                            <td>Bu fayl uchun harakat imkonsiz</td>
                                            @endif
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
