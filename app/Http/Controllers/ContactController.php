<?php
namespace App\Http\Controllers;

use App\Helper\PlatformHelper;
use App\Http\Controllers\Controller;
use App\Models\TContact;
use App\Validation\ContactValidation;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function actionGetAll(Request $request, $currentPage)
    {
        $searchParameter=$request->has('searchParameter') ? $request->input('searchParameter') : '';

        $paginate=PlatformHelper::preparePaginate(TContact::whereRaw('compareFind(concat(completeNameContact, emailContact, affairContact, messageContact), ?, 77)=1',[$searchParameter])
        ->orderby('created_at', 'desc'), 7, $currentPage);

        return view('contact/getall',
        [
            'listTContact' => $paginate['listRow'],
            'currentPage' => $paginate['currentPage'],
            'quantityPage' => $paginate['quantityPage'],
            'searchParameter' => $searchParameter
        ]);
    }

    public function actionInsert(Request $request)
    {
        if($_POST)
        {
            try
            {
                DB::beginTransaction();

                $this->_so->mo->listMessage=(new ContactValidation())->validationInsert($request);

                if($this->_so->mo->existsMessage())
                {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'general/contacto');
                }

                $tContact = new TContact();

                $tContact->idContact = uniqid();
                $tContact->completeNameContact = trim($request->input('txtFullName'));
                $tContact->emailContact = trim($request->input('txtEmail'));
                $tContact->affairContact = trim($request->input('txtSubject'));
                $tContact->messageContact = trim($request->input('txtMessage'));
                $tContact->dateContact = date('Y-m-d');
                $tContact->statusContact = 0;

                $tContact->save();

                DB::commit();

                return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'general/contacto');
            }
            catch (\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'general/contacto');
            }
        }

        return view('contact/insert');
    }
}
?>
