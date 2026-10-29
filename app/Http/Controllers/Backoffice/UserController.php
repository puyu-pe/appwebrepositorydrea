<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Mail\Notification;
use App\Mail\ResetPassword;
use App\Models\TResetPassword;
use App\Models\TRole;
use App\Validation\UserValidation;

use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

use App\Models\TUser;
use App\Models\TUserRole;
use Illuminate\Support\Facades\Mail;
use function Symfony\Component\String\s;

class UserController extends Controller
{
    public function actionGetAll(Request $request, $currentPage=1)
    {
        $searchParameter = $request->has('searchParameter') ? $request->input('searchParameter') : '';

        $paginate = PlatformHelper::preparePaginate(TUser::select('tuser.*', DB::raw($this->roleAggregateExpression()))
            ->leftJoin('tuserrole', 'tuser.idUser', '=', 'tuserrole.idUser')
            ->leftJoin('trole', 'tuserrole.idRole', '=', 'trole.idRole')
            ->groupBy('tuser.idUser')->whereRaw('compareFind(concat(tuser.email, tuser.numberDni, tuser.firstName, tuser.surName, tuser.state), ?, 77)=1 AND tuser.idUser!=?', [$searchParameter, session('idUser')])->orderby('tuser.created_at', 'desc'), 7, $currentPage);

        $viewData=[
            'listTUser' => $paginate['listRow'],
            'currentPage' => $paginate['currentPage'],
            'quantityPage' => $paginate['quantityPage'],
            'searchParameter' => $searchParameter
        ];

        if($request->ajax())
        {
            return view('backoffice/user/_list', $viewData);
        }

        return view('backoffice/user/getall', $viewData);
    }

    public function actionLogout(SessionManager $sessionManager)
    {
        $sessionManager->flush();

        return PlatformHelper::redirectCorrect(['Sesión cerrada correctamente.'], '/');
    }

    public function actionChangeStatus($idUser)
    {
        try {
            DB::beginTransaction();

            $tUser = TUser::find($idUser);

            if($tUser==null)
            {
                DB::rollBack();

                return PlatformHelper::ajaxDataNoExists();
            }

            $tUserRole = TUserRole::whereRaw('idUser=?', [$tUser->idUser])->exists();

            $valueStatus = $tUser->state;

            if ($valueStatus == 'Deshabilitado' && $tUserRole == false) {
                DB::rollBack();

                return PlatformHelper::redirectError(['Asigne al menos un rol al usuario para poder habilitar su acceso.'], 'usuario/listar');
            }

            $tUser->state = $valueStatus == 'Habilitado' ? 'Deshabilitado' : 'Habilitado';

            $tUser->save();

            DB::commit();

            return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'usuario/listar');
        } catch (\Exception $e) {
            DB::rollBack();

            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'usuario/listar');
        }
    }

    public function actionDelete($idUser)
    {
        try {
            $tUser = TUser::find($idUser);

            if($tUser==null)
            {
                return PlatformHelper::ajaxDataNoExists();
            }

            $directoryFiles = storage_path('app/public/user/' . $tUser->idUser . '.' . $tUser->avatarExtension);

            if ($tUser->avatarExtension != '' && file_exists($directoryFiles)) {
                unlink($directoryFiles);
            }

            DB::delete('delete from tuser where idUser = ?', [$idUser]);

            return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'usuario/listar');
        }
        catch (\Exception $e) {
            DB::rollBack();

            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'usuario/listar');
        }
    }

    public function actionChangeRole(Request $request)
    {
        if ($request->has('HdIdUser')) {
            try {
                DB::beginTransaction();

                $tRole = TRole::find($request->input('selectRoleUser'));
                $tRoleUserExists = TUserRole::whereRaw('idUser=?', [$request->input('HdIdUser')])->exists();

                if ($tRoleUserExists == true) {
                    $tUserRole = TUserRole::whereRaw('idUser=?', [$request->input('HdIdUser')])->first();

                    $tUserRole->idRole = $tRole->idRole;

                    $tUserRole->save();
                } else {
                    $tUserRole = new TUserRole();

                    $tUserRole->idUserRole = uniqid();
                    $tUserRole->idUser = $request->input('HdIdUser');
                    $tUserRole->idRole = $request->input('selectRoleUser');

                    $tUserRole->save();
                }

                DB::commit();

                return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'usuario/listar');

            } catch (\Exception $e) {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'usuario/listar');
            }
        }

        $tUser = TUser::find($request->input('idUser'));
        $tUserRole = TUserRole::where('idUser', $tUser->idUser)->pluck('idRole')->toArray();
        $tRole = TRole::all();

        if ($tUser == null && $tRole == null) {
            return PlatformHelper::ajaxDataNoExists();
        }

        return view('backoffice/user/role',
        [
            'tRole' => $tRole,
            'tUser' => $tUser,
            'tUserRole' => $tUserRole
        ]);
    }

    private function roleAggregateExpression()
    {
        return DB::connection()->getDriverName()=='sqlite'
            ? "GROUP_CONCAT(trole.nameRole, ',') as roles"
            : "GROUP_CONCAT(trole.nameRole SEPARATOR ',') as roles";
    }
}
