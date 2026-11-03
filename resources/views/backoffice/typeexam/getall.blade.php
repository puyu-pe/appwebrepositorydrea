@extends('backoffice.layout')
@section('title', 'Lista de tipos de evaluaciones')
@section('generalBody')
<div id="divAjaxCrudList">
    @include('backoffice.typeexam._list')
</div>
<script src="{{asset('assets/backoffice/viewResources/typeexam/getall.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
