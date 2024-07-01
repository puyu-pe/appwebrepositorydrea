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
                <div class="it-signup-thumb d-none d-lg-block">
                    <img src="{{ asset('assets/frontoffice/img/testimonial/thumb-2.png') }}" alt="" width="660" height="738">
                </div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <form id="frmLogin" action="{{url('usuario/acceder')}}" method="post">
                            <div class="it-signup-wrap">
                                <h4 class="it-signup-title">Acceder</h4>
                                <div class="it-signup-input-wrap">
                                    <div class="mb-20 form-group has-feedback">
                                        <input type="text" class="form-control" id="txtEmail" name="txtEmail" placeholder="Correo *">
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                    <div class="mb-20 form-group has-feedback">
                                        <input type="password" id="passPassword" name="passPassword"  placeholder="Contraseña *" onkeyup="onKeyUpPassPassword(event);">
                                    </div>
                                </div>
                                <div class="it-signup-forget d-flex justify-content-between flex-wrap">
                                    <a class="mb-20" href="{{url('usuario/recuperar')}}">Olvidaste la clave</a>
                                    <div class="it-signup-agree mb-20">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Recuerdame
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="it-signup-btn mb-40">
                                    {{csrf_field()}}
                                    <button class="it-btn large" onclick="sendfrmLogin();">Iniciar sesión</button>
                                </div>
                                <div class="it-signup-text">
                                    <span>No tienes una cuenta? <a href="{{url('usuario/registrar')}}">Registrarse</a></span>
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
    <script src="{{asset('assets/frontoffice/viewResources/user/login.js')}}?x={{env('CACHE_LAST_UPDATE')}}"></script>
@endsection
