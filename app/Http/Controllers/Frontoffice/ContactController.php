<?php

namespace App\Http\Controllers\Frontoffice;

use App\Helper\PlatformHelper;
use App\Http\Controllers\Controller;
use App\Mail\ConfirmReception;
use App\Models\TContact;
use App\Validation\ContactValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class ContactController extends Controller
{
    public function actionInsert(Request $request)
    {
        if ($_POST) {
            try {
                DB::beginTransaction();

                $this->_so->mo->listMessage = (new ContactValidation())->validationInsert($request);

                if ($this->_so->mo->existsMessage()) {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'general/contacto');
                }

                $tContact = new TContact();

                $tContact->idContact = uniqid();
                $tContact->completeNameContact = trim($request->input('txtFullName'));
                $tContact->emailContact = trim($request->input('txtEmail'));
                $tContact->phoneContact = trim($request->input('txtPhone'));
                $tContact->affairContact = trim($request->input('txtSubject'));
                $tContact->messageContact = trim($request->input('txtMessage'));
                $tContact->dateContact = date('Y-m-d');
                $tContact->statusContact = 0;

                $tContact->save();

                DB::commit();

                Mail::to($tContact->emailContact)->send(new ConfirmReception($tContact->completeNameContact));

                return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], URL::previous());
            } catch (\Exception $e) {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), URL::previous());
            }
        }

        return view('frontoffice/contact/insert');
    }
}
