<form id="frmInsertResource" action="{{url('recurso/insertar')}}" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="form-group col-md-12">
            <label for="fileResource">Recursos adicionales*</label>
            <input type="file" name="fileResource[]" id="fileResource" multiple accept=".pdf" class="form-control" style="padding: 5px;">
        </div>
    </div>
    @if($tResource->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-bordered" id="tblResponseResource">
                <thead>
                <tr>
                    <th class="text-center">N°</th>
                    <th class="text-center">Documento</th>
                    <th class="text-center">Nombre del recurso</th>
                    <th class="text-center" style="width: 40px;"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($tResource as $key => $value)
                    <tr>
                        <td class="text-center number">
                            <div>{{$key+1}}</div>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-xs btn-danger" target="_blank"
                               href="{{url('recurso/verarchivo/'.$value->idResource)}}?x={{$value->updated_at}}">Ver
                                archivo</a>
                        </td>
                        <td>
                            <div>{{$value->namecompleteResource}}</div>
                        </td>
                        <td class="text-center">
                            <span class="btn btn-default btn-sm glyphicon glyphicon-remove" data-toggle="tooltip" title="Eliminar" data-placement="left" onclick="deleteResource(this, '{{url('recurso/eliminar/'.$value->idResource)}}');"></span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <hr>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {{csrf_field()}}
            <input type="hidden" name="hdIdExam" id="hdIdExam" value="{{$tExam->idExam}}">
            <input type="button" class="btn btn-default pull-left" data-dismiss="modal" value="Cerrar ventana">
            <input type="button" class="btn btn-primary" value="Guardar" onclick="sendInsertResource();">
        </div>
    </div>
</form>
<script src="{{asset('assets/backoffice/viewResources/resource/insert.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
