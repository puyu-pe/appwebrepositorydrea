<?php
namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
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

                if ($request->has('hdIdAnswer')) {
                    $hdIdAnswer = $request->input('hdIdAnswer');

                    $isEmpty = empty($hdIdAnswer) || count(array_filter($hdIdAnswer, function($value) {
                            return $value !== '';
                        })) === 0;

                    if ($isEmpty) {
                        TAnswer::where('idExam', $request->input('hdIdExam'))
                            ->where('idUser', session('idUser'))
                            ->delete();
                    } else {
                        $tAnswers = TAnswer::where('idExam', $request->input('hdIdExam'))
                            ->where('idUser', session('idUser'))
                            ->get();

                        $existingIds = $tAnswers->pluck('idAnswer')->toArray();
                        $idsToDelete = array_diff($existingIds, $hdIdAnswer);
                        $idsToDelete = array_filter($idsToDelete);

                        if (!empty($idsToDelete)) {
                            TAnswer::whereIn('idAnswer', $idsToDelete)->delete();
                        }
                    }
                }

                if ($request->has('txtValueResponseExam') && $request->has('numberValueExam')) {

                    foreach ($request->input('txtValueResponseExam') as $number => $valueResponse) {
                        $idAnswer = $request->input('hdIdAnswer')[$number] ?? null;

                        if ($idAnswer) {
                            $tAnswer = TAnswer::find($idAnswer);
                            if ($tAnswer) {
                                $tAnswer->descriptionAnswer = $valueResponse;
                                $tAnswer->save();
                            }
                        } else {
                            $tAnswer = new TAnswer();

                            $tAnswer->idAnswer = uniqid();
                            $tAnswer->idExam = $request->input('hdIdExam');
                            $tAnswer->idUser = session('idUser');
                            $tAnswer->numberAnswer = $request->input('numberValueExam')[$number];
                            $tAnswer->descriptionAnswer = $valueResponse;

                            $tAnswer->save();
                        }
                    }
                }

                DB::commit();

                return PlatformHelper::redirectCorrect(['Inserción realizada correctamente.'], 'examen/mostrar/1');
            }

            $tExam = TExam::find($request->input('idExam'));
            $tAnswer = TAnswer::whereRaw('idExam = ? AND idUser = ?', [$request->input('idExam'), session('idUser')])
                ->orderBy('numberAnswer')->get();

            $maxNumberAnswer = TAnswer::where('idExam', $request->input('idExam'))
                ->where('idUser', session('idUser'))
                ->max('numberAnswer');


            if($tAnswer == null)
            {
                return PlatformHelper::ajaxDataNoExists();
            }

            return view('backoffice/answer/insert',
            [
                'tExam' => $tExam,
                'tAnswer' => $tAnswer,
                'maxNumberAnswer' => $maxNumberAnswer
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
