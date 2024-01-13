@extends('backoffice.layout')
@section('title', 'Lista de DRE en el sistema')
@section('generalBody')
<div class="nav-tabs-custom">
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1-1">
            <div id="divSearch" class="row">
                <div class="form-group col-md-1">
                    <span class="btn btn-success glyphicon glyphicon-plus" data-toggle="tooltip" title="Nueva DRE" data-placement="right" onclick="ajaxDialog('divGeneralContainer', 'modal-xs', 'Insertar un DRE', null, '{{url('direccion/insertar')}}', 'GET', null, null, false, true);"></span>
                </div>
                <div class="form-group col-md-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </div>
                        <input type="text" id="txtSearch" name="txtSearch" class="form-control pull-right" placeholder="Información para búsqueda (Enter)" autofocus onkeyup="searchDirection(this.value, '{{url('direccion/mostrar/1')}}', event);" value="{{$searchParameter}}" autocomplete="off">
                    </div>
                </div>
                <div class="form-group col-md-5">
                    {!!ViewHelper::renderPagination('direccion/mostrar', $quantityPage, $currentPage, $searchParameter)!!}
                </div>
            </div>
            <div class="table-responsive">
                <table id="tableDirection" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Logo</th>
                            <th class="text-center">Nombre completo</th>
                            <th class="text-center">Denominación</th>
                            <th class="text-center">Departamento</th>
                            <th class="text-center">Fecha y hora registro</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listTDirection as $value)
                            <tr>
                                <td class="text-center" style="width: 80px;">
                                    @if ($value->logoExtension != '')
                                        <div class="user-panel">
                                            <div class="pull-left image">
                                                <img src="{{asset('img/logo/direction/'.$value->idDirection.'.'.$value->logoExtension.'?x='.$value->updated_at)}}" class="img-circle" alt="User Image">
                                            </div>
                                        </div>
                                    @else
                                        <div>Sin logo disponible</div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div>{{$value->namecompleteDirection}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->namesortDirection}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->nameRegion}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{date('d-m-Y', strtotime($value->created_at))}}</div>
                                    <div>{{date('g:i A', strtotime($value->created_at))}}</div>
                                </td>
                                <td class="text-center" style="width: 80px;">
                                    <span class="btn btn-info btn-xs glyphicon glyphicon-pencil" data-toggle="tooltip" title="Modificar datos" data-placement="left" onclick="ajaxDialog('divGeneralContainer', 'modal-xs', 'Modificar datos', {_token: '{{csrf_token()}}', idDirection: '{{$value->idDirection}}'}, '{{url('direccion/editar')}}', 'POST', null, null, false, true);"></span>
                                    <span class="btn btn-danger btn-xs glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar DRE" data-placement="left" onclick="confirmDialog(function(){ $('#modalLoading').show(); window.location.href='{{url('direccion/eliminar/'.$value->idDirection)}}'; });"></span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('viewResources/direction/getall.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
