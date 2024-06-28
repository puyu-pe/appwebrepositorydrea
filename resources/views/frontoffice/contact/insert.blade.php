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
                            <h3 class="it-breadcrumb-title">Consultas</h3>
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
                    <div class="col-xl-7">
                        <div class="it-contact__right-box">
                            <div class="it-contact__section-box pb-20">
                                <h4 class="it-contact__title pb-15">Mantengámonos en contacto</h4>
                                <p>"Estamos aquí para ayudarte, ¡no dudes en ponerte en contacto con nosotros!"</p>
                            </div>
                            <div class="it-contact__content mb-55">
                                <ul>
                                    <li>
                                        <div class="it-contact__list d-flex align-items-start">
                                            <div class="it-contact__icon">
                                                <span><i class="fa-solid fa-location-dot"></i></span>
                                            </div>
                                            <div class="it-contact__text">
                                                <span>Nuestra dirección</span>
                                                <a href="#"> Av. Pachacutec N° 300 Abancay<br>
                                                    Abancay Apurímac</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="it-contact__list d-flex align-items-start">
                                            <div class="it-contact__icon">
                                                <span><i class="fa-solid fa-clock"></i></span>
                                            </div>
                                            <div class="it-contact__text">
                                                <span>Horarios de atención</span>
                                                <a href="#">Luines - viernes: 9.00am a 5.00pm</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="it-contact__list d-flex align-items-start">
                                            <div class="it-contact__icon">
                                                <span><i class="fa-solid fa-phone phone"></i></span>
                                            </div>
                                            <div class="it-contact__text">
                                                <span>Datos de contacto</span>
                                                <a href="tel:(511) 615-5800">(511) 615-5800</a>
                                                <a>Anexo : 57001</a>
                                                <a href="mailto:informatica.dre@dreapurimac.gob.pe">informatica.dre@dreapurimac.gob.pe</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="it-contact__bottom-box d-flex align-items-center justify-content-between">
                                <div class="it-footer-social">
                                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                    <a href="#"><i class="fa-brands fa-pinterest-p"></i></a>
                                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="it-contact__form-box">
                            <form id="frmContact" action="{{url('general/contacto')}}" method="post">
                                <div class="row">
                                    <div class="col-md-12 mb-25">
                                        <div class="it-contact-input-box">
                                            <label>Nombre*</label>
                                            <input type="text" id="txtFullName" name="txtFullName"
                                                   class="form-control pull-right"
                                                   placeholder="Nombres*"
                                                   value="{{Session::has('firstName') && Session::has('surName') ? Session::get('firstName') . ' ' .Session::get('surName') : ''}}"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-25">
                                        <div class="it-contact-input-box">
                                            <label>Correo *</label>
                                            <input type="text" id="txtEmail" name="txtEmail"
                                                   class="form-control pull-right"
                                                   placeholder="Correo electrónico*"
                                                   value="{{Session::has('email') ? Session::get('email') : ''}}"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-25">
                                        <div class="it-contact-input-box">
                                            <label>Teléfono</label>
                                            <input type="text" id="txtPhone" name="txtPhone"
                                                   placeholder="Teléfono">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-25">
                                        <div class="it-contact-input-box">
                                            <label>Asunto *</label>
                                            <input type="text" id="txtSubject" name="txtSubject"
                                                   class="form-control pull-right"
                                                   placeholder="Asunto*" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-25">
                                        <div class="it-contact-textarea-box">
                                            <label>Mensaje *</label>
                                            <textarea id="txtMessage" name="txtMessage" class="form-control"
                                                      placeholder="Mensaje que desea dejar*" rows="7"
                                                      onkeyup="lineJumpTextArea(this, true, true, event);"
                                                      data-fv-field="txtMessage"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 text-right">
                                        {{csrf_field()}}
                                        <input type="button" class="it-btn" value="Enviar datos"
                                               onclick="sendFrmContact();">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/frontoffice/viewResources/contact/insert.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
