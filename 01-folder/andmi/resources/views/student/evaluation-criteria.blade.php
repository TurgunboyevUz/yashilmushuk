@extends('layouts::student.app')

@section('content')
<div class="content-wrapper" style="padding: 20px;">
    <section class="content-header">
        <h1>BMI uchun ball olish imkoniyatlari</h1>
    </section>

    <section class="content">
        <div class="container-fluid my-4">
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Ball olish uchun imkoniyatlar</h3>
                </div>
                <div class="card-body">
                    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f2f2f2;">
                                <th>Imkoniyat turi</th>
                                <th>Faoliyat</th>
                                <th>Ball</th>
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
                                        <td> {{ $criteria->score }} ball</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
