<form id="frmEditGrade" action="{{url('grado/editar')}}" method="post">
    <div class="row">
        <div class="form-group col-md-4">
            <label for="txtNumberGrade">N° del grado*</label>
            <input type="number" id="txtNumberGrade" name="txtNumberGrade" min="1" max="6" value="{{$tGrade->numberGrade}}" class="form-control" autocomplete="off">
        </div>
        <div class="form-group col-md-8">
            <label for="selectNameGrade">Nombre completo del curso*</label>
            <select name="selectNameGrade" id="selectNameGrade" style="width: 100%" class="form-control">
                <option value="Primaria" {{$tGrade->nameGrade=='Primaria' ? 'selected' : ''}}>Primaria</option>
                <option value="Secundaria" {{$tGrade->nameGrade=='Secundaria' ? 'selected' : ''}}>Secundaria</option>
            </select>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {{csrf_field()}}
            <input type="hidden" name="hdIdGrade" id="hdIdGrade" value="{{$tGrade->idGrade}}">
            <input type="button" class="btn btn-default pull-left" data-dismiss="modal" value="Cerrar ventana">
            <input type="button" class="btn btn-primary" value="Guardar cambios" onclick="sendFrmEditGrade();">
        </div>
    </div>
</form>
<script src="{{asset('assets/backoffice/viewResources/grade/edit.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
