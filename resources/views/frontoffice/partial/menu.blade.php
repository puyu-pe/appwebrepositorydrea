<div id="header-sticky" class="it-header-2-area it-header-3-style it-header-5-style">
    <div class="container">
        <div class="it-header-2-plr">
            <div class="it-header-wrap p-relative">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-6">
                        <div class="it-header-2-logo">
                            <a href="{{url('/')}}"><img src="{{asset('img/logo.png')}}" alt="logo"></a>
                        </div>
                    </div>
                    <div class="col-xl-7 d-none d-xl-block">
                        <div class="it-header-2-main-menu">
                            <nav class="it-menu-content">
                                <ul>
                                    <li id="mTemplate" class="{{Session::get('menu')=='mTemplate' ? 'active' : ''}}"><a
                                            href="{{url('/')}}">Inicio</a></li>
                                    <li id="mTypeExam"
                                        class="has-dropdown {{Session::get('menu')=='mTypeExam' ? 'active' : ''}}">
                                        <a href="#">Tipos de pruebas</a>
                                        <ul class="it-submenu submenu">
                                            @foreach ($menuTypeExamItem as $item)
                                                <li id="{{'m'.strtoupper($item->acronymTypeExam)}}"
                                                    class="{{Session::get('subMenu')=='m'.strtoupper($item->acronymTypeExam) ? 'active' : ''}}">
                                                    <a href="{{url('tipoexamen/'.$item->acronymTypeExam.'/1')}}">Pruebas
                                                        {{strtoupper($item->acronymTypeExam)}}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li id="mContact" class="{{Session::get('menu')=='mContact' ? 'active' : ''}}"><a
                                            href="{{url('general/contacto')}}">Consultas</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-xl-2 col-6">
                        <div class="it-header-2-right d-flex align-items-center justify-content-end">
                            <div class="it-header-2-button d-none d-md-block">
                                <a class="it-btn-white" href="{{url('usuario/acceder')}}">
                                <span>
                                    @if (Session::get('firstName'))
                                        {{substr(Session::get('firstName'), 0, 8)}}
                                        <i class="fa fa-user"></i>
                                    @else
                                        Acceder
                                        <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11 1.24023L16 7.24023L11 13.2402" stroke="currentcolor"
                                                  stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M1 7.24023H16" stroke="currentcolor" stroke-width="1.5"
                                                  stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    @endif
                                </span>
                                </a>
                            </div>
                            <div class="it-header-2-bar d-xl-none">
                                <button class="it-menu-bar"><i class="fa-solid fa-bars"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
