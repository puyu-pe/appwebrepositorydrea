@extends('frontoffice.layout')
@section('title', 'Formulario de contacto')
@section('generalBody')

    <!-- breadcrumb-area-start -->
    <div class="it-breadcrumb-area it-breadcrumb-bg"
         data-background="{{asset('assets/frontoffice/img/breadcrumb/breadcrumb.jpg')}}">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="it-breadcrumb-content z-index-3 text-center">
                        <div class="it-breadcrumb-title-box">
                            <h3 class="it-breadcrumb-title">Opiniones</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area-end -->
    <div class="it-contact__area pt-120 pb-120">
        <div class="container">
            <div class="it-contact__wrap fix z-index-3 p-relative">
                <div class="it-contact__shape-1 d-none d-xl-block">
                    <img src="{{asset('assets/frontoffice/img/contact/shape-2-1.png')}} " alt="">
                </div>
                <div class="row align-items-end">
                    <div class="col-xl-3"></div>
                    <div class="col-xl-9">
                        <div class="it-contact__form-box">
                            <form id="frmTestimony" action="{{url('general/opinion')}}" method="post">
                                <div class="row">
                                    <div class="it-contact__right-box">
                                        <div class="it-contact__section-box pb-20">
                                            <h4 class="it-contact__title pb-15">Registre su opinión</h4>
                                            <p>Estamos para mejorar, ¡no dudes en dejar una sugerencia al repositorio!</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-25">
                                        <div class="it-contact-input-box">
                                            <label for="txtfirstName">Nombre *</label>
                                            <input type="text" id="txtfirstName" name="txtfirstName"
                                                   class="form-control pull-right"
                                                   placeholder="Nombre *"
                                                   value="{{Session::has('firstName') ? Session::get('firstName') : ''}}"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-25">
                                        <div class="it-contact-input-box">
                                            <label for="txtsurName">Apellido *</label>
                                            <input type="text" id="txtsurName" name="txtsurName"
                                                   class="form-control pull-right"
                                                   placeholder="Apellido *"
                                                   value="{{Session::has('surName') ? Session::get('surName') : ''}}"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-25">
                                        <div class="it-contact-input-box">
                                            <label for="txtAcademicLevel">Nivel académico</label>
                                            <input type="text" id="txtAcademicLevel" name="txtAcademicLevel"
                                                   class="form-control pull-right"
                                                   placeholder="Nivel académico">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-25">
                                        <div class="it-contact-input-box">
                                            <label for="txtPlaceOrigin">Lugar de procedencia *</label>
                                            <input type="text" id="txtPlaceOrigin" name="txtPlaceOrigin"
                                                   class="form-control pull-right"
                                                   placeholder="Lugar de procedencia *" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-25">
                                        <div class="it-contact-textarea-box">
                                            <label for="txtDescription">Mensaje *</label>
                                            <textarea id="txtDescription" name="txtDescription" class="form-control"
                                                      placeholder="Mensaje que desea dejar *" cols="20"
                                                      onkeyup="lineJumpTextArea(this, true, true, event);"
                                                      data-fv-field="txtDescription"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 text-right">
                                        {{csrf_field()}}
                                        <input type="button" class="it-btn" value="Registrar opinión"
                                               onclick="sendFrmTestimony();">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/frontoffice/viewResources/testimony/insert.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
