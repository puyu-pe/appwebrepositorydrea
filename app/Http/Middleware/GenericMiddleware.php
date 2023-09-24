<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class GenericMiddleware
{
    public function handle($request, Closure $next, ...$params)
    {
        $urlAccess=false;
        $allowUrl=
        [
            ['Público', '/', 'mTemplate', null],
            ['Administrador', 'gym/generate', 'mSetting', 'mBackupSystem'],
            ['Administrador', 'gym/downloadimage', 'mSetting', 'mDownloadImage'],
            ['Administrador,Registrador', 'panel', 'mDashboard', null],

            ['Público', 'usuario/registrar', null, null],
            ['Público', 'usuario/acceder', null, null],
            ['Público', 'usuario/salir', null , null],
            ['Administrador', 'usuario/estado', null , null],
            ['Administrador,Registrador', 'usuario/editar', null, null],
            ['Administrador', 'usuario/mostrar', 'mUser' , 'mGetAllUser'],
            ['Administrador', 'usuario/rol', null , null],
            ['Administrador', 'usuario/eliminar', null , null],
            ['Público', 'usuario/recuperar', null, null],

            ['Administrador,Registrador', 'tipoexamen/mostrar', 'mPrincipal', 'mGetAllTypeExam'],
            ['Administrador,Registrador', 'tipoexamen/insertar', null, null],
            ['Administrador,Registrador', 'tipoexamen/editar', null, null],
            ['Administrador', 'tipoexamen/eliminar', null, null],
            ['Público', 'tipoexamen/acronymTypeExam', 'mTypeExam', null],

            ['Administrador,Registrador', 'curso/mostrar', 'mPrincipal', 'mGetAllSubject'],
            ['Administrador,Registrador', 'curso/insertar', null, null],
            ['Administrador,Registrador', 'curso/editar', null, null],
            ['Administrador', 'curso/eliminar', null, null],

            ['Administrador,Registrador', 'grado/mostrar', 'mPrincipal', 'mGetAllGrade'],
            ['Administrador,Registrador', 'grado/insertar', null, null],
            ['Administrador,Registrador', 'grado/editar', null, null],
            ['Administrador', 'grado/eliminar', null, null],

            ['Administrador,Registrador', 'examen/mostrar', 'mPrincipal', 'mGetAllExam'],
            ['Administrador,Registrador', 'examen/insertar', 'mPrincipal', 'mInsertExam'],
            ['Administrador,Registrador', 'examen/editar', null, null],
            ['Administrador', 'examen/eliminar', null, null],
            ['Público', 'examen/verarchivo', null, null],

            ['Administrador,Registrador', 'cuestionario/registrar', null, null],

        ];

        $myMainRole=Session::get('mainRole', '');

        $myMainRole=($myMainRole=='' ? 'Público' : $myMainRole);

        foreach ($allowUrl as $value)
        {
            if($params[0]==$value[1])
            {
                if($value[0]=='Público')
                {
                    $urlAccess=true;
                    Session::put('menu',$value[2]);
                    Session::put('subMenu',$value[3]);
                    break;
                }
                foreach (explode(',', $value[0]) as $item)
                {
                    if(in_array($item, explode(',', $myMainRole)))
                    {
                        $urlAccess=true;
                        Session::put('menu',$value[2]);
                        Session::put('subMenu',$value[3]);
                        break 2;
                    }
                }
            }
        }
        if(!$urlAccess)
        {
            return redirect('/');
        }
        return $next($request);
    }
}
?>
