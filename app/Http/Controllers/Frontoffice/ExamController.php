<?php
namespace App\Http\Controllers\Frontoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Models\TAnswer;
use App\Models\TDirection;
use App\Models\TDocument;
use App\Models\TRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helper\ExamHelper;

use App\Models\TExam;
use App\Models\TGrade;
use App\Models\TSubject;
use App\Models\TTypeExam;
use App\Models\TUserExam;
use App\Validation\ExamValidation;

class ExamController extends Controller
{
    public function actionRegister(Request $request)
    {
        if($_POST)
        {
            try
            {
                DB::beginTransaction();

                $this->_so->mo->listMessage=(new ExamValidation())->validationInsert($request);

                if($this->_so->mo->existsMessage())
                {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'examen/registrar');
                }

                $tTypeExam  = TTypeExam::find($request->input('selectTypeExam'));
                $tSubject   = TSubject::find($request->input('selectSubject'));
                $tGrade     = TGrade::find($request->input('selectGrade'));
                $tDirection = TDirection::find($request->input('selectDirectionExam'));
                $tDocument  = TDocument::whereRaw('key_document=?', ['exam'])->first();

                $tNumberExam = $tTypeExam->numberExecuteYear > 1 ? $request->input('numberEvaluationExecute').'° ': '';
                $tSiteExam = !$tDirection ? '' : (' ' . $tDirection->nameRegion);

                $tExam=new TExam();

                $tExam->idExam=uniqid();

                $tExam->idTypeExam = $request->input('selectTypeExam');
                $tExam->idGrade = $request->input('selectGrade');
                $tExam->idSubject = $request->input('selectSubject');
                $tExam->idDirection = $request->input('selectDirectionExam') == 'General' ? null : $request->input('selectDirectionExam');
                $tExam->codeExam = $tDocument->number_document+1;
                $tExam->nameExam = $tNumberExam.'Evaluación '.strtoupper($tTypeExam->acronymTypeExam).$tSiteExam.' '.$tSubject->nameSubject.' '.$tGrade->numberGrade.'° '.$tGrade->nameGrade;
                $tExam->descriptionExam = trim($request->input('txtDescriptionExam'));
                $tExam->totalPageExam = $request->input('txtTotalPageExam');
                $tExam->yearExam = $request->input('txtYearExam');
                $tExam->numberEvaluation = $request->input('numberEvaluationExecute');
                $tExam->number_question = 0;
                $tExam->stateExam = TExam::STATUS['HIDDEN'];
                $tExam->keywordExam = implode('__7SEPARATOR7__', $request->input('selectKeywordExam'));
                $tExam->extensionExam = strtolower($request->file('fileExamExtension')->getClientOriginalExtension());
                $tExam->register_answer = 0;

                $tExam->save();

                /*$tUserExam = new TUserExam();

                $tUserExam->idUserExam = uniqid();
                $tUserExam->idUser = session('idUser');
                $tUserExam->idExam = $tExam->idExam;
                $tUserExam->typeFunctionExam = 'Registro';
                $tUserExam->dataExam = $this->convertArray($tExam);
                $tUserExam->dateUserExam = date('Y-m-d');

                $tUserExam->save();*/

                $tDocument->number_document = $tDocument->number_document+1;

                $tDocument->save();

                $request->file('fileExamExtension')->move(storage_path('/app/file/exam/'), $tExam->idExam.'.'.$tExam->extensionExam);

                if ($request->has('txtValueResponseExam'))
                {
                    foreach ($request->input('txtValueResponseExam') as $number => $valueResponse)
                    {
                        $tAnswer = new TAnswer();

                        $tAnswer->idAnswer=uniqid();
                        $tAnswer->idExam=$tExam->idExam;
                        $tAnswer->numberAnswer=$number+1;
                        $tAnswer->descriptionAnswer=$valueResponse;

                        $tAnswer->save();
                    }
                }

                DB::commit();

                return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'examen/registrar');
            }
            catch (\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::redirectError([$e->getMessage()], 'examen/registrar');
            }
        }

        $tTypeExam=TTypeExam::all();
        $tSubject=TSubject::all();
        $tGrade=TGrade::all();
        $tDirection=TDirection::all();

        return view('frontoffice/exam/register',
        [
            'tTypeExam' => $tTypeExam,
            'tSubject' => $tSubject,
            'tGrade' => $tGrade,
            'tDirection' => $tDirection
        ]);
    }

    private function convertArray($data)
    {
        $tExamData = array(
            'idExam' => $data->idExam,
            'idTypeExam' => $data->idTypeExam,
            'idGrade' => $data->idGrade,
            'idSubject' => $data->idSubject,
            'idDirection' => $data->idDirection,
            'codeExam' => $data->codeExam,
            'nameExam' => $data->nameExam,
            'descriptionExam' => $data->descriptionExam,
            'totalPageExam' => $data->totalPageExam,
            'yearExam' => $data->yearExam,
            'stateExam' => $data->stateExam,
            'keywordExam' => $data->keywordExam,
            'extensionExam' => $data->extensionExam,
            'register_answer' => $data->register_answer,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
        );

        return json_encode($tExamData);
    }

    public function actionGetExam($codeExam)
    {
        try
        {
            $tExam=TExam::with(['tSubject', 'tGrade', 'tTypeExam'])->whereRaw('codeExam=?', [$codeExam])->first();

            if (!$tExam){
                $message = 'No se encontró la página de la evaluación';

                return view('frontoffice/exam/error',
                [
                    'message' => $message
                ]);
            }

            if($tExam && $tExam->stateExam != TExam::STATUS['PUBLIC'] &&
            !stristr(session('roleUser'), TRole::ROLE['ADMIN']) && !stristr(session('roleUser'), TRole::ROLE['SUPERVISOR'])){
                $message = 'La página de la evaluación aún no se encuentra público.';

                return view('frontoffice/exam/error',
                [
                    'message' => $message
                ]);
            }

            ExamHelper::incrementViewCounter($tExam);
            $rating = ExamHelper::getRatingData($tExam->idExam);

            return view('frontoffice/exam/seed',
            [
                'tExam' => $tExam,
                'rating' => $rating
            ]);
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            return PlatformHelper::redirectError([$e->getMessage()], '/');
        }
    }
}
