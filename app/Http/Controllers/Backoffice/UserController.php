<?php
namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Mail\Notification;
use App\Models\TResetPassword;
use App\Models\TRole;
use App\Validation\UserValidation;

use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\TUser;
use App\Models\TUserRole;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    public function actionLogin(Request $request, Encrypter $encrypter, SessionManager $sessionManager)
    {
        if($_POST)
        {
            try
            {
                $this->_so->mo->listMessage=(new UserValidation())->validationLogin($request);

                if($this->_so->mo->existsMessage())
                {
                    return PlatformHelper::redirectError($this->_so->mo->listMessage,'usuario/acceder');
                }

                $tUser=TUser::whereRaw('email=?',[$request->input('txtEmail')])->first();

                if(($tUser==null || ($tUser!=null && $encrypter->decrypt($tUser->password)!=$request->input('passPassword'))))
                {
                    return PlatformHelper::redirectError(['Usuario o Contraseña Incorrecto'],'usuario/acceder');
                }

                if($tUser->state=='Deshabilitado')
                {
                    return PlatformHelper::redirectError(['No tiene Acceso al Sistema'],'usuario/acceder');
                }

                $tUserRole = TUserRole::where('idUser', $tUser->idUser)
                ->join('trole', 'trole.idRole', '=', 'tuserrole.idRole')
                ->pluck('trole.nameRole')
                ->toArray();

                $roleNamesString = implode(',', $tUserRole);

                $sessionManager->put('idUser',$tUser->idUser);
                $sessionManager->put('email',$tUser->email);
                $sessionManager->put('firstName',$tUser->firstName);
                $sessionManager->put('surName',$tUser->surName);
                $sessionManager->put('numberDni',$tUser->numberDni);
                $sessionManager->put('avatarExtension', $tUser->avatarExtension);
                $sessionManager->put('updated_at',$tUser->updated_at);
                $sessionManager->put('roleUser', $roleNamesString);
                $sessionManager->put('mainRole',$roleNamesString);

                return PlatformHelper::redirectCorrect(['Bienvenido al sistema, '.$tUser->firstName.' '.$tUser->surName.'.'],'/');
            }
            catch(\Exception $e)
            {
                return PlatformHelper::catchException(__CLASS__, __FUNCTION__,$e,'usuario/acceder');
            }
        }
        return view('backoffice/user/login');
    }

    public function actionRecuperate(Request $request)
    {
        if($_POST)
        {
            try
            {
                DB::beginTransaction();

                $this->_so->mo->listMessage=(new UserValidation())->validationRecuperate($request);

                if($this->_so->mo->existsMessage())
                {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage,'usuario/recuperar');
                }

                $tUser=TUser::whereRaw('email=?',[$request->input('txtEmail')])->first();

                if(!$tUser)
                {
                    return PlatformHelper::redirectError(['Correo electrónico no encontrado.'],'usuario/recuperar');
                }

                $tResetPasswordExists = TResetPassword::where('idUser', $tUser->idUser)->exists();

                if ($tResetPasswordExists)
                    return PlatformHelper::redirectError(['Ya se solicitó un link para recuperar la contraseña del correo en cuestión.'],'usuario/recuperar');

                $token = Str::random(100);

                $tResetPassword = new TResetPassword();

                $tResetPassword->idResetPassword = uniqid();
                $tResetPassword->idUser = $tUser->idUser;
                $tResetPassword->token = hash('sha256', $token);
                $tResetPassword->isRecuperate = 1;

                $tResetPassword->save();

                $linkReset = url('usuario/resetear/'. $tResetPassword->token);
                Mail::to($tUser->email)->send(new Notification($linkReset));

                DB::commit();

                return PlatformHelper::redirectCorrect(['Se le envio el link de recuperación al correo mencionado.'],'usuario/acceder');
            }
            catch(\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__,$e,'usuario/recuperar');
            }
        }
        return view('backoffice/user/recuperate');
    }

    private function sendLinkReset($email, $idResetPassword)
    {
        try
        {
            $tResetPassword = TResetPassword::find($idResetPassword);

            if (!$tResetPassword) {
                return PlatformHelper::redirectError(['No se encontró el token de restablecimiento de contraseña.'], 'usuario/recuperar');
            }

            $linkReset = URL::signedRoute('usuario.resetear', ['token' => $tResetPassword->token]);
            //$messageBody = 'Haga clic en el siguiente enlace para restablecer su contraseña: ' . $linkReset;

            /*Mail::send('email.other.generalMessage', ['messageBody' => $messageBody], function($x) use($email) {
                $x->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                  ->to($email)
                  ->subject('Restablecer Contraseña');
            });*/
            Mail::to('example-reset@repositorioedreapurimac.com')->send(new Notification($linkReset));
        }
        catch(\Exception $e)
        {
            return PlatformHelper::catchException(__CLASS__, __FUNCTION__,$e,'usuario/recuperar');
        }
    }

    public function actionLogout(SessionManager $sessionManager)
    {
        $sessionManager->flush();

        return PlatformHelper::redirectCorrect(['Sesión cerrada correctamente.'],'/');
    }

    public function actionGetAll(Request $request, $currentPage)
    {
        $searchParameter=$request->has('searchParameter') ? $request->input('searchParameter') : '';

        $paginate=PlatformHelper::preparePaginate(TUser::select('tuser.*', DB::raw('GROUP_CONCAT(trole.nameRole SEPARATOR \',\') as roles'))
        ->leftJoin('tuserrole', 'tuser.idUser', '=', 'tuserrole.idUser')
        ->leftJoin('trole', 'tuserrole.idRole', '=', 'trole.idRole')
        ->groupBy('tuser.idUser')->whereRaw('compareFind(concat(tuser.email, tuser.numberDni, tuser.firstName, tuser.surName, tuser.state), ?, 77)=1 AND tuser.idUser!=?', [$searchParameter, session('idUser')])->orderby('tuser.created_at', 'desc'), 7, $currentPage);

        return view('backoffice/user/getall',
        [
            'listTUser' => $paginate['listRow'],
            'currentPage' => $paginate['currentPage'],
            'quantityPage' => $paginate['quantityPage'],
            'searchParameter' => $searchParameter
        ]);
    }

    public function actionRegister(Request $request, Encrypter $encrypter)
    {
        if($_POST)
        {
            try
            {
                DB::beginTransaction();

                $this->_so->mo->listMessage=(new UserValidation())->validationRegister($request);

                if($this->_so->mo->existsMessage())
                {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'usuario/registrar');
                }

                $tUserExists=TUser::whereRaw('email=?', [trim($request->input('txtEmail'))])->exists();

                if($tUserExists==true)
                {
                    return PlatformHelper::redirectError(['Este correo ya está siendo utilizado, ingrese otro.'],'usuario/registrar');
                }

                $tUser= new TUser();

                $tUser->idUser=uniqid();

                $tUser->email=trim($request->input('txtEmail'));
                $tUser->password=$encrypter->encrypt(trim($request->input('passPasswordUser')));
                $tUser->numberDni=$request->input('txtNumberDni');
                $tUser->firstName=trim($request->input('txtFirstName'));
                $tUser->surName=trim($request->input('txtSurName'));
                $tUser->avatarExtension='';
                $tUser->state='Deshabilitado';

                $tUser->save();

                $tRoleDefault = TRole::whereRaw('nameRole=?', ['Normal'])->first();

                if($tRoleDefault == null)
                {
                    return PlatformHelper::redirectError(['Sucedio un error inesperado, contacte con el administrador.'],'usuario/registrar');
                }

                $tUserRole = new TUserRole();

                $tUserRole->idUserRole=uniqid();
                $tUserRole->idUser=$tUser->idUser;
                $tUserRole->idRole=$tRoleDefault->idRole;

                $tUserRole->save();

                DB::commit();

                return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'usuario/registrar');

            }
            catch(\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'usuario/registrar');
            }
        }
        return view('backoffice/user/register');
    }

    public function actionEdit(Request $request, SessionManager $sessionManager)
    {
        try
        {
            if($request->has('hdIdUser'))
            {
                DB::beginTransaction();

                    $this->_so->mo->listMessage=(new UserValidation())->validationEdit($request);

                    if($this->_so->mo->existsMessage())
                    {
                        DB::rollBack();

                        return PlatformHelper::redirectError($this->_so->mo->listMessage, 'usuario/modificar');
                    }

                    $tUser=TUser::find($request->input('hdIdUser'));

                    $tUser->firstName=trim($request->input('txtFirstNameUser'));
                    $tUser->surName=trim($request->input('txtSurNameUser'));
                    $tUser->numberDni=$request->input('txtDniUser');

                    $tUser->save();

                    if($request->hasFile('fileAvatarExtension'))
                    {
                        $tUser=TUser::find($request->input('hdIdUser'));

                        if($tUser->avatarExtension!='')
                        {
                            $direcciónLink=public_path('img/logo/user/'.$tUser->idUser.'.'.$tUser->avatarExtension);

                            unlink($direcciónLink);
                        }

                        $tUser->avatarExtension=strtolower($request->file('fileAvatarExtension')->getClientOriginalExtension());
                        $tUser->updated_at=date('Y-m-d H:i:s');

                        $tUser->save();

                        $request->file('fileAvatarExtension')->move(public_path('/img/logo/user/'), $tUser->idUser.'.'.$tUser->avatarExtension);
                    }

                    DB::commit();

                    $sessionManager->put('firstName',$tUser->firstName);
                    $sessionManager->put('surName',$tUser->surName);
                    $sessionManager->put('numberDni',$tUser->numberDni);
                    $sessionManager->put('avatarExtension', $tUser->avatarExtension);
                    $sessionManager->put('updated_at',$tUser->updated_at);

                    return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], '/');
            }

            return view('user/edit');
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'usuario/modificar');
        }
    }

    public function actionChangeStatus($idUser)
    {
        try
        {
            DB::beginTransaction();

            $tUser=TUser::find($idUser);

            $tUserRole = TUserRole::whereRaw('idUser=?', [$tUser->idUser])->exists();

            $valueStatus=$tUser->state;

            if($valueStatus=='Deshabilitado' && $tUserRole==false)
            {
                return PlatformHelper::redirectError(['Asigne al menos un rol al usuario para poder habilitar su acceso.'], 'usuario/mostrar/1');
            }

            $tUser->state=$valueStatus=='Habilitado' ? 'Deshabilitado' : 'Habilitado';

            $tUser->save();

            DB::commit();

            return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'usuario/mostrar/1');
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'usuario/mostrar/1');
        }
    }

    public function actionDelete($idUser)
    {
        try
        {
            $tUser=TUser::find($idUser);

            $directoryFiles= public_path('img/logo/user/'.$tUser->idUser.'.'.$tUser->avatarExtension);

            if($tUser->avatarExtension!='' && file_exists($directoryFiles)==true)
            {
                unlink($directoryFiles);
            }

            DB::delete('delete from tuser where idUser = ?', [$idUser]);

            return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'usuario/mostrar/1');
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'usuario/mostrar/1');
        }
    }

    public function actionChangeRole(Request $request)
    {
        if($request->has('HdIdUser'))
        {
            try
            {
                DB::beginTransaction();

                $tRole=TRole::find($request->input('selectRoleUser'));
                $tRoleUserExists = TUserRole::whereRaw('idUser=?', [$request->input('HdIdUser')])->exists();

                if ($tRoleUserExists == true)
                {
                    $tUserRole = TUserRole::whereRaw('idUser=?', [$request->input('HdIdUser')])->first();

                    $tUserRole->idRole = $tRole->idRole;

                    $tUserRole->save();
                }
                else
                {
                    $tUserRole = new TUserRole();

                    $tUserRole->idUserRole = uniqid();
                    $tUserRole->idUser = $request->input('HdIdUser');
                    $tUserRole->idRole = $request->input('selectRoleUser');

                    $tUserRole->save();
                }

                DB::commit();

                return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'usuario/mostrar/1');

            }
            catch(\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'usuario/mostrar/1');
            }
        }

        $tUser = TUser::find($request->input('idUser'));
        $tUserRole = TUserRole::where('idUser', $tUser->idUser)->pluck('idRole')->toArray();
        $tRole = TRole::all();

        if($tUser==null && $tRole== null)
        {
            return PlatformHelper::ajaxDataNoExists();
        }

        return view('backoffice/user/role',
        [
            'tRole' => $tRole,
            'tUser' => $tUser,
            'tUserRole' => $tUserRole
        ]);
    }

    public function actionReset($token, Request $request, Encrypter $encrypter)
    {
        try
        {
            if($_POST && $request->has('hdIdUser'))
            {
                DB::beginTransaction();

                $this->_so->mo->listMessage=(new UserValidation())->validationReset($request);

                if($this->_so->mo->existsMessage())
                {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'usuario/resetear/'.$token);
                }

                $tUser = TUser::find($request->input('hdIdUser'));

                if (!$tUser)
                    return PlatformHelper::redirectError(['No se encontró los datos del usuario.'],'usuario/resetear/'.$token);

                $tUser->password = $encrypter->encrypt(trim($request->input('passPasswordUser')));

                $tUser->save();

                $tResetPassword = TResetPassword::where('idUser', $tUser->idUser)->delete();

                DB::commit();

                return PlatformHelper::redirectCorrect(['Contraseña modificada correctamente.'], 'usuario/acceder');
            }

            $tResetPassword = TResetPassword::where('token', $token)->first();

            if(!$tResetPassword)
                return PlatformHelper::redirectError(['No se encontró el link o ya venció el tiempo de acceso para cambio de contraseña.'], 'usuario/acceder');

            $tUser = TUser::find($tResetPassword->idUser);

            if(!$tUser)
                return PlatformHelper::redirectError(['Usuario no encontrado.'], 'usuario/acceder');

            return view('backoffice/user/reset',
            [
                'token' => $token,
                'tUser' => $tUser
            ]);
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'usuario/mostrar/1');
        }
    }
}
