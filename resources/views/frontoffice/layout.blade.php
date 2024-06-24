<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Repositorio de evaluaciones DRE Apurímac</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Place favicon.ico in the root directory -->
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/dreaapurimac.png')}}">

        <!-- CSS here -->
        <link rel="stylesheet" href="{{asset('assets/frontoffice/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/frontoffice/css/animate.css')}}">
        <link rel="stylesheet" href="{{asset('assets/frontoffice/css/custom-animation.css')}}">
        <link rel="stylesheet" href="{{asset('assets/frontoffice/css/slick.css')}}">
        <link rel="stylesheet" href="{{asset('assets/frontoffice/css/nice-select.css')}}">
        <link rel="stylesheet" href="{{asset('assets/frontoffice/css/flaticon_xoft.css')}}">
        <link rel="stylesheet" href="{{asset('assets/frontoffice/css/swiper-bundle.css')}}">
        <link rel="stylesheet" href="{{asset('assets/frontoffice/css/meanmenu.css')}}">
        <link rel="stylesheet" href="{{asset('assets/frontoffice/css/font-awesome-pro.css')}}">
        <link rel="stylesheet" href="{{asset('assets/frontoffice/css/magnific-popup.css')}}">
        <link rel="stylesheet" href="{{asset('assets/frontoffice/css/spacing.css')}}">
        <link rel="stylesheet" href="{{asset('assets/frontoffice/css/main.css')}}">
        <link rel="stylesheet" href="{{asset('assets/backoffice/plugins/pnotify/pnotify.custom.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/layout.css')}}">
        <link rel="stylesheet" href="{{asset('css/cssPagination.css')}}">
        <link rel="stylesheet" href="{{asset('css/cssExamType.css')}}">

        <script src="{{asset('assets/backoffice/plugins/adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
    </head>
    <body>
        <script>
            $(function()
            {
              @if(Session::has('globalMessage'))
                @if(Session::get('type')=='error' || Session::get('type')=='exception')
                  @foreach(Session::get('globalMessage') as $value)
                    @if(trim($value)!='')
                      new PNotify(
                        {
                          title : 'No se pudo proceder',
                          text : '{{$value}}',
                          type : 'error'
                        });
                    @endif
                  @endforeach
                @else
                    swal(
                      {
                        title: '{{Session::get('type')=='success' ? 'Correcto' : 'Alerta'}}',
                        text: '{!!Session::get('globalMessage')[0]!!}',
                        icon: '{{Session::get('type')}}',
                        timer: '{{Session::get('type')=='success' ? '3000': '8000'}}',
                        html: true
                      });
                @endif
            @endif
            });
          </script>
        <!-- preloader -->
        <div id="preloader">
            <div class="preloader">
                <span></span>
                <span></span>
            </div>
        </div>
         <!-- preloader end  -->
        <!-- back-to-top-start  -->
        <button class="scroll-top scroll-to-target" data-target="html">
            <i class="far fa-angle-double-up"></i>
        </button>
        <!-- back-to-top-end  -->

        <!-- it-offcanvus-area-start -->
        <div class="it-offcanvas-area">
            <div class="itoffcanvas">
                <div class="it-offcanva-bottom-shape d-none d-xxl-block">
                </div>
                <div class="itoffcanvas__close-btn">
                    <button class="close-btn"><i class="fal fa-times"></i></button>
                </div>
                <div class="itoffcanvas__logo">
                    <a href="{{url('/')}}">
                    <img src="{{asset('img/logo.png')}}" alt="">
                    </a>
                </div>
                <div class="itoffcanvas__text">
                    <p>Plataforma web que gestiona las evaluaciones de las DRE/GRE a nivel nacional</p>
                </div>
                <div class="it-menu-mobile"></div>
                <div class="itoffcanvas__info">
                    <h3 class="offcanva-title">Ponte en contacto</h3>
                    <div class="it-info-wrapper mb-20 d-flex align-items-center">
                    <div class="itoffcanvas__info-icon">
                        <a href="#"><i class="fal fa-envelope"></i></a>
                    </div>
                    <div class="itoffcanvas__info-address">
                        <span>Correo : </span>
                        <a href="maito:informatica.dre@dreapurimac.gob.pe">informatica.dre@dreapurimac.gob.pe</a>
                    </div>
                    </div>
                    <div class="it-info-wrapper mb-20 d-flex align-items-center">
                    <div class="itoffcanvas__info-icon">
                        <a href="#"><i class="fal fa-phone-alt"></i></a>
                    </div>
                    <div class="itoffcanvas__info-address">
                        <span>Teléfono Ñ </span>
                        <a href="tel:(00)45611227890">(083) - 321066</a>
                    </div>
                    </div>
                    <div class="it-info-wrapper mb-20 d-flex align-items-center">
                    <div class="itoffcanvas__info-icon">
                        <a href="#"><i class="fas fa-map-marker-alt"></i></a>
                    </div>
                    <div class="itoffcanvas__info-address">
                        <span>Dirección : </span>
                        <a href="htits://www.google.com/maps/@37.4801311,22.8928877,3z" target="_blank">Av. Pachacutec
                            N° 300  Abancay</a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body-overlay"></div>
        <!-- it-offcanvus-area-end -->
        <header>
            <div class="it-header-transparent">
                <!-- header-area-start -->
                @include('frontoffice/partial/menu')
                <!-- header-area-end -->
            </div>
        </header>
        <main>
            @yield('generalBody')
        </main>
        <div id="sfcxj1qp6pmnh94ywf42yyx1xbhn8cbajf3">
        </div>
        <footer>
            <!-- footer-area-start -->
                @include('frontoffice/partial/footer')
            <!-- footer-area-end -->
            <!-- copy-right area start -->
                @include('frontoffice/partial/copy')
            <!-- copy-right area end -->
        </footer>
        <!-- JS here -->
        <script type="text/javascript" src="https://counter4.optistats.ovh/private/counter.js?c=xj1qp6pmnh94ywf42yyx1xbhn8cbajf3&down=async" async></script><noscript><a href="https://www.contadorvisitasgratis.com" title="contador de visitas gratis"><img src="https://counter4.optistats.ovh/private/contadorvisitasgratis.php?c=xj1qp6pmnh94ywf42yyx1xbhn8cbajf3" border="0" title="contador de visitas gratis" alt="contador de visitas gratis"></a></noscript>
        <script src="{{asset('assets/frontoffice/js/waypoints.js')}}"></script>
        <script src="{{asset('assets/frontoffice/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/frontoffice/js/slick.min.js')}}"></script>
        <script src="{{asset('assets/frontoffice/js/magnific-popup.js')}}"></script>
        <script src="{{asset('assets/frontoffice/js/purecounter.js')}}"></script>
        <script src="{{asset('assets/frontoffice/js/wow.js')}}"></script>
        <script src="{{asset('assets/frontoffice/js/countdown.js')}}"></script>
        <script src="{{asset('assets/frontoffice/js/nice-select.js')}}"></script>
        <script src="{{asset('assets/frontoffice/js/swiper-bundle.js')}}"></script>
        <script src="{{asset('assets/frontoffice/js/isotope-pkgd.js')}}"></script>
        <script src="{{asset('assets/frontoffice/js/imagesloaded-pkgd.js')}}"></script>
        <script src="{{asset('assets/frontoffice/js/ajax-form.js')}}"></script>
        <script src="{{asset('assets/frontoffice/js/main.js')}}"></script>
        <script src="{{asset('assets/backoffice/plugins/sweetalert/sweetalert.min.js')}}"></script>
        <script src="{{asset('js/codideepHelpers.js')}}"></script>
        <script src="{{asset('assets/backoffice/plugins/formvalidation/formValidation.min.js')}}"></script>
        <script src="{{asset('assets/backoffice/plugins/formvalidation/bootstrap.validation.min.js')}}"></script>
        <script src="{{asset('assets/backoffice/plugins/pnotify/pnotify.custom.min.js')}}"></script>
        <script src="{{asset('assets/frontoffice/viewResources/template/layout.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
    </body>
</html>
