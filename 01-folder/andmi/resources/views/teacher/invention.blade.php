@extends('layouts::employee.teacher.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ixtro/DGU/Foydali Model</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Ixtro/DGU/Foydali Model</li>
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
                            <h3 class="card-title">Barcha Ixtro/DGU/Foydali Model</h3>
                            <div class="ml-auto d-flex">
                                <button id="zipDownload" class="btn btn-success" data-url="{{ route('storage.zip') }}"  data-name="inventions">
                                    <i class="fas fa-file-archive"></i> ZIP Yuklash
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                                <table id="inventionsTable" class="table table-bordered table-responsive table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;"><input type="checkbox" id="checkAll"></th>
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 7%;">Rasmi</th>
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
                                        @php $id = 1; @endphp

                                        @foreach ($files as $item)
                                        <tr>
                                            <td><input type="checkbox" class="checkItem" data-uuid="{{ $item->uuid }}"></td>
                                            <td>{{ $id++ }}</td>
                                            <td><img src="{{ $item->user->picture_path() }}" alt="User" class="img-circle" style="height: 30px;"></td>
                                            <td>{{ $item->user->fio() }}</td>
                                            <td>{{ $item->invention->title }}</td>
                                            <td>{{ $item->invention->criteria->name }}</td>
                                            <td>{{ $item->invention->property_number }}</td>
                                            <td>{{ $item->invention->authors_count }}</td>
                                            <td>{{ $item->invention->authors }}</td>
                                            <td>{{ $item->invention->publish_params }}</td>
                                            <td>{{ $item->invention->education_year->name }}</td>
                                            <td>{!! $item->download_tag() !!}</td>
                                            <td><span class="badge badge-{{ $item->status()['color'] }}">{{ $item->status()['name'] }}</span></td>
                                            @if($item->status == 'pending')
                                            <td>
                                                <button class="btn btn-sm btn-success confirmAction" data-id="{{ $item->invention->id }}" data-url="{{ route('employee.teacher.invention.review') }}" ><i class="fas fa-check"></i></button>
                                                <button class="btn btn-sm btn-danger cancelAction" data-id="{{ $item->invention->id }}" data-url="{{ route('employee.teacher.invention.reject') }}" ><i class="fas fa-ban"></i></button>
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
