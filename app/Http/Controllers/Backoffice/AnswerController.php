<?php
namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Models\TAnswerDetail;
use App\Models\TExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TAnswer;
use App\Validation\SubjectValidation;

class AnswerController extends Controller
{
    public function actionInsert(Request $request)
    {
        try
        {
            if ($request->has('hdIdExam'))
            {
                DB::beginTransaction();

                if ($request->has('txtValueResponseExam') && $request->has('hdIdAnswer'))
                {

                    $idAnswer = $request->input('hdIdAnswer') ?? null;

                    if (!$idAnswer)
                    {
                        $tAnswer = new TAnswer();
                        $tAnswer->idAnswer = uniqid();
                        $tAnswer->idExam = $request->input('hdIdExam');
                        $tAnswer->idUser = session('idUser');
                        $tAnswer->type = TAnswer::TYPE['CORRECT'];

                        $tAnswer->save();

                        $idAnswer = $tAnswer->idAnswer;
                    }

                    foreach ($request->input('txtValueResponseExam') as $number => $valueResponse)
                    {
                        $idAnswerDetail = $request->input('hdIdAnswerDetail')[$number] ?? null;

                        if ($idAnswerDetail)
                        {
                            $tAnswerDetail = TAnswerDetail::find($idAnswerDetail);

                            if ($tAnswerDetail) {
                                $tAnswerDetail->descriptionAnswer = $valueResponse == '' ? '' : $valueResponse;
                                $tAnswerDetail->save();
                            }
                        }
                        else
                        {
                            $tAnswerDetail = new TAnswerDetail();
                            $tAnswerDetail->idAnswerDetail = uniqid();
                            $tAnswerDetail->idAnswer = $idAnswer;
                            $tAnswerDetail->numberAnswer = $number + 1;
                            $tAnswerDetail->descriptionAnswer = $valueResponse == '' ? '' : $valueResponse;
                            $tAnswerDetail->is_correct = null;
                            $tAnswerDetail->save();
                        }
                    }
                }

                DB::commit();

                $previousUrl = url()->previous();
                return PlatformHelper::redirectCorrect(['Inserción realizada correctamente.'], $previousUrl);
            }

            $tExam = TExam::find($request->input('idExam'));

            if($tExam == null)
            {
                return PlatformHelper::ajaxDataNoExists();
            }

            $tAnswer = TAnswer::whereRaw('idExam = ? AND idUser = ? AND type = ?',
                [$request->input('idExam'), session('idUser'), TAnswer::TYPE['CORRECT']])->first();
            $tAnswerDetail = $tAnswer ? TAnswerDetail::whereRaw('idAnswer = ?', [$tAnswer->idAnswer])
                ->orderBy('numberAnswer')->get() : null;
            $maxNumberAnswerDetail = $tAnswer ? TAnswerDetail::where('idAnswer', $tAnswer->idAnswer)
                ->max('numberAnswer') : 0;

            return view('backoffice/answer/insert',
            [
                'tExam' => $tExam,
                'tAnswer' => $tAnswer,
                'tAnswerDetail' => $tAnswerDetail,
                'maxNumberAnswer' => $maxNumberAnswerDetail
            ]);
        }
        catch (\Exception $e)
        {
            DB::rollBack();

            return PlatformHelper::redirectError([$e->getMessage()], 'examen/mostrar/1');
        }
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
