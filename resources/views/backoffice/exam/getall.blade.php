@extends('backoffice.layout')
@section('title', 'Lista de evaluaciones registradas en el sistema')
@section('generalBody')
    <div id="divAjaxCrudList">
        @include('backoffice.exam._list')
    </div>
    <script src="{{ asset('assets/backoffice/viewResources/exam/getall.js') }}?v={{ filemtime(public_path('assets/backoffice/viewResources/exam/getall.js')) }}"></script>
@endsection
