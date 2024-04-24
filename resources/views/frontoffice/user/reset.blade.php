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
                        <form id="frmReset" action="{{url('usuario/resetear/'.$token)}}" method="post">
                            <div class="it-signup-wrap">
                                <h4 class="it-signup-title">Restablecer la contraseña</h4>
                                <div class="it-signup-input-wrap">
                                    <div class="mb-20 form-group has-feedback">
                                        <input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="Correo electrónico*" value="{{$tUser->email}}" disabled>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                    <div class="mb-20 form-group has-feedback">
                                        <input type="password" id="passPasswordUser" name="passPasswordUser" placeholder="Nueva contraseña*">
                                    </div>
                                    <div class="mb-20 form-group has-feedback">
                                        <input type="password" id="passPasswordRetypeUser" name="passPasswordRetypeUser" placeholder="Repita la nueva contraseña*">
                                    </div>
                                </div>
                                <div class="it-signup-btn mb-40">
                                    {{csrf_field()}}
                                    <input type="hidden" name="hdIdUser" id="hdIdUser" value="{{$tUser->idUser}}">
                                    <button class="it-btn large" onclick="sendfrmReset();">Guardar cambios</button>
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
    <script src="{{asset('assets/frontoffice/viewResources/user/reset.js')}}?x={{env('CACHE_LAST_UPDATE')}}"></script>
@endsection
