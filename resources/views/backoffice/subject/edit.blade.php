<form id="frmEditSubject" action="{{url('curso/editar')}}" method="post">
    <div class="row">
        <div class="form-group col-md-12">
            <label for="txtNameSubject">Nombre completo del curso*</label>
            <input type="text" id="txtNameSubject" name="txtNameSubject" value="{{$tSubject->nameSubject}}" class="form-control" autocomplete="off">
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {{csrf_field()}}
            <input type="hidden" name="hdIdSubject" id="hdIdSubject" value="{{$tSubject->idSubject}}">
            <input type="button" class="btn btn-default pull-left" data-dismiss="modal" value="Cerrar ventana">
            <input type="button" class="btn btn-primary" value="Guardar cambios" onclick="sendFrmEditSubject();">
        </div>
    </div>
</form>
<script src="{{asset('assets/backoffice/viewResources/subject/edit.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
