@extends('backoffice.layout')
@section('title', 'Lista de grados de instituciones')
@section('generalBody')
<div id="divAjaxCrudList">
    @include('backoffice.grade._list')
</div>
<script src="{{asset('assets/backoffice/viewResources/grade/getall.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
