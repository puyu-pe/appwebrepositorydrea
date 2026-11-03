@extends('backoffice.layout')
@section('title', 'Lista de cursos disponibles')
@section('generalBody')
<div id="divAjaxCrudList">
    @include('backoffice.subject._list')
</div>
<script src="{{asset('assets/backoffice/viewResources/subject/getall.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
