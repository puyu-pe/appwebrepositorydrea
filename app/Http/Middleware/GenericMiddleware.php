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
            ['Administrador', 'sistema/generarbackup', 'mSetting', 'mBackupSystem'],
            ['Administrador', 'sistema/descargar', 'mSetting', 'mDownloadExam'],
            ['Administrador,Supervisor', 'panel', 'mDashboard', null],

            ['Público', 'usuario/registrar', null, null],
            ['Público', 'usuario/acceder', null, null],
            ['Público', 'usuario/salir', null , null],
            ['Administrador', 'usuario/estado', null , null],
            ['Administrador,Supervisor,Registrador,Normal', 'usuario/editar', null, null],
            ['Administrador', 'usuario/mostrar', 'mUser' , 'mGetAllUser'],
            ['Administrador', 'usuario/rol', null , null],
            ['Administrador', 'usuario/eliminar', null , null],
            ['Público', 'usuario/recuperar', null, null],

            ['Administrador,Supervisor', 'tipoexamen/mostrar', 'mPrincipal', 'mGetAllTypeExam'],
            ['Administrador,Supervisor', 'tipoexamen/insertar', null, null],
            ['Administrador,Supervisor', 'tipoexamen/editar', null, null],
            ['Administrador', 'tipoexamen/eliminar', null, null],
            ['Público', 'tipoexamen/acronymTypeExam', 'mTypeExam', null],

            ['Administrador,Supervisor', 'curso/mostrar', 'mPrincipal', 'mGetAllSubject'],
            ['Administrador,Supervisor', 'curso/insertar', null, null],
            ['Administrador,Supervisor', 'curso/editar', null, null],
            ['Administrador', 'curso/eliminar', null, null],

            ['Administrador,Supervisor', 'grado/mostrar', 'mPrincipal', 'mGetAllGrade'],
            ['Administrador,Supervisor', 'grado/insertar', null, null],
            ['Administrador,Supervisor', 'grado/editar', null, null],
            ['Administrador', 'grado/eliminar', null, null],

            ['Administrador,Supervisor', 'examen/mostrar', 'mPrincipal', 'mGetAllExam'],
            ['Administrador,Supervisor', 'examen/sinpublicar', 'mPrincipal', 'mGetExamNoPublic'],
            ['Administrador,Supervisor', 'examen/insertar', 'mPrincipal', 'mInsertExam'],
            ['Administrador,Registrador', 'examen/registrar', 'mModuleExam', 'mRegisterExam'],
            ['Administrador,Supervisor', 'examen/editar', null, null],
            ['Administrador,Supervisor', 'examen/estado', null, null],
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
