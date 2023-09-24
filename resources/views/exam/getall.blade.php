@extends('dashboard.layout')
@section('title', 'Lista de evaluaciones registradas en el sistema')
@section('generalBody')
<div class="nav-tabs-custom">
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1-1">
            <div id="divSearch" class="row">
                <div class="form-group col-md-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </div>
                        <input type="text" id="txtSearch" name="txtSearch" class="form-control pull-right" placeholder="Información para búsqueda (Enter)" value="{{$searchParameter}}" autofocus onkeyup="searchExam(this.value, '{{url('examen/mostrar/1')}}', event);" autocomplete="off">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    {!!ViewHelper::renderPagination('examen/mostrar', $quantityPage, $currentPage, $searchParameter)!!}
                </div>
            </div>
            <div class="table-responsive">
                <table id="tableExam" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Documento</th>
                            <th class="text-center">Código</th>
                            <th class="text-center">Año</th>
                            <th class="text-center">Nombre del examen</th>
                            <th class="text-center">Breve descripción</th>
                            <th class="text-center">N° de páginas</th>
                            <th class="text-center">Palabras clave</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Fecha y hora registro</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listTExam as $value)
                            <tr>
                                <td class="text-center" style="width: 80px;">
                                    <a class="btn btn-xs btn-danger" target="_black" href="{{url('examen/verarchivo/'.$value->idExam)}}?x={{$value->updated_at}}">Ver examen</a>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->codeExam}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->yearExam}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->nameExam}}</div>
                                </td>
                                <td>
                                    <div>{{$value->descriptionExam}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->totalPageExam==1 ? $value->totalPageExam.' páginas' : $value->totalPageExam.' páginas'}}</div>
                                </td>
                                <td class="text-center">
                                    @foreach(explode('__7SEPARATOR7__', $value->keywordExam) as $item)
                                        <span class="label label-default">{{$item}}</span>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <span class="label label-{{$value->stateExam=='Publico' ? 'success' : 'warning'}}" style="display: inline-block;">{{$value->stateExam}}</span>
                                </td>
                                <td class="text-center">
                                    <div>{{date('d-m-Y', strtotime($value->created_at))}}</div>
                                    <div>{{date('g:i A', strtotime($value->created_at))}}</div>
                                </td>
                                <td class="text-center" style="width: 100px;">
                                    <span class="btn btn-info btn-xs glyphicon glyphicon-pencil" data-toggle="tooltip" title="Modificar datos" data-placement="left" onclick="ajaxDialog('divGeneralContainer', 'modal-lg', 'Modificar datos de la evaluación', {_token: '{{csrf_token()}}', idExam: '{{$value->idExam}}'}, '{{url('examen/editar')}}', 'POST', null, null, false, true);"></span>
                                    <span class="btn btn-danger btn-xs glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar evaluación" data-placement="left" onclick="confirmDialog(function(){ $('#modalLoading').show(); window.location.href='{{url('examen/eliminar/'.$value->idExam)}}'; });"></span>
                                    <span class="btn btn-success btn-xs glyphicon glyphicon-list" data-toggle="tooltip" title="Registrar respuestas" data-placement="left" onclick="window.location.href='{{url('cuestionario/registrar/'.$value->idExam)}}'"></span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('viewResources/exam/getall.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
