<?php
namespace App\Http\Controllers\Frontoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Validation\UserValidation;

use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\DB;

use App\Models\TUser;

class UserController extends Controller
{
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

        return view('frontoffice/user/edit');
    }
}
