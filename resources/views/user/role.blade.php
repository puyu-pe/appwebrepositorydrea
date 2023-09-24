<form id="frmChangeUser" action="{{url('usuario/rol')}}" method="post">
    <div class="row">
        <div class="form-group col-md-12">
            <label for="selectRoleUser">Roles a Asignar*</label>
            <select name="selectRoleUser[]" id="selectRoleUser" class="form-control select2Role" multiple="multiple" data-placeholder="Selecciona el rol..." style="width: 100%;">
                <option value=""></option>
                <option value="Administrador" {{stristr($tUser->roleUser, 'Administrador')==true ? 'selected' : ''}}>Administrador</option>
                <option value="Registrador" {{stristr($tUser->roleUser, 'Registrador')==true ? 'selected' : ''}}>Registrador</option>
                <option value="Normal" {{stristr($tUser->roleUser, 'Normal')==true ? 'selected' : ''}}>Normal</option>
            </select>
        </div>
    </div>
    <hr>
    <div class="row form-group col-md-12 justify-content-between">
        {{csrf_field()}}
        <input type="hidden" id="HdIdUser" name="HdIdUser" value="{{$tUser->idUser}}">
        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cerrar Ventana">
        <input type="button" class="btn btn-primary" value="Guardar cambios" onclick="sendFrmChangeUser();">
    </div>
</form>
<script src="{{asset('viewResources/user/role.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
