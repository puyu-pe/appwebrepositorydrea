<ul class="nav navbar-nav">
    <li id="mTemplate" class="{{Session::get('menu')=='mTemplate' ? 'active' : ''}}"><a href="{{url('/')}}">Inicio</a></li>
    <li id="mTypeExam" class="dropdown {{Session::get('menu')=='mTypeExam' ? 'active' : ''}}">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pruebas <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            @foreach ($menuTypeExamItem as $item)
                <li id="{{'m'.strtoupper($item->acronymTypeExam)}}" class="{{Session::get('submenu')=='m'.strtoupper($item->acronymTypeExam) ? 'active' : ''}}"><a href="{{url('tipoexamen/'.$item->acronymTypeExam.'/1')}}">Pruebas {{strtoupper($item->acronymTypeExam)}}</a></li>
            @endforeach
        </ul>
    </li>
    <li id="mTramiteBuscar" class="{{Session::get('menu')=='mTramiteBuscar' ? 'active' : ''}}"><a href="{{url('general/contactos')}}">Contáctanos</a></li>
</ul>
