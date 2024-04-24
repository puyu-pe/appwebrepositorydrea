<?php
namespace App\Http\Controllers\Frontoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Mail\ResetPassword;
use App\Models\TResetPassword;
use App\Models\TRole;
use App\Models\TUserRole;
use App\Validation\UserValidation;

use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\DB;

use App\Models\TUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function actionLogin(Request $request, Encrypter $encrypter, SessionManager $sessionManager)
    {
        if ($_POST) {
            try {
                $this->_so->mo->listMessage = (new UserValidation())->validationLogin($request);

                if ($this->_so->mo->existsMessage()) {
                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'usuario/acceder');
                }

                $tUser = TUser::whereRaw('email=?', [$request->input('txtEmail')])->first();

                if (($tUser == null || ($tUser != null && $encrypter->decrypt($tUser->password) != $request->input('passPassword')))) {
                    return PlatformHelper::redirectError(['Usuario o Contraseña Incorrecto'], 'usuario/acceder');
                }

                if ($tUser->state == 'Deshabilitado') {
                    return PlatformHelper::redirectError(['No tiene Acceso al Sistema'], 'usuario/acceder');
                }

                $tUserRole = TUserRole::where('idUser', $tUser->idUser)
                    ->join('trole', 'trole.idRole', '=', 'tuserrole.idRole')
                    ->pluck('trole.nameRole')
                    ->toArray();

                $roleNamesString = implode(',', $tUserRole);

                $sessionManager->put('idUser', $tUser->idUser);
                $sessionManager->put('email', $tUser->email);
                $sessionManager->put('firstName', $tUser->firstName);
                $sessionManager->put('surName', $tUser->surName);
                $sessionManager->put('numberDni', $tUser->numberDni);
                $sessionManager->put('avatarExtension', $tUser->avatarExtension);
                $sessionManager->put('updated_at', $tUser->updated_at);
                $sessionManager->put('roleUser', $roleNamesString);
                $sessionManager->put('mainRole', $roleNamesString);

                return PlatformHelper::redirectCorrect(['Bienvenido al sistema, ' . $tUser->firstName . ' ' . $tUser->surName . '.'], '/');
            } catch (\Exception $e) {
                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e, 'usuario/acceder');
            }
        }

        if (session('idUser') && !stristr(Session::get('roleUser'), TRole::ROLE['NORMAL']))
            return Redirect::to('/panel');

        if (session('idUser') && stristr(Session::get('roleUser'), TRole::ROLE['NORMAL']))
            return Redirect::to('usuario/editar');

        return view('frontoffice/user/login');
    }

    public function actionRegister(Request $request, Encrypter $encrypter)
    {
        if ($_POST) {
            try {
                DB::beginTransaction();

                $this->_so->mo->listMessage = (new UserValidation())->validationRegister($request);

                if ($this->_so->mo->existsMessage()) {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'usuario/registrar');
                }

                $tUserExists = TUser::whereRaw('email=?', [trim($request->input('txtEmail'))])->exists();

                if ($tUserExists == true) {
                    return PlatformHelper::redirectError(['Este correo ya está siendo utilizado, ingrese otro.'], 'usuario/registrar');
                }

                $tUser = new TUser();

                $tUser->idUser = uniqid();

                $tUser->email = trim($request->input('txtEmail'));
                $tUser->password = $encrypter->encrypt(trim($request->input('passPasswordUser')));
                $tUser->numberDni = $request->input('txtNumberDni');
                $tUser->firstName = trim($request->input('txtFirstName'));
                $tUser->surName = trim($request->input('txtSurName'));
                $tUser->avatarExtension = '';
                $tUser->state = 'Deshabilitado';

                $tUser->save();

                $tRoleDefault = TRole::whereRaw('nameRole=?', ['Normal'])->first();

                if ($tRoleDefault == null) {
                    return PlatformHelper::redirectError(['Sucedio un error inesperado, contacte con el administrador.'], 'usuario/registrar');
                }

                $tUserRole = new TUserRole();

                $tUserRole->idUserRole = uniqid();
                $tUserRole->idUser = $tUser->idUser;
                $tUserRole->idRole = $tRoleDefault->idRole;

                $tUserRole->save();

                DB::commit();

                return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'usuario/registrar');

            } catch (\Exception $e) {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'usuario/registrar');
            }
        }
        return view('frontoffice/user/register');
    }

    public function actionEdit(Request $request, SessionManager $sessionManager)
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

                if ($request->hasFile('fileAvatarExtension')) {
                    $tUser = TUser::find($request->input('hdIdUser'));

                    if ($tUser->avatarExtension != '') {
                        $direcciónLink = storage_path('app/public/user/' . $tUser->idUser . '.' . $tUser->avatarExtension);

                        if (file_exists($direcciónLink))
                            unlink($direcciónLink);
                    }

                    $tUser->avatarExtension = strtolower($request->file('fileAvatarExtension')->getClientOriginalExtension());
                    $tUser->updated_at = date('Y-m-d H:i:s');

                    $tUser->save();

                    $request->file('fileAvatarExtension')->move(storage_path('/app/public/user/'), $tUser->idUser . '.' . $tUser->avatarExtension);
                }

                DB::commit();

                $sessionManager->put('firstName',$tUser->firstName);
                $sessionManager->put('surName',$tUser->surName);
                $sessionManager->put('numberDni',$tUser->numberDni);
                $sessionManager->put('avatarExtension', $tUser->avatarExtension);
                $sessionManager->put('updated_at',$tUser->updated_at);

                return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'usuario/editar');

        }

        return view('frontoffice/user/edit');
    }

    public function actionChange(Request $request, SessionManager $sessionManager, Encrypter $encrypter)
    {
        if($request->has('hdIdUserValue'))
        {
            DB::beginTransaction();
            $this->_so->mo->listMessage=(new UserValidation())->validationChange($request);

            if($this->_so->mo->existsMessage())
            {
                DB::rollBack();
                return PlatformHelper::redirectError($this->_so->mo->listMessage, 'usuario/modificar');
            }

            $tUser=TUser::find($request->input('hdIdUserValue'));
            $email=$tUser->email;

            if($email!=trim($request->input('txtEmailUser')))
            {
                $tUser=TUser::whereRaw('email=?', [trim($request->input('txtEmailUser'))])->exists();
                if($tUser==true)
                {
                    return PlatformHelper::redirectError(['Correo Existente, ingrese otro.'], 'usuario/modificar');
                }
            }

            $tUser=TUser::find($request->input('hdIdUserValue'));

            $tUser->email=trim($request->input('txtEmailUser'));

            if($request->input('passPasswordUser')!='')
            {
                $tUser->password=$encrypter->encrypt(trim($request->input('passPasswordUser')));
            }

            $tUser->save();

            DB::commit();

            $sessionManager->flush();

            return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], '/');
        }
    }

    public function actionReset($token, Request $request, Encrypter $encrypter)
    {
        try {
            if ($_POST && $request->has('hdIdUser')) {
                DB::beginTransaction();

                $this->_so->mo->listMessage = (new UserValidation())->validationReset($request);

                if ($this->_so->mo->existsMessage()) {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'usuario/resetear/' . $token);
                }

                $tUser = TUser::find($request->input('hdIdUser'));

                if (!$tUser)
                    return PlatformHelper::redirectError(['No se encontró los datos del usuario.'], 'usuario/resetear/' . $token);

                $tUser->password = $encrypter->encrypt(trim($request->input('passPasswordUser')));
                $tUser->save();

                TResetPassword::where('idUser', $tUser->idUser)->delete();

                DB::commit();

                return PlatformHelper::redirectCorrect(['Contraseña modificada correctamente.'], 'usuario/acceder');
            }

            $tResetPassword = TResetPassword::where('token', $token)->first();

            if (!$tResetPassword)
                return PlatformHelper::redirectError(['No se encontró el link o ya venció el tiempo de acceso para cambio de contraseña.'], 'usuario/acceder');

            $tUser = TUser::find($tResetPassword->idUser);

            if (!$tUser)
                return PlatformHelper::redirectError(['Usuario no encontrado.'], 'usuario/acceder');

            return view('frontoffice/user/reset',
                [
                    'token' => $token,
                    'tUser' => $tUser
                ]);
        }
        catch (\Exception $e)
        {
            DB::rollBack();

            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'usuario/mostrar/1');
        }
    }

    public function actionRecuperate(Request $request)
    {
        if ($_POST) {
            try {
                DB::beginTransaction();

                $this->_so->mo->listMessage = (new UserValidation())->validationRecuperate($request);

                if ($this->_so->mo->existsMessage()) {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'usuario/recuperar');
                }

                $tUser = TUser::whereRaw('email=?', [$request->input('txtEmail')])->first();

                if (!$tUser) {
                    return PlatformHelper::redirectError(['Correo electrónico no encontrado.'], 'usuario/recuperar');
                }

                $tResetPasswordExists = TResetPassword::where('idUser', $tUser->idUser)->exists();

                if ($tResetPasswordExists)
                    return PlatformHelper::redirectError(['Ya se solicitó un link para recuperar la contraseña del correo en cuestión.'], 'usuario/recuperar');

                $token = Str::random(100);

                $tResetPassword = new TResetPassword();

                $tResetPassword->idResetPassword = uniqid();
                $tResetPassword->idUser = $tUser->idUser;
                $tResetPassword->token = hash('sha256', $token);
                $tResetPassword->isRecuperate = 1;

                $tResetPassword->save();

                $this->sendLinkReset($tUser->email, $tResetPassword->idResetPassword);

                DB::commit();

                return PlatformHelper::redirectCorrect(['Se le envio el link de recuperación al correo mencionado.'], 'usuario/acceder');
            } catch (\Exception $e) {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e, 'usuario/recuperar');
            }
        }
        return view('frontoffice/user/recuperate');
    }

    private function sendLinkReset($email, $idResetPassword)
    {
        try
        {
            $tResetPassword = TResetPassword::find($idResetPassword);

            if (!$tResetPassword) {
                return PlatformHelper::redirectError(['No se encontró el token de restablecimiento de contraseña.'], 'usuario/recuperar');
            }

            $linkReset = url('usuario/resetear/' . $tResetPassword->token);

            Mail::to($email)->send(new ResetPassword($linkReset));
        } catch (\Exception $e) {
            DB::rollBack();

            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e, 'usuario/recuperar');
        }
    }
}
