<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <img src="{{Session::get('avatarExtension')=='' ?
                      asset('img/userlogo.png') :
                      asset('storage/user/'.Session::get('idUser').'.'.Session::get('avatarExtension').'?x='.Session::get('updated_at'))}}" class="user-image" alt="User Image">
        <span class="hidden-xs">{{Session::get('firstName').' '.Session::get('surName')}}</span>
    </a>
    <ul class="dropdown-menu">
      <!-- User image -->
      <li class="user-header" style="background-color: #000000;">
        <img src="{{Session::get('avatarExtension')=='' ?
                      asset('img/userlogo.png') :
                      asset('storage/user/'.Session::get('idUser').'.'.Session::get('avatarExtension').'?x='.Session::get('updated_at'))}}" class="img-circle" alt="User Image">
        <p>
          {{Session::get('firstName').' '.Session::get('surName')}}
          <small>{{Session::get('email')}}</small>
          <small>{{Session::get('role')}}</small>
        </p>
      </li>
      <li class="user-body" style="background-color: #ffffff">
        <div class="row">
          <div class="col-xs-12 text-center">
            Panel General del Sistema
          </div>
        </div>
      </li>
      <!-- Menu Footer-->
      <li class="user-footer">
        <div class="pull-left">
            <a href="{{url('usuario/editar/')}}" class="btn btn-default btn-flat">Mi Perfil</a>
        </div>
        <div class="pull-right">
            <a href="{{url('usuario/salir')}}" class="btn btn-default btn-flat">Salir</a>
        </div>
      </li>
    </ul>
  </li>
