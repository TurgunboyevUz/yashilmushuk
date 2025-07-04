@extends('layouts::employee.dean.app')

@section('content')
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Nomdor stipendiyaga tushgan arizalar ro'yxati</h3>
                            <div class="ml-auto d-flex">
                                <button id="excelDownload" class="btn btn-success" onclick="window.location = '{{ route('excel.distinguished-scholarship') }}';">
                                    <i class="fas fa-file-excel"></i> Excel yuklash
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                                <table class="table table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;"><input type="checkbox" id="checkAll"></th>
                                            <th style="width: 5%;">#</th>
                                            <th>Rasmi</th>
                                            <th>Talaba ismi, familiyasi</th>
                                            <th>Pasport nusxasi</th>
                                            <th>Reyting daftarchasi</th>
                                            <th>Fakultet bayonnomasi</th>
                                            <th>Kafedra mudiri tavsiyanomasi</th>
                                            <th>Ariza holati</th>
                                            <th>Harakatlar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $id = 1; @endphp

                                        @foreach($files as $item)
                                        <tr>
                                            <td><input type="checkbox" class="checkItem" data-uuid='{{ json_encode([$item[0]->uuid, $item[1]->uuid, $item[2]->uuid, $item[3]->uuid]) }}'></td>
                                            <td>{{ $id++ }}</td>
                                            <td><img src="{{ $item[0]->user->picture_path() }}" alt="User" class="img-circle" style="height: 30px;"></td>

                                            <td>{{ $item[0]->user->fio() }}</td>
                                            <td>{!! $item[0]->download_tag() !!}</td>
                                            <td>{!! $item[1]->download_tag() !!}</td>
                                            <td>{!! $item[2]->download_tag() !!}</td>
                                            <td>{!! $item[3]->download_tag() !!}</td>

                                            <td><span class="badge badge-{{ $item[0]->status()['color'] }}">{{ $item[0]->status()['name'] }}</span></td>
                                            @if($item[0]->status == 'rejected')
                                            <td>
                                                <button id="reject-eye-button" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal" data-reason="{{ $item[0]->reject_reason }}">
                                                    <i class="fa fa-eye fa-sm"></i>
                                                </button>
                                            </td>
                                            @else
                                            <td>Bu fayl uchun harakat imkonsiz</td>
                                            @endif
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