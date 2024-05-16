<form id="frmInsertGrade" action="{{url('grado/insertar')}}" method="post">
    <div class="row">
        <div class="form-group col-md-4">
            <label for="txtDescriptionGrade">Decripción*</label>
            <input type="text" id="txtDescriptionGrade" name="txtDescriptionGrade" class="form-control" autocomplete="off">
        </div>
        <div class="form-group col-md-4">
            <label for="selectNameGrade">Grado académico*</label>
            <select name="selectNameGrade" id="selectNameGrade" style="width: 100%" class="form-control">
                <option value="" selected disabled>Seleccione...</option>
                <option value="Primaria">Primaria</option>
                <option value="Secundaria">Secundaria</option>
                <option value="Inicial">Inicial</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="txtCodeGrade">Código*</label>
            <input type="text" id="txtCodeGrade" name="txtCodeGrade" class="form-control" autocomplete="off">
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {{csrf_field()}}
            <input type="button" class="btn btn-default pull-left" data-dismiss="modal" value="Cerrar ventana">
            <input type="button" class="btn btn-primary" value="Registrar" onclick="sendFrmInsertGrade();">
        </div>
    </div>
</form>
<script src="{{asset('assets/backoffice/viewResources/grade/insert.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
