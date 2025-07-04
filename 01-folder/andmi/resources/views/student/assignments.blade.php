@extends('layouts::student.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Topshiriqlar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Berilgan topshiriqlar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Topshiriqlar ro'yxati -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Berilgan Topshiriqlar</h3>
                </div>
                <div class="card-body">
                    <div class="list-group">
			@if(count($data) == 0)
			    <h5 align="center">Berilgan topshiriqlar mavjud emas.</h5>
			@endif
                        @php $i = 1; @endphp
                        @foreach($data as $item)
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><i class="fas fa-file-alt"></i> {{ $i++ }}. {{ $item->title }}</h5>
                                    <a href="{{ route('storage.download', ['uuid' => $item->file->uuid]) }}" class="btn btn-sm btn-success" download><i class="fas fa-download"></i> Yuklab Olish</a>
                                </div>
                                <p class="mb-1">{{ $item->description }}</p>
                                <small class="text-muted">Topshiriq yuklangan sana: {{ $item->created_at->format('H:i d-m-Y') }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
