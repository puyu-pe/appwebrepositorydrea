<ul class="nav navbar-nav">
    <li id="mTemplate" class="{{Session::get('menu')=='mTemplate' ? 'active' : ''}}"><a href="{{url('/')}}">Inicio</a></li>
    <li id="mTypeExam" class="dropdown {{Session::get('menu')=='mTypeExam' ? 'active' : ''}}">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pruebas <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            @foreach ($menuTypeExamItem as $item)
                <li id="{{'m'.strtoupper($item->acronymTypeExam)}}" class="{{Session::get('subMenu')=='m'.strtoupper($item->acronymTypeExam) ? 'active' : ''}}"><a href="{{url('tipoexamen/'.$item->acronymTypeExam.'/1')}}">Pruebas {{strtoupper($item->acronymTypeExam)}}</a></li>
            @endforeach
        </ul>
    </li>
    @if (stristr(Session::get('roleUser'), 'Administrador')==true || stristr(Session::get('roleUser'), 'Registrador')==true)
        <li id="mModuleExam" class="dropdown {{Session::get('menu')=='mModuleExam' ? 'active' : ''}}">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Opciones para pruebas<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li id="mRegisterExam" class="{{Session::get('subMenu')=='mRegisterExam' ? 'active' : ''}}"><a href="{{url('examen/registrar')}}">Registrar una evaluación</a></li>
            </ul>
        </li>
    @endif
    <li id="mContact" class="{{Session::get('menu')=='mContact' ? 'active' : ''}}"><a href="{{url('general/contacto')}}">Contáctanos</a></li>
</ul>
