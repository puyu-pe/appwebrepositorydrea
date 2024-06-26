@extends('backoffice.layout')
@section('title', 'Lista de evaluaciones registradas en el sistema')
@section('generalBody')
    <div class="nav-tabs-custom">
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1-1">
                <div id="divSearch" class="row">
                    <div class="form-group col-md-5">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-search"></i>
                            </div>
                            <input type="text" id="txtSearch" name="txtSearch" class="form-control pull-right"
                                   placeholder="Información para búsqueda (Enter)" value="{{$searchParameter}}"
                                   autofocus onkeyup="searchExam(this.value, '{{url('examen/mostrar/1')}}', event);"
                                   autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="hidden" id="downloadUrl" value="{{ url('download/selected') }}">
                        <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
                        <button id="downloadBtn" style="display:none;" class="btn btn-primary btn-success">
                            <i class="fa fa-download"></i>
                            Descargar archivos
                        </button>
                    </div>
                    <div class="form-group col-md-5">
                        {!!ViewHelper::renderPagination('examen/mostrar', $quantityPage, $currentPage, $searchParameter)!!}
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tableExam" class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center"><i class="fa fa-download text-success"></i></th>
                            <th class="text-center">Evaluación</th>
                            <th class="text-center">Código</th>
                            <th class="text-center">Año</th>
                            <th class="text-center">Nombre del examen</th>
                            <th class="text-center">N° de páginas</th>
                            <th class="text-center">Palabras clave</th>
                            <th class="text-center">Vista previa</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Fecha y hora registro</th>
                            <th class="text-center"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($listTExam as $value)
                            <tr>
                                <td>
                                    <input type="checkbox" id="result[]" name="result[]"
                                           value="{{$value->idExam}}"
                                           style="width: 30px; height: 30px;">
                                </td>
                                <td class="text-center" style="width: 80px;">
                                    <a class="btn btn-xs btn-danger" target="_blank"
                                       href="{{url('examen/verarchivo/'.$value->idExam)}}?x={{$value->updated_at}}">Ver archivo</a>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->codeExam}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->yearExam}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->nameExam}}</div>
                                    <div><small style="font-weight: bold;">{{$value->register_answer == 0 ? 'No permite respuestas' : 'Permite respuestas'}}</small></div>
                                    @if($value->register_answer != 0)
                                        <div><small style="font-weight: bold;">{{$value->number_question == 1 ? 'Máximo 1 respuesta' : 'Máximo '.$value->number_question. ' respuestas'}}</small></div>
                                    @endif
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
                                    <span class="label" style="display: inline-block;">
                                        <img src="{{ asset('storage/exam-img/' . $value->idExam . '.jpg') }}"
                                             alt="Vista previa"
                                            style="width: 70px; border: 1px dashed #ccc; color: black"
                                        >
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="label label-{{$value->stateExam=='Publico' ? 'success' : 'warning'}}"
                                          style="display: inline-block;">{{$value->stateExam}}</span>
                                </td>
                                <td class="text-center">
                                    <div>{{date('d-m-Y', strtotime($value->created_at))}}</div>
                                    <div>{{date('g:i A', strtotime($value->created_at))}}</div>
                                </td>
                                <td class="text-center" style="width: 100px;">
                                    @if(stristr(Session::get('roleUser'), 'Administrador') || stristr(Session::get('roleUser'), 'Supervisor'))
                                        <span class="btn btn-info btn-xs glyphicon glyphicon-pencil" data-toggle="tooltip"
                                              title="Modificar datos" data-placement="left"
                                              onclick="ajaxDialog('divGeneralContainer', 'modal-lg', 'Modificar datos de la evaluación', {_token: '{{csrf_token()}}', idExam: '{{$value->idExam}}'}, '{{url('examen/editar')}}', 'POST', null, null, false, true);"></span>
                                    @endif
                                    @if ($value->register_answer == 1)
                                        <span class="btn btn-info btn-xs glyphicon glyphicon-list" data-toggle="tooltip"
                                              title="Registrar respuestas" data-placement="left"
                                              onclick="ajaxDialog('divGeneralContainer', 'modal-xs', 'Registrar respuestas de la evaluación', {_token: '{{csrf_token()}}', idExam: '{{$value->idExam}}'}, '{{url('respuesta/insertar')}}', 'POST', null, null, false, true);"></span>
                                    @endif
                                    @if(stristr(Session::get('roleUser'), 'Administrador') || stristr(Session::get('roleUser'), 'Supervisor'))
                                        <span class="btn btn-default btn-xs glyphicon glyphicon-eye-{{$value->stateExam == 'Publico' ? 'close' : 'open'}}" data-toggle="tooltip" title="{{$value->stateExam== 'Publico' ? 'Ocultar evaluacion' : 'Publicar evaluación'}}" data-placement="left" onclick="confirmDialog(function(){ $('#modalLoading').modal('show'); window.location.href='{{url('examen/estado/'.$value->idExam)}}'; });"></span>
                                    @endif
                                    <span class="btn btn-{{$value->stateExam == 'Publico' ? 'default' : 'warning'}} btn-xs glyphicon glyphicon-save-file" data-toggle="tooltip" title="{{$value->stateExam == 'Publico' ? 'Ver página de evaluación' : 'Vista previa de la evaluación'}}" data-placement="left" onclick="window.open('{{url('examen/ver/'.$value->codeExam)}}', '_blank');"></span>
                                    @if ($value->stateExam != 'Publico' && (stristr(Session::get('roleUser'), 'Administrador') || stristr(Session::get('roleUser'), 'Supervisor')))
                                        <span class="btn btn-danger btn-xs glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar evaluación" data-placement="left" onclick="confirmDialog(function(){ $('#modalLoading').show(); window.location.href='{{url('examen/eliminar/'.$value->idExam)}}'; });"></span>
                                    @endif
                                    <span class="btn btn-default btn-xs glyphicon glyphicon-list-alt" data-toggle="tooltip"
                                          title="Agregar recursos" data-placement="left"
                                          onclick="ajaxDialog('divGeneralContainer', 'modal-xs', 'Agregar recursos para la evaluación', {_token: '{{csrf_token()}}', idExam: '{{$value->idExam}}'}, '{{url('recurso/insertar')}}', 'POST', null, null, false, true);"></span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/backoffice/viewResources/exam/getall.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
