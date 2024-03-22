@extends('backoffice.layout')
@section('title', 'Lista de cursos disponibles')
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
                            <input type="text" id="txtSearch" name="txtSearch" class="form-control pull-right"
                                   placeholder="Información para búsqueda (Enter)"
                                   onkeyup="searchContact(this.value, '{{url('contacto/mostrar/1')}}', event);"
                                   value="{{$searchParameter}}" autocomplete="off" autofocus>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        {!!ViewHelper::renderPagination('contacto/mostrar', $quantityPage, $currentPage, $searchParameter)!!}
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tableContact" class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center">Nombres</th>
                            <th class="text-center">Correo</th>
                            <th class="text-center">Teléfono</th>
                            <th class="text-center">Asunto</th>
                            <th class="text-center">Fecha de registro</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($listTContact as $value)
                            <tr>
                                <td class="text-center">
                                    <div>{{$value->completeNameContact}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->emailContact}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->phoneContact}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->affairContact}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{date('d-m-Y', strtotime($value->dateContact))}}</div>
                                    <div>{{date('g:i A', strtotime($value->created_at))}}</div>
                                </td>
                                <td class="text-center">
                                    <span class="label label-{{$value->statusContact == 0 ? 'warning' : 'success'}}" data-toggle="tooltip"
                                          title="Modificar datos" data-placement="left"
                                          onclick="ajaxDialog('divGeneralContainer', 'modal-lg', 'Responder consulta', {_token: '{{csrf_token()}}', idContact: '{{$value->idContact}}'}, '{{url('contacto/responder')}}', 'POST', null, null, false, true);">
                                        {{$value->statusContact == 0 ? 'Sin Responder' : 'Respondido'}}
                                    </span>
                                </td>
                                <td class="text-center" style="width: 60px;">
                                    @if ($value->statusContact == 1)
                                        <span class="btn btn-danger btn-xs glyphicon glyphicon-trash"
                                              data-toggle="tooltip" title="Eliminar registro" data-placement="left"
                                              onclick="confirmDialog(function(){ $('#modalLoading').show(); window.location.href='{{url('contacto/eliminar/'.$value->idContact)}}'; });"></span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/backoffice/viewResources/contact/getall.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
