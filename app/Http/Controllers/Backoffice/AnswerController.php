<?php
namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TAnswer;
use App\Validation\SubjectValidation;

class AnswerController extends Controller
{
    public function actionRegister(Request $request, $idExam)
    {
        if($_POST)
        {
            try
            {
                DB::beginTransaction();

                /*$this->_so->mo->listMessage=(new SubjectValidation())->validationInsert($request);

                if($this->_so->mo->existsMessage())
                {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'examen/mostrar/1');
                }*/

                DB::commit();

                return PlatformHelper::redirectCorrect(['Inserción realizada correctamente.'], 'examen/mostrar/1');
            }
            catch (\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'examen/mostrar/1');
            }
        }

        $tExam=TAnswer::find($idExam);

        if($tExam==null)
        {
            return PlatformHelper::ajaxDataNoExists();
        }

        return view('question/register',
        [
            'tExam' => $tExam
        ]);
    }

    public function actionEdit(Request $request, $idExam)
    {
        if($request->has('hdIdSubject'))
        {
            try
            {
                DB::beginTransaction();

                $this->_so->mo->listMessage=(new SubjectValidation())->validationEdit($request);

                if($this->_so->mo->existsMessage())
                {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'curso/mostrar/1');
                }

                DB::commit();

                return PlatformHelper::redirectCorrect(['Cambios realizados correctamente.'], 'curso/mostrar/1');
            }
            catch (\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'curso/mostrar/1');
            }
        }

        $tExam=TAnswer::find($idExam);

        if($tExam==null)
        {
            return PlatformHelper::ajaxDataNoExists();
        }

        return view('question/register',
        [
            'tExam' => $tExam
        ]);

    }

    public function actionDelete($idSubject)
    {
        try
        {
            $tExam=TAnswer::whereRaw('idSubject=?',[$idSubject])->exists();

            if($tExam==true)
            {
                return PlatformHelper::redirectError(['No puede eliminar este registro, ya existe evaluaciones que utilizan esta denominación.'], 'curso/mostrar/1');
            }

            DB::delete('delete from tsubject where idSubject = ?', [$idSubject]);

            return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'curso/mostrar/1');
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'curso/mostrar/1');
        }
    }
}
