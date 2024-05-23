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
                    <div class="col-xl-6 d-none d-xl-block">
                        <div class="it-header-2-main-menu">
                            <nav class="it-menu-content">
                                <ul>
                                    <li id="mTemplate" class="{{Session::get('menu')=='mTemplate' ? 'active' : ''}}"><a
                                            href="{{url('/')}}">Inicio</a></li>
                                    <li id="mTypeExam"
                                        class="has-dropdown {{Session::get('menu')=='mTypeExam' ? 'active' : ''}}">
                                        <a href="#">Tipos</a>
                                        <ul class="it-submenu submenu">
                                            <li id="mALL"
                                                class="{{Session::get('subMenu')=='mALLTYPE' ? 'active' : ''}}">
                                                <a href="{{url('tipoexamen/all/1')}}">General</a></li>
                                            @foreach ($menuTypeExamItem as $item)
                                            <li id="{{'m'.strtoupper($item->acronymTypeExam)}}"
                                                class="{{Session::get('subMenu')=='m'.strtoupper($item->acronymTypeExam).'TYPE' ? 'active' : ''}}">
                                                <a href="{{url('tipoexamen/'.$item->acronymTypeExam.'/1')}}">
                                                    {{$item->acronymTypeExam != 'other' ? 'Evaluaciones '.strtoupper($item->acronymTypeExam) : 'Otros'}}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li id="mSubject"
                                        class="has-dropdown {{Session::get('menu')=='mSubject' ? 'active' : ''}}">
                                        <a href="#">Cursos</a>
                                        <ul class="it-submenu submenu">
                                            @foreach ($menuSubjectItem as $item_subject)
                                                <li id="{{'m'.strtoupper($item_subject->codeSubject)}}"
                                                    class="{{Session::get('subMenu')=='m'.strtoupper($item_subject->codeSubject).'SUBJECT' ? 'active' : ''}}">
                                                    <a href="{{url('curso/'.$item_subject->codeSubject.'/1')}}">
                                                        {{$item_subject->nameSubject}}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li id="mGrade"
                                        class="has-dropdown {{Session::get('menu')=='mGrade' ? 'active' : ''}}">
                                        <a href="#">Grados</a>
                                        <ul class="it-submenu submenu">
                                            @foreach ($menuGradeItem as $item_grade)
                                                <li id="{{'m'.strtoupper($item_grade->codeGrade)}}"
                                                    class="{{Session::get('subMenu')=='m'.strtoupper($item_grade->codeGrade).'GRADE' ? 'active' : ''}}">
                                                    <a href="{{url('grado/'.$item_grade->codeGrade.'/1')}}">
                                                        {{$item_grade->descriptionGrade}}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li id="mContact" class="{{Session::get('menu')=='mContact' ? 'active' : ''}}"><a
                                            href="{{url('general/contacto')}}">Consultas</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-xl-3 col-6">
                        <div class="it-header-2-right d-flex align-items-center justify-content-end">
                            @if(Session::get('idUser'))
                                <div class="it-header-2-icon">
                                    <a href="{{url('usuario/salir')}}">
                                        <i class="fa fa-user-clock" title="Cerrar sesión"></i>
                                    </a>
                                </div>
                            @endif
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
