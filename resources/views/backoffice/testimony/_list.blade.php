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
                               onkeyup="searchTestimony(this.value, '{{url('testimonio/listar')}}', event);"
                               value="{{$searchParameter}}" autocomplete="off" autofocus>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    {!!ViewHelper::renderPagination('testimonio/listar', $quantityPage, $currentPage, $searchParameter, true)!!}
                </div>
            </div>
            <div class="table-responsive">
                <table id="tableContact" class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center">Nombres y apellidos</th>
                        <th class="text-center">Nivel académico</th>
                        <th class="text-center">Lugar de procedencia</th>
                        <th class="text-center">Reseña</th>
                        <th class="text-center">Fecha de registro</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($listTestimony as $value)
                        <tr>
                            <td class="text-center">
                                <div>{{$value->firstName . ' ' . $value->surName}}</div>
                            </td>
                            <td class="text-center">
                                <div>{{$value->academic_level}}</div>
                            </td>
                            <td class="text-center">
                                <div>{{$value->place_origin}}</div>
                            </td>
                            <td class="text-center" style="width: 600px;">
                                <div>{!! $value->description !!}</div>
                            </td>
                            <td class="text-center">
                                <div>{{date('d-m-Y g:i A', strtotime($value->created_at))}}</div>
                            </td>
                            <td class="text-center">
                                <span class="label label-{{$value->is_public == 0 ? 'warning' : 'success'}}">
                                    {{$value->is_public == 0 ? 'Oculto' : 'Público'}}
                                </span>
                            </td>
                            <td class="text-center" style="width: 120px;">
                                @if ($value->is_public == 0)
                                    <span class="btn btn-info btn-xs glyphicon glyphicon-pencil" data-toggle="tooltip"
                                          title="Modificar datos" data-placement="left"
                                          onclick="ajaxDialog('divGeneralContainer', 'modal-xs', 'Modificar datos de la reseña', {_token: '{{csrf_token()}}', idTestimony: '{{$value->idTestimony}}'}, '{{url('testimonio/editar')}}', 'POST', null, null, false, true);"></span>
                                    <span class="btn btn-danger btn-xs glyphicon glyphicon-trash"
                                          data-toggle="tooltip" title="Eliminar reseña" data-placement="left"
                                          onclick="ajaxCrudDelete('{{url('testimonio/eliminar/'.$value->idTestimony)}}', '{{csrf_token()}}', {reloadUrl: window.codideepBackofficeListUrl, ajaxContainerId: 'divAjaxCrudList', postReload: initTestimonyListValidation});"></span>
                                @endif
                                <span class="btn btn-default btn-xs glyphicon glyphicon-eye-{{$value->is_public == 1 ? 'close' : 'open'}}" data-toggle="tooltip" title="{{$value->is_public == 1 ? 'Ocultar reseña' : 'Publicar reseña'}}" data-placement="left" onclick="ajaxCrudDelete('{{url('testimonio/estado/'.$value->idTestimony)}}', '{{csrf_token()}}', {reloadUrl: window.codideepBackofficeListUrl, ajaxContainerId: 'divAjaxCrudList', postReload: initTestimonyListValidation});"></span>
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
    window.codideepBackofficeListUrl={!!json_encode(url('testimonio/listar'.($currentPage == 1 ? '' : '/'.$currentPage)).(trim($searchParameter)!='' ? '?searchParameter='.urlencode($searchParameter) : ''))!!};
</script>
