<form id="frmEditTestimony" action="{{url('testimonio/editar')}}" method="post">
    <div class="row">
        <div class="form-group col-md-12">
            <label for="txtfirstName">Nombre *</label>
            <input type="text" id="txtfirstName" name="txtfirstName" value="{{$tTestimony->firstName}}" class="form-control">
        </div>
        <div class="form-group col-md-12">
            <label for="txtsurName">Apellido *</label>
            <input type="text" id="txtsurName" name="txtsurName" value="{{$tTestimony->surName}}" class="form-control">
        </div>
        <div class="form-group col-md-12">
            <label for="txtAcademicLevel">Nivel académico</label>
            <input type="text" id="txtAcademicLevel" name="txtAcademicLevel" value="{{$tTestimony->academic_level}}"
                   class="form-control">
        </div>
        <div class="form-group col-md-12">
            <label for="txtPlaceOrigin">Lugar de procedencia *</label>
            <input type="text" id="txtPlaceOrigin" name="txtPlaceOrigin" value="{{$tTestimony->place_origin}}"
                   class="form-control">
        </div>
        <div class="form-group col-md-12">
            <label for="txtDescription">Responder: </label>
            <textarea id="txtDescription" name="txtDescription" class="form-control" autocomplete="off" placeholder="Reseña" style="resize: none;"
                      cols="10" rows="10">{!! $tTestimony->description !!}</textarea>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {{csrf_field()}}
            <input type="hidden" name="hdIdTestimony" id="hdIdTestimony" value="{{$tTestimony->idTestimony}}">
            <input type="button" class="btn btn-default pull-left" data-dismiss="modal" value="Cerrar ventana">
            <input type="button" class="btn btn-primary" value="Guardar cambios"
                   onclick="sendEditFrmTestimony();">
        </div>
    </div>
</form>
<script src="{{asset('assets/backoffice/viewResources/testimony/edit.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
