<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Validation\UserValidation;

use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\DB;

use App\Models\TUser;

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

                $sessionManager->put('idUser',$tUser->idUser);
                $sessionManager->put('email',$tUser->email);
                $sessionManager->put('firstName',$tUser->firstName);
                $sessionManager->put('surName',$tUser->surName);
                $sessionManager->put('numberDni',$tUser->numberDni);
                $sessionManager->put('avatarExtension', $tUser->avatarExtension);
                $sessionManager->put('updated_at',$tUser->updated_at);
                $sessionManager->put('roleUser', $tUser->roleUser);
                $sessionManager->put('mainRole',$tUser->roleUser);

                return PlatformHelper::redirectCorrect(['Bienvenido al sistema, '.$tUser->firstName.' '.$tUser->surName.'.'],'/');
            }
            catch(\Exception $e)
            {
                return PlatformHelper::catchException(__CLASS__, __FUNCTION__,$e,'usuario/acceder');
            }
        }
        return view('user/login');
    }

    public function actionRecuperate(Request $request, Encrypter $encrypter, SessionManager $sessionManager)
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

                $sessionManager->put('idUser',$tUser->idUser);
                $sessionManager->put('email',$tUser->email);
                $sessionManager->put('firstName',$tUser->firstName);
                $sessionManager->put('surName',$tUser->surName);
                $sessionManager->put('numberDni',$tUser->numberDni);
                $sessionManager->put('avatarExtension', $tUser->avatarExtension);
                $sessionManager->put('updated_at',$tUser->updated_at);
                $sessionManager->put('roleUser', $tUser->roleUser);
                $sessionManager->put('mainRole',$tUser->roleUser);

                return PlatformHelper::redirectCorrect(['Bienvenido al sistema, '.$tUser->firstName.' '.$tUser->surName.'.'],'/');
            }
            catch(\Exception $e)
            {
                return PlatformHelper::catchException(__CLASS__, __FUNCTION__,$e,'usuario/acceder');
            }
        }
        return view('user/recuperate');
    }

    public function actionLogout(SessionManager $sessionManager)
    {
        $sessionManager->flush();

        return PlatformHelper::redirectCorrect(['Sesión cerrada correctamente.'],'/');
    }

    public function actionGetAll(Request $request, $currentPage)
    {
        $searchParameter=$request->has('searchParameter') ? $request->input('searchParameter') : '';

        $paginate=PlatformHelper::preparePaginate(TUser::whereRaw('compareFind(concat(email, numberDni, firstName, surName, state), ?, 77)=1', [$searchParameter])->orderby('created_at', 'desc'), 7, $currentPage);

        return view('user/getall',
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
                    return PlatformHelper::redirectError(['Correo ya utilizado.'],'usuario/registrar');
                }

                $tUser= new TUser();

                $tUser->idUser=uniqid();

                $tUser->email=trim($request->input('txtEmail'));
                $tUser->password=$encrypter->encrypt(trim($request->input('passPasswordUser')));
                $tUser->numberDni=$request->input('txtNumberDni');
                $tUser->firstName=trim($request->input('txtFirstName'));
                $tUser->surName=trim($request->input('txtSurName'));
                $tUser->roleUser='';
                $tUser->avatarExtension='';
                $tUser->state='Deshabilitado';

                $tUser->save();

                DB::commit();

                return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'usuario/registrar');

            }
            catch(\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'usuario/registrar');
            }
        }
        return view('user/register');
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
                $tUser->dni=$request->input('txtDniUser');
                $tUser->phonenumber=$request->input('txtNumberPhone')=='' ? '' : $request->input('txtNumberPhone');

                $tUser->save();

                if($request->hasFile('fileAvatarExtension'))
                {
                    $tUser=TUser::find($request->input('hdIdUser'));

                    if($tUser->avatarExtension!='')
                    {
                        $direcciónLink=public_path('img/avatar/user/'.$tUser->idUser.'/'.$tUser->idUser.'.'.$tUser->avatarExtension);

                        unlink($direcciónLink);
                    }

                    $tUser->avatarExtension=strtolower($request->file('fileAvatarExtension')->getClientOriginalExtension());
                    $tUser->updated_at=date('Y-m-d H:i:s');

                    $tUser->save();

                    $request->file('fileAvatarExtension')->move(public_path('/img/avatar/user/'.$tUser->idUser.'/'), $tUser->idUser.'.'.$tUser->avatarExtension);
                }

                DB::commit();

                $sessionManager->put('firstName',$tUser->firstName);
                $sessionManager->put('surName',$tUser->surName);
                $sessionManager->put('dni',$tUser->dni);
                $sessionManager->put('phonenumber',$tUser->phonenumber);
                $sessionManager->put('avatarExtension', $tUser->avatarExtension);
                $sessionManager->put('updated_at',$tUser->updated_at);

                return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], '/');

        }

        return view('user/edit');
    }

    public function actionChangeStatus($idUser)
    {
        try
        {
            $tUser=TUser::find($idUser);

            $valueStatus=$tUser->state;

            if($valueStatus=='Deshabilitado' && $tUser->roleUser=='')
            {
                return PlatformHelper::redirectError(['Asigne al menos un rol al usuario para poder habilitar su acceso.'], 'usuario/mostrar/1');
            }

            DB::beginTransaction();

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

                $tUser=TUser::find($request->input('HdIdUser'));

                if(stristr($tUser->roleUser, 'Administrador')==true)
                {
                    return PlatformHelper::redirectError(['No puede cambiar el rol del usuario tipo "Administrador".'], 'usuario/mostrar/1');
                }

                $tUser->roleUser=implode('__7SEPARATOR7__', $request->input('selectRoleUser'));

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

        $tUser=TUser::find($request->input('idUser'));

        if($tUser==null)
        {
            return PlatformHelper::ajaxDataNoExists();
        }

        return view('user/role',
        [
            'tUser' => $tUser
        ]);
    }
}
