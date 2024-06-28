<?php
namespace App\Http\Controllers\Frontoffice;

use App\Helper\PlatformHelper;
use App\Http\Controllers\Controller;
use App\Models\TTestimony;
use App\Validation\TestimonyValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class TestimonyController extends Controller
{
    public function actionInsert(Request $request)
    {
        if ($_POST) {
            try {
                DB::beginTransaction();

                $this->_so->mo->listMessage = (new TestimonyValidation())->validationInsert($request);

                if ($this->_so->mo->existsMessage()) {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'general/contacto');
                }

                $tTestimony = new TTestimony();

                $tTestimony->idTestimony = uniqid();
                $tTestimony->description = trim($request->input('txtDescription'));
                $tTestimony->firstName = $request->input('txtfirstName');
                $tTestimony->surName = $request->input('txtsurName');
                $tTestimony->academic_level = $request->input('txtAcademicLevel');
                $tTestimony->place_origin = $request->input('txtPlaceOrigin');
                $tTestimony->is_public = TTestimony::STATE['HIDDEN'];

                $tTestimony->save();

                DB::commit();

                return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], URL::previous());
            } catch (\Exception $e) {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), URL::previous());
            }
        }

        return view('frontoffice/testimony/insert');
    }
}
