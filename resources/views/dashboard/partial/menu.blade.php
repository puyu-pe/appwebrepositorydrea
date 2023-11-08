<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree" style="background-color: #000000;">
    <li class="header">Menú de navegación</li>
    <li id="mDashboard" class="{{Session::get('menu')=='mDashboard' ? 'active' : ''}}">
        <a href="{{url('/panel')}}">
            <i class="fa fa-dashboard"></i>
            <span>Menú de inicio</span>
        </a>
    </li>
    <li>
        <a href="{{url('/')}}">
            <i class="fa fa-home"></i>
            <span>Página de inicio</span>
        </a>
    </li>
    @if (stristr(Session::get('roleUser'), 'Administrador')==true)
        <li id="mUser" class="{{Session::get('menu')=='mUser' ? 'active' : ''}} treeview">
            <a href="#">
                <i class="fa fa-user"></i>
                <span>Módulo de usuarios</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li id="mGetAllUser" class="{{Session::get('subMenu')=='mGetAllUser' ? 'active' : ''}}"><a href="{{url('usuario/mostrar/1')}}"><i class="fa fa-circle-o"></i>Usuarios del sistema</a></li>
            </ul>
        </li>
    @endif
    @if (stristr(Session::get('roleUser'), 'Administrador')==true || stristr(Session::get('roleUser'), 'Supervisor')==true)
        <li id="mPrincipal" class="{{Session::get('menu')=='mPrincipal' ? 'active' : ''}} treeview">
            <a href="#">
                <i class="fa fa-book"></i>
                <span>Módulo de pruebas</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li id="mGetAllTypeExam" class="{{Session::get('subMenu')=='mGetAllTypeExam' ? 'active' : ''}}"><a href="{{url('tipoexamen/mostrar/1')}}"><i class="fa fa-circle-o"></i>Tipos de prueba</a></li>
                <li id="mGetAllSubject" class="{{Session::get('subMenu')=='mGetAllSubject' ? 'active' : ''}}"><a href="{{url('curso/mostrar/1')}}"><i class="fa fa-circle-o"></i>Materias</a></li>
                <li id="mGetAllGrade" class="{{Session::get('subMenu')=='mGetAllGrade' ? 'active' : ''}}"><a href="{{url('grado/mostrar/1')}}"><i class="fa fa-circle-o"></i>Grados académicos</a></li>
                <li id="mInsertExam" class="{{Session::get('subMenu')=='mInsertExam' ? 'active' : ''}}"><a href="{{url('examen/insertar')}}"><i class="fa fa-circle-o"></i>Registrar</a></li>
                <li id="mGetAllExam" class="{{Session::get('subMenu')=='mGetAllExam' ? 'active' : ''}}"><a href="{{url('examen/mostrar/1')}}"><i class="fa fa-circle-o"></i>Lista de evaluaciones</a></li>
                <li id="mGetAllContact" class="{{Session::get('subMenu')=='mGetAllContact' ? 'active' : ''}}"><a href="{{url('contacto/mostrar/1')}}"><i class="fa fa-circle-o"></i>Lista de mensajes</a></li>
            </ul>
        </li>
    @endif
    @if (stristr(Session::get('roleUser'), 'Administrador')==true)
        <li id="mSetting" class="{{Session::get('menu')=='mSetting' ? 'active' : ''}} treeview">
            <a href="#">
                <i class="fa fa-cog"></i>
                <span>Módulo Administrador</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li id="mBackupSystem" class="{{Session::get('subMenu')=='mBackupSystem' ? 'active' : ''}}"><a href="{{url('sistema/generarbackup')}}"><i class="fa fa-circle-o"></i>Backup de datos</a></li>
                <li id="mDownloadExam" class="{{Session::get('subMenu')=='mDownloadExam' ? 'active' : ''}}"><a href="{{url('sistema/descargar')}}"><i class="fa fa-circle-o"></i>Backup de evaluaciones</a></li>
            </ul>
        </li>
    @endif
</ul>

