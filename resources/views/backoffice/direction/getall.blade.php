@extends('backoffice.layout')
@section('title', 'Lista de DRE en el sistema')
@section('generalBody')
<div id="divAjaxCrudList">
    @include('backoffice.direction._list')
</div>
<script src="{{asset('assets/backoffice/viewResources/direction/getall.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
