<form id="frmInsertGrade" action="{{url('grado/insertar')}}" method="post">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="txtNumberGrade">N° del grado*</label>
            <input type="number" id="txtNumberGrade" name="txtNumberGrade" min="1" max="6" class="form-control" autocomplete="off">
        </div>
        <div class="form-group col-md-6">
            <label for="selectNameGrade">Nombre completo del curso*</label>
            <select name="selectNameGrade" id="selectNameGrade" style="width: 100%" class="form-control">
                <option value="">Seleccione...</option>
                <option value="Primaria">Primaria</option>
                <option value="Secundaria">Secundaria</option>
            </select>
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
