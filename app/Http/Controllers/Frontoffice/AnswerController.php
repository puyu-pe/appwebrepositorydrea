<?php
namespace App\Http\Controllers\Frontoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Models\TAnswerDetail;
use App\Models\TExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TAnswer;

class AnswerController extends Controller
{
    public function actionRegister(Request $request)
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
                        $tAnswer->type = TAnswer::TYPE['VERIFY'];

                        $tAnswer->save();

                        $idAnswer = $tAnswer->idAnswer;
                    }

                    $total_null = 0;
                    foreach ($request->input('txtValueResponseExam') as $number => $valueResponse)
                    {
                        $idAnswerDetail = $request->input('hdIdAnswerDetail')[$number] ?? null;

                        if ($idAnswerDetail)
                        {
                            $tAnswerDetail = TAnswerDetail::find($idAnswerDetail);

                            if ($tAnswerDetail) {
                                $tAnswerDetail->descriptionAnswer = $valueResponse == '' ? '' : $valueResponse;
                                $tAnswerDetail->is_correct = $this->compareResponseAnswer($request->input('hdIdExam'), $tAnswerDetail->numberAnswer, $tAnswerDetail->descriptionAnswer);
                                $tAnswerDetail->save();

                                if ($tAnswerDetail->is_correct == null)
                                    $total_null ++;
                            }
                        }
                        else
                        {
                            $tAnswerDetail = new TAnswerDetail();
                            $tAnswerDetail->idAnswerDetail = uniqid();
                            $tAnswerDetail->idAnswer = $idAnswer;
                            $tAnswerDetail->numberAnswer = $number + 1;
                            $tAnswerDetail->descriptionAnswer = $valueResponse == '' ? '' : $valueResponse;
                            $tAnswerDetail->is_correct = $this->compareResponseAnswer($request->input('hdIdExam'), $tAnswerDetail->numberAnswer, $tAnswerDetail->descriptionAnswer);
                            $tAnswerDetail->save();

                            if ($tAnswerDetail->is_correct == null)
                                $total_null ++;
                        }
                    }

                    if ($total_null > 0){
                        $tAnswerChange = TAnswer::find($idAnswer);
                        $tAnswerChange->type = TAnswer::TYPE['REVIEWED'];
                        $tAnswerChange->save();
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

            return view('front/answer/register',
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
            $previousUrl = url()->previous();

            return PlatformHelper::redirectError([$e->getMessage()], $previousUrl);
        }
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

    private function compareResponseAnswer($idExam, $numberAnswer, $response)
    {
        $tAnswer = TAnswer::whereRaw('idExam = ? AND type = ?', [$idExam,TAnswer::TYPE['CORRECT']])->first();

        if (!$tAnswer)
            return null;

        $tAnswerDetail = TAnswerDetail::whereRaw('idAnswer = ? AND numberAnswer = ?', [$tAnswer->idAnswer, $numberAnswer])->first();

        if (!$tAnswerDetail)
            return null;

        return $response == $tAnswerDetail->descriptionAnswer ? 1 : 0;
    }
}
