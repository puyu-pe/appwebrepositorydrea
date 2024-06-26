@extends('frontoffice.layout')
@section('title', 'Perfil del Usuario')
@section('generalBody')

    <!-- breadcrumb-area-start -->
    <div class="it-breadcrumb-area it-breadcrumb-bg"
         data-background="{{asset('assets/frontoffice/img/breadcrumb/breadcrumb.jpg')}}">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="it-breadcrumb-content z-index-3 text-center">
                        <div class="it-breadcrumb-title-box">
                            <h3 class="it-breadcrumb-title">Mis datos</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area-end -->

    <div class="it-teacher-details-area pt-120 pb-120">
        <div class="container">

            <div class="it-course-details-nav pb-60">
                <nav>
                    <div class="nav nav-tab" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                aria-selected="true">Datos generales
                        </button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                                type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Datos de
                            usuario
                        </button>
                    </div>
                </nav>
            </div>
            <div class="it-course-details-content">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="it-course-details-wrapper">
                            <div class="it-evn-details-text mb-40">
                                <div class="it-teacher-details-wrap">
                                    <form id="frmEditUserProfile" action="{{url('usuario/editar')}}" method="post"
                                          enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-3">
                                                <h3>Imagen</h3>
                                                <div class="it-teacher-details-left">
                                                    <div class="it-teacher-details-left-thumb">
                                                        <img src="{{Session::get('avatarExtension')=='' ?
                            asset('img/userlogo.png') :
                            asset('storage/user/'.Session::get('idUser').'.'.Session::get('avatarExtension').'?x='.Session::get('updated_at'))}}"
                                                             style="border: 1px solid #999999; border-radius: 50%; width: 150px; "
                                                             class="img-circle" alt="User Image">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-9 col-lg-9">
                                                <div class="checkbox-form">
                                                    <h3>Datos generales</h3>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="checkout-form-list">
                                                                <label>Nombres <span class="required">*</span></label>
                                                                <input type="text" placeholder="Nombres"
                                                                       value="{{Session::get('firstName')}}"
                                                                       id="txtFirstNameUser" name="txtFirstNameUser">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="checkout-form-list">
                                                                <label>Apellidos <span class="required">*</span></label>
                                                                <input type="text" placeholder="Apellido"
                                                                       value="{{Session::get('surName')}}"
                                                                       id="txtSurNameUser" name="txtSurNameUser">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="checkout-form-list">
                                                                <label>Avatar</label>
                                                                <input type="file" id="fileAvatarExtension" name="fileAvatarExtension" class="form-control pull-right" accept=".jpg,.png,.jpeg" style="padding: 5px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="checkout-form-list">
                                                                <label>DNI <span class="required">*</span></label>
                                                                <input type="text" placeholder="DNI"
                                                                       value="{{Session::get('numberDni')}}"
                                                                       id="txtDniUser" name="txtDniUser">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="checkout-form-list">
                                                                <label>Rol(es)<span class="required"></span></label>
                                                                <input type="text" placeholder="Roles"
                                                                       id="txtCreated_at"
                                                                       name="txtCreated_at"
                                                                       value="{{Session::get('roleUser')}}"
                                                                       class="form-control pull-right" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="form-group col-md-12 text-right">
                                                                {{csrf_field()}}
                                                                <input type="hidden" id="hdIdUser" name="hdIdUser"
                                                                       value="{{Session::get('idUser')}}">
                                                                <input type="button" class="it-btn"
                                                                       value="Guardar Cambios"
                                                                       onclick="sendFrmEditUserProfile();">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="it-course-details-wrapper">
                            <div class="it-evn-details-text mb-40">
                                <div class="it-teacher-details-wrap">
                                    <form id="frmEditUser" action="{{url('usuario/cambiar')}}" method="post">
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-3">
                                            </div>
                                            <div class="col-xl-9 col-lg-9">
                                                <div class="checkbox-form">
                                                    <h3>
                                                        <label>Datos de usuario</label>
                                                    </h3>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="checkout-form-list">
                                                                <label>Correo Electrónico <span
                                                                        class="required">*</span></label>
                                                                <input id="txtEmailUser" name="txtEmailUser"
                                                                       value="{{Session::get('email')}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="checkout-form-list">
                                                                <label>Nueva Contraseña <span class="required">*</span></label>
                                                                <input type="password" id="passPasswordUser"
                                                                       name="passPasswordUser"
                                                                       class="form-control pull-right">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="checkout-form-list">
                                                                <label>Repita Contraseña <span class="required">*</span></label>
                                                                <input type="password" id="passPasswordRetypeUser"
                                                                       name="passPasswordRetypeUser"
                                                                       class="form-control pull-right">
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-12 text-right">
                                                            {{csrf_field()}}
                                                            <input type="hidden" id="hdIdUserValue" name="hdIdUserValue"
                                                                   value="{{Session::get('idUser')}}">
                                                            <input type="button" class="it-btn" value="Guardar Cambios"
                                                                   onclick="sendFrmEditUser();">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="{{asset('assets/frontoffice/viewResources/user/edit.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
