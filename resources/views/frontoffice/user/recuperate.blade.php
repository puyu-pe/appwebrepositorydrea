@extends('frontoffice.layout')
@section('generalBody')

    <!-- breadcrumb-area-start -->
    <div class="it-breadcrumb-area it-breadcrumb-bg"
         data-background="{{asset('assets/frontoffice/img/breadcrumb/breadcrumb.jpg')}}" style="height: 100px">
    </div>
    <!-- breadcrumb-area-end -->
    <div class="it-signup-area pt-120 pb-120">
        <div class="container">
            <div class="it-signup-bg p-relative">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <form id="frmRecuperate" action="{{url('usuario/recuperar')}}" method="post">
                            <div class="it-signup-wrap">
                                <h4 class="it-signup-title">Restablecer contraseña</h4>
                                <div class="it-signup-input-wrap">
                                    <div class="mb-20 form-group has-feedback">
                                        <input type="text" class="form-control" id="txtEmail" name="txtEmail" placeholder="Correo *" onkeyup="onKeyUpPassPassword(event);" autocomplete="off">
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                    <div class="mb-20 form-group has-feedback">
                                        <b> Ingrese su correo electrónico y de en el botón, le enviaremos un link a su correo para que pueda restablercerlo.</b>
                                    </div>
                                </div>
                                <div class="it-signup-btn mb-40">
                                    {{csrf_field()}}
                                    <button class="it-btn large" onclick="sendFrmRecuperate();">Enviar link</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('js/codideepHelpers.js')}}"></script>
    <script src="{{asset('assets/backoffice/plugins/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{asset('assets/backoffice/plugins/formvalidation/bootstrap.validation.min.js')}}"></script>
    <script src="{{asset('assets/frontoffice/viewResources/user/recuperate.js')}}?x={{env('CACHE_LAST_UPDATE')}}"></script>
@endsection
