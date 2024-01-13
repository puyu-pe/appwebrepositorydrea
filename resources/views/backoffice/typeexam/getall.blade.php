@extends('backoffice.layout')
@section('title', 'Lista de tipos de exámenes')
@section('generalBody')
<div class="nav-tabs-custom">
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1-1">
            <div id="divSearch" class="row">
                <div class="form-group col-md-1">
                    <span class="btn btn-sm btn-success glyphicon glyphicon-plus" data-toggle="tooltip" title="Nuevo tipo de examen" data-placement="right" onclick="ajaxDialog('divGeneralContainer', 'modal-lg', 'Registrar nuevo tipo de examen', null, '{{url('tipoexamen/insertar')}}', 'GET', null, null, false, true);"></span>
                </div>
                <div class="form-group col-md-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </div>
                        <input type="text" id="txtSearch" name="txtSearch" class="form-control pull-right" placeholder="Información para búsqueda (Enter)" onkeyup="searchTypeExam(this.value, '{{url('tipoexamen/mostrar/1')}}', event);" value="{{$searchParameter}}" autocomplete="off" autofocus>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    {!!ViewHelper::renderPagination('tipoexamen/mostrar', $quantityPage, $currentPage, $searchParameter)!!}
                </div>
            </div>
            <div class="table-responsive">
                <table id="tableTypeExam" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Logotipo</th>
                            <th class="text-center">Nombre completo</th>
                            <th class="text-center">Siglas</th>
                            <th class="text-center">Breve Descripción</th>
                            <th class="text-center">Se aplica</th>
                            <th class="text-center">Fecha y hora de registro</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listTTypeExam as $value)
                            <tr>
                                <td class="text-center">
                                    <div class="user-panel">
                                        <div class="pull-left image text-center">
                                            <img src="{{asset('img/logo/typeexam/'.$value->idTypeExam.'.'.$value->extensionImageType.'?x='.$value->updated_at)}}">
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->nameTypeExam}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{strtoupper($value->acronymTypeExam)}}</div>
                                </td>
                                <td>
                                    <div>{{$value->descriptionTypeExam}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->numberExecuteYear.($value->numberExecuteYear==1 ? ' vez al año' : ' veces al año')}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{date('d-m-Y', strtotime($value->created_at))}}</div>
                                    <div>{{date('g:i A', strtotime($value->created_at))}}</div>
                                </td>
                                <td class="text-center" style="width: 60px;">
                                    <span class="btn btn-info btn-xs glyphicon glyphicon-pencil" data-toggle="tooltip" title="Modificar datos" data-placement="left" onclick="ajaxDialog('divGeneralContainer', 'modal-lg', 'Modificar datos del tipo de examen', {_token: '{{csrf_token()}}', idTypeExam: '{{$value->idTypeExam}}'}, '{{url('tipoexamen/editar')}}', 'POST', null, null, false, true);"></span>
                                    <span class="btn btn-danger btn-xs glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar tipo evaluación" data-placement="left" onclick="confirmDialog(function(){ $('#modalLoading').show(); window.location.href='{{url('tipoexamen/eliminar/'.$value->idTypeExam)}}'; });"></span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('viewResources/typeexam/getall.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
