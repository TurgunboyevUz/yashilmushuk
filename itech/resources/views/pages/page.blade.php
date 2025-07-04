@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="content-render">
        {!! $page->content !!}
    </div>
</div>
@endsection