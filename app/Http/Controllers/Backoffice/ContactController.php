<?php

namespace App\Http\Controllers\Backoffice;

use App\Helper\PlatformHelper;
use App\Http\Controllers\Controller;
use App\Mail\ReplyContact;
use App\Models\TContact;

use App\Models\TDirection;
use App\Models\TExam;
use App\Models\TGrade;
use App\Models\TSubject;
use App\Models\TTypeExam;
use App\Models\TUserExam;
use App\Validation\ContactReplyValidation;
use App\Validation\ExamValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function actionGetAll(Request $request, $currentPage)
    {
        $searchParameter = $request->has('searchParameter') ? $request->input('searchParameter') : '';

        $paginate = PlatformHelper::preparePaginate(TContact::whereRaw('compareFind(concat(completeNameContact, emailContact, affairContact, messageContact), ?, 77)=1', [$searchParameter])
            ->orderby('created_at', 'desc'), 7, $currentPage);

        return view('backoffice/contact/getall',
            [
                'listTContact' => $paginate['listRow'],
                'currentPage' => $paginate['currentPage'],
                'quantityPage' => $paginate['quantityPage'],
                'searchParameter' => $searchParameter
            ]);
    }

    public function actionReply(Request $request)
    {
        if ($request->has('hdIdContact')) {
            try {
                DB::beginTransaction();

                $this->_so->mo->listMessage = (new ContactReplyValidation())->validationInsert($request);

                if ($this->_so->mo->existsMessage()) {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'contacto/mostrar/1');
                }

                $tContact = TContact::find($request->input('hdIdContact'));

                $tContact->replyContact = $request->input('txtMessage');
                $tContact->statusContact = 1;

                $tContact->save();

                Mail::to($tContact->emailContact)->send(new ReplyContact($tContact->completeNameContact, $tContact->messageContact, $tContact->replyContact));

                DB::commit()

                return PlatformHelper::redirectCorrect(['Cambios guardado correctamente.'], 'contacto/mostrar/1');
            } catch (\Exception $e) {
                DB::rollBack();

                return PlatformHelper::redirectError([$e->getMessage()], 'contacto/mostrar/1');
            }
        }

        $tContact = TContact::find($request->input('idContact'));

        if ($tContact == null) {
            return PlatformHelper::ajaxDataNoExists();
        }

        return view('backoffice/contact/reply',
            [
                'tContact' => $tContact,
            ]);
    }
}
