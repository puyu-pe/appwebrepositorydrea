@extends('backoffice.layout')
@section('title', 'Lista de usuarios del sistema')
@section('generalBody')
<div id="divAjaxCrudList">
    @include('backoffice.user._list')
</div>
<script src="{{asset('assets/backoffice/viewResources/user/getall.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
