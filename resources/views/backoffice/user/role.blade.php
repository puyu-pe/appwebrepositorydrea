<form id="frmChangeUser" action="{{url('usuario/rol')}}" method="post">
    <div class="row">
        <div class="form-group col-md-12">
            <label for="selectRoleUser">Roles a Asignar*</label>
            <select name="selectRoleUser" id="selectRoleUser" class="form-control select2Role" data-placeholder="Selecciona el rol..." style="width: 100%;">
                <option value=""></option>
                @foreach ($tRole as $valueRole)
                   <option value="{{$valueRole->idRole}}" {{in_array($valueRole->idRole, $tUserRole) ? 'selected' : ''}}>{{$valueRole->nameRole}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {{csrf_field()}}
            <input type="hidden" id="HdIdUser" name="HdIdUser" value="{{$tUser->idUser}}">
            <input type="button" class="btn btn-default pull-left" data-dismiss="modal" value="Cerrar ventana">
            <input type="button" class="btn btn-primary" value="Guardar cambios" onclick="sendFrmChangeUser();">
        </div>
    </div>
</form>
<script src="{{asset('viewResources/user/role.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
