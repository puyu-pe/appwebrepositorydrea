@extends('dashboard.layout')
@section('title', 'Lista de usuarios del sistema')
@section('generalBody')
<div class="nav-tabs-custom">
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1-1">
            <div id="divSearch" class="row">
                <div class="form-group col-md-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </div>
                        <input type="text" id="txtSearch" name="txtSearch" class="form-control pull-right" placeholder="Información para búsqueda (Enter)" autofocus onkeyup="searchUser(this.value, '{{url('usuario/mostrar/1')}}', event);" value="{{$searchParameter}}" autocomplete="off">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    {!!ViewHelper::renderPagination('usuario/mostrar', $quantityPage, $currentPage, $searchParameter)!!}
                </div>
            </div>
            <div class="table-responsive">
                <table id="tableUser" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Avatar</th>
                            <th class="text-center">N° de DNI</th>
                            <th class="text-center">Nombres y Apellidos</th>
                            <th class="text-center">Correo electrónico</th>
                            <th class="text-center">Rol(es)</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Fecha y hora registro</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listTUser as $value)
                            <tr>
                                <td class="text-center" style="width: 80px;">
                                    <div class="user-panel">
                                        <div class="pull-left image">
                                            <img src="{{$value->avatarExtension=='' ?
                                                asset('img/userlogo.png') :
                                                asset('img/avatar/user/'.$value->idUser.'.'.$value->avatarExtension.'?x='.$value->updated_at)}}" class="img-circle" alt="User Image">
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->numberDni}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->firstName.' '.$value->surName}}</div>
                                </td>
                                <td class="text-center">
                                    <div>{{$value->email}}</div>
                                </td>
                                <td class="text-center">
                                    @if ($value->roles!='')
                                        @foreach(explode(',', $value->roles) as $item)
                                            <span class="label label-default">{{$item}}</span>
                                        @endforeach
                                    @else
                                        <div>Sin asignar</div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="label label-{{$value->state=='Habilitado' ? 'info' : 'danger'}}">{{$value->state}}</span>
                                </td>
                                <td class="text-center">
                                    <div>{{date('d-m-Y', strtotime($value->created_at))}}</div>
                                    <div>{{date('g:i A', strtotime($value->created_at))}}</div>
                                </td>
                                <td class="text-center" style="width: 100px;">
                                    @if (stristr($value->roles, 'Administrador') == false)
                                        <span class="btn {{$value->state=='Habilitado' ? 'btn-danger' : 'btn-success'}} btn-xs glyphicon glyphicon glyphicon-user" data-toggle="tooltip" title="{{$value->state=='Habilitado' ? 'Desabilitar' : 'Habilitar'}} Acceso" data-placement="left" onclick="confirmDialog(function(){ $('#modalLoading').modal('show'); window.location.href='{{url('usuario/estado/'.$value->idUser)}}'; });"></span>
                                        <span class="btn btn-info btn-xs glyphicon glyphicon-repeat" data-toggle="tooltip" title="Cambiar rol" data-placement="left" onclick="ajaxDialog('divGeneralContainer', 'modal-xs', 'Modificar rol del usuario {{$value->firstName.' '.$value->surName}}', {_token: '{{csrf_token()}}', idUser: '{{$value->idUser}}'}, '{{url('usuario/rol')}}', 'POST', null, null, false, true);"></span>
                                        @if ($value->state=='Deshabilitado')
                                            <span class="btn btn-warning btn-xs glyphicon glyphicon-trash" data-toggle="tooltip" title="Eliminar Usuario" data-placement="left" onclick="confirmDialog(function(){ $('#modalLoading').modal('show'); window.location.href='{{url('usuario/eliminar/'.$value->idUser)}}'; });"></span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('viewResources/user/getall.js?x='.env('CACHE_LAST_UPDATE'))}}"></script>
@endsection
