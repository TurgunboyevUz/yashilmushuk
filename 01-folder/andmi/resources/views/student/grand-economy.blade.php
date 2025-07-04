@extends('layouts::student.app')

@section('content')
<div class="content-wrapper" style="padding: 5px;">
    <section class="content-header">
        <h1>Grand/Xo'jalik Shartnomalari</h1>
    </section>

    <section class="content" style="padding: 5;">
        <div class="container-fluid my-4">
            <!-- Shartnoma Tafsilotlari formasi -->
            <div class="card mt-3 p-4">
                <h3 class="card-title mb-3">Shartnoma Tafsilotlari</h3>
                <form id="contractForm" action="{{ route('student.grand-economy') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Shartnoma turi -->
                        <div class="col-12 col-md-6 mb-3">
                            <label for="contractType" class="form-label">
                                <i class="fas fa-file-contract"></i> Shartnoma turi
                            </label>
                            <select id="contractType" class="form-control" name="criteria_id" required>
                                <option value="" disabled selected>Tanlang</option>
                                @foreach ($criterias as $criteria)
                                <option value="{{ $criteria->id }}">{{ $criteria->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('criteria_id'))
                            <span class="text-danger">{{ $errors->first('criteria_id') }}</span>
                            @endif
                        </div>

                        <!-- Grant/Loyiha nomi -->
                        <div class="col-12 col-md-6 mb-3">
                            <label for="projectName" class="form-label">
                                <i class="fas fa-project-diagram"></i> Grant/Loyiha nomi
                            </label>
                            <input type="text" id="projectName" class="form-control" name="title" placeholder="Grant yoki loyiha nomini kiriting" required>
                            @if($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                            @endif
                        </div>

                        <!-- Buyruq raqami -->
                        <div class="col-12 col-md-6 mb-3">
                            <label for="orderNumber" class="form-label">
                                <i class="fas fa-hashtag"></i> Buyruq raqami
                            </label>
                            <input type="text" id="orderNumber" class="form-control" name="order_number" placeholder="Buyruq raqamini kiriting" required>
                            @if($errors->has('order_number'))
                            <span class="text-danger">{{ $errors->first('order_number') }}</span>
                            @endif
                        </div>

                        <!-- Mablag'i miqdori -->
                        <div class="col-12 col-md-6 mb-3">
                            <label for="amount" class="form-label">
                                <i class="fas fa-dollar-sign"></i> Mablag'i miqdori
                            </label>
                            <input type="number" id="amount" class="form-control" name="amount" placeholder="Mablag' miqdorini kiriting" required>
                            @if($errors->has('amount'))
                            <span class="text-danger">{{ $errors->first('amount') }}</span>
                            @endif
                        </div>

                        <!-- Buyruq (ko'chirma yuklash) -->
                        <div class="col-12 mb-3">
                            <label for="orderFile" class="form-label">
                                <i class="fas fa-file-upload"></i> Buyruqdan ko'chirma
                            </label>
                            <input type="file" id="orderFile" class="form-control" name="file" required>
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

            <!-- Jadval: Shartnoma Tafsilotlari -->
            <div class="card card-primary mt-4">
                <div class="card-header">
                    <h3 class="card-title">Yuklangan Shartnomalar Ro'yxati</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-responsive">
                        <thead>
                            <center>
                                <tr>
                                    <th>Shartnoma turi</th>
                                    <th>Grant/Loyiha nomi</th>
                                    <th>Buyruq raqami</th>
                                    <th>Mablag' miqdori</th>
                                    <th>Fayl nomi</th>
                                    <th>Holati</th>
                                    <th>Harakatlar</th>
                                </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->criteria->name }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->order_number }}</td>
                                <td>{{ $item->amount }} </td>
                                <td>{!! $item->file->download_tag() !!}</td>
                                <td><span class="badge badge-{{ $item->status()['color'] }}">{{ $item->status()['name'] }}</span></td>

                                @if($item->file->status == 'pending')
                                <td>
                                    <form action="{{ route('student.grand-economy.destroy') }}" method="POST">
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
