@extends('layouts::employee.inspeksiya.app')

@section('content')
<div class="content-wrapper" style="padding: 20px">
    <section class="content-header">
        <h1>BMI ballarini tahrirlash</h1>
    </section>

    <section class="content">
        <div class="container-fluid my-4">
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Ball miqdorlarini o'zgartirish</h3>
                </div>
                <div class="card-body">
                    <form id="bmiScoreForm" action="{{ route('employee.inspeksiya.evaluation-criteria') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #f2f2f2;">
                                    <th>Imkoniyat turi</th>
                                    <th>Faoliyat</th>
                                    <th style="width: 8%;">Ball</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                @php
                                $count = $category->criterias->count();
                                @endphp

                                @foreach($category->criterias as $index => $criteria)
                                <tr>
                                    @if($index == 0)
                                    <td rowspan="{{ $count }}"> {{ $category->name }} </td>
                                    @endif
                                    <td> {{ $criteria->name }} </td>
                                    <td>
                                        <input name="score[{{ $criteria->id }}]" type="number" class="form-control form-control-sm" value="{{ $criteria->score }}" min="0" maxlength="2">
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Saqlash tugmasi jadvalning pastki markazida -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-sm"> <i class="fas fa-check"></i> Barchasini saqlash</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
