<div class="nav-tabs-custom">
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1-1">
            <div id="divSearch" class="row">
                <div class="form-group col-md-1">
                    <span class="btn btn-success glyphicon glyphicon-plus" data-toggle="tooltip" title="Nuevo grado" data-placement="right" onclick="ajaxDialog('divGeneralContainer', 'modal-xs', 'Insertar un grado', null, '{{url('grado/insertar')}}', 'GET', null, null, false, true);"></span>
                </div>
                <div class="form-group col-md-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </div>
                        <input type="text" id="txtSearch" name="txtSearch" class="form-control pull-right" placeholder="Información para búsqueda (Enter)" autofocus onkeyup="searchGrade(this.value, '{{url('grado/listar/1')}}', event);" value="{{$searchParameter}}" autocomplete="off">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    {!!ViewHelper::renderPagination('grado/listar', $quantityPage, $currentPage, $searchParameter, true)!!}
                </div>
            </div>
            <div class="table-responsive">
                <table id="tableGrade" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Descripción del grado</th>
                            <th class="text-center">Nivel</th>
                            <th class="text-center">Código</th>
                            <th class="text-center">Fecha de registro</th>
                            <th class="text-center">Hora de registro</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listTGrade as $value)
                            <tr>
                                <td class="text-center">
                                    <div>{{$value->descriptionGrade}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->nameGrade}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->codeGrade}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{date('d-m-Y', strtotime($value->created_at))}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{date('g:i A', strtotime($value->created_at))}}</div>
                                </td>
                                <td class="text-center" style="width: 100px;">
                                    <span class="btn btn-info btn-xs glyphicon glyphicon-pencil" data-toggle="tooltip" title="Modificar datos" data-placement="left" onclick="ajaxDialog('divGeneralContainer', 'modal-xs', 'Modificar datos del grado', {_token: '{{csrf_token()}}', idGrade: '{{$value->idGrade}}'}, '{{url('grado/editar')}}', 'POST', null, null, false, true);"></span>
                                    <span class="btn btn-danger btn-xs glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar grado" data-placement="left" onclick="ajaxCrudDelete('{{url('grado/eliminar/'.$value->idGrade)}}', '{{csrf_token()}}', {reloadUrl: window.codideepBackofficeListUrl, ajaxContainerId: 'divAjaxCrudList', postReload: initGradeListValidation});"></span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    window.codideepBackofficeInsertReloadUrl={!!json_encode(url('grado/listar/1'))!!};
    window.codideepBackofficeListUrl={!!json_encode(url('grado/listar/'.$currentPage).(trim($searchParameter)!='' ? '?searchParameter='.urlencode($searchParameter) : ''))!!};
</script>
