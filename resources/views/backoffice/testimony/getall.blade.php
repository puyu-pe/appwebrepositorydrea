@extends('backoffice.layout')
@section('title', 'Lista de reseñas del repositorio')
@section('generalBody')
    <div id="divAjaxCrudList">
        @include('backoffice.testimony._list')
    </div>
    <script src="{{asset('assets/backoffice/viewResources/testimony/getall.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
