<form id="frmEditGrade" action="{{url('grado/editar')}}" method="post">
    <div class="row">
        <div class="form-group col-md-4">
            <label for="txtDescriptionGrade">Decripción*</label>
            <input type="text" id="txtDescriptionGrade" name="txtDescriptionGrade" value="{{$tGrade->descriptionGrade}}" class="form-control" autocomplete="off">
        </div>
        <div class="form-group col-md-4">
            <label for="selectNameGrade">Grado académico*</label>
            <select name="selectNameGrade" id="selectNameGrade" style="width: 100%" class="form-control">
                <option value="Primaria" {{$tGrade->nameGrade=='Primaria' ? 'selected' : ''}}>Primaria</option>
                <option value="Secundaria" {{$tGrade->nameGrade=='Secundaria' ? 'selected' : ''}}>Secundaria</option>
                <option value="Inicial" {{$tGrade->nameGrade=='Inicial' ? 'selected' : ''}}>Inicial</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="txtCodeGrade">Código*</label>
            <input type="text" id="txtCodeGrade" name="txtCodeGrade" class="form-control" autocomplete="off" value="{{$tGrade->codeGrade}}">
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
