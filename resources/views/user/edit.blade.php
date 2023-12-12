@extends('template.layout')
@section('title', 'Perfil del Usuario')
@section('generalBody')
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Datos Generales</a></li>
        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Datos del Usuario</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <form id="frmEditUserProfile" action="{{url('usuario/editar')}}" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            <img src="{{Session::get('avatarExtension')=='' ?
                            asset('img/userlogo.png') :
                            asset('img/logo/user/'.Session::get('idUser').'.'.Session::get('avatarExtension').'?x='.Session::get('updated_at'))}}" height="140" width="140" style="border: 1px solid #999999;border-radius: 170px;" class="img-circle" alt="User Image">
                        </div>
                    </div>
                    <div class="col-md-9" style="border-left: 1px solid #999999;">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="txtFirstNameUser">Nombres</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-i-cursor"></i>
                                    </div>
                                    <input type="text" id="txtFirstNameUser" name="txtFirstNameUser" value="{{Session::get('firstName')}}" class="form-control pull-right">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="txtSurNameUser">Apellidos</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-i-cursor"></i>
                                    </div>
                                    <input type="text" id="txtSurNameUser" name="txtSurNameUser" value="{{Session::get('surName')}}" class="form-control pull-right">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="txtDniUser">N° de DNI</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-keyboard-o"></i>
                                    </div>
                                    <input type="text" id="txtDniUser" name="txtDniUser" value="{{Session::get('numberDni')}}" class="form-control pull-right">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="fileAvatarExtension">Cambiar el Avatar</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-image"></i>
                                    </div>
                                    <input type="file" id="fileAvatarExtension" name="fileAvatarExtension" class="form-control pull-right" accept=".jpg,.png,.jpeg" style="padding: 5px;">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="txtCreated_at">Rol(es)*</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-keyboard-o"></i>
                                    </div>
                                    <input type="text" id="txtCreasted_at" name="txtCreated_at" value="{{Session::get('roleUser')}}" class="form-control pull-right" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row" >
                    <div class="form-group col-md-12 text-right">
                        {{csrf_field()}}
                        <input type="hidden" id="hdIdUser" name="hdIdUser" value="{{Session::get('idUser')}}">
                        <input type="button" class="btn btn-primary" value="Guardar Cambios" onclick="sendFrmEditUserProfile();">
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane" id="tab_2">
            <form id="frmEditUser" action="{{url('usuario/cambiar')}}" method="post">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="txtEmailUser">Correo Electrónico*</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-envelope-o"></i>
                            </div>
                            <input type="text" id="txtEmailUser" name="txtEmailUser" value="{{Session::get('email')}}" class="form-control pull-right">
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="passPasswordUser">Nueva Contraseña</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-lock"></i>
                            </div>
                            <input type="password" id="passPasswordUser" name="passPasswordUser" class="form-control pull-right">
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="passPasswordRetypeUser">Repita Nueva Contraseña</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-lock"></i>
                            </div>
                            <input type="password" id="passPasswordRetypeUser" name="passPasswordRetypeUser" class="form-control pull-right">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row" >
                    <div class="form-group col-md-12 text-right">
                        {{csrf_field()}}
                        <input type="hidden" id="hdIdUserValue" name="hdIdUserValue" value="{{Session::get('idUser')}}">
                        <input type="button" class="btn btn-primary" value="Guardar Cambios" onclick="sendFrmEditUser();">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{asset('viewResources/user/edit.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
