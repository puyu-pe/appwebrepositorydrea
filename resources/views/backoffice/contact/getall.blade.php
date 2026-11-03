@extends('backoffice.layout')
@section('title', 'Lista de mensajes')
@section('generalBody')
    <div id="divAjaxCrudList">
        @include('backoffice.contact._list')
    </div>
    <script src="{{asset('assets/backoffice/viewResources/contact/getall.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
