<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Models\TAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TExam;
use App\Models\TGrade;
use App\Models\TSubject;
use App\Models\TTypeExam;
use App\Models\TUserExam;
use App\Validation\ExamValidation;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExamController extends Controller
{
    public function actionGetAll(Request $request, $currentPage)
    {
        $searchParameter=$request->has('searchParameter') ? $request->input('searchParameter') : '';

        $paginate=PlatformHelper::preparePaginate(TExam::with(['tSubject', 'tGrade', 'tTypeExam'])->whereRaw('compareFind(concat(codeExam, nameExam, descriptionExam, yearExam, keywordExam), ?, 77)=1',[$searchParameter])
        ->orderby('created_at', 'desc'), 7, $currentPage);

        return view('exam/getall',
        [
            'listTExam' => $paginate['listRow'],
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

                $this->_so->mo->listMessage=(new ExamValidation())->validationInsert($request);

                if($this->_so->mo->existsMessage())
                {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'examen/insertar');
                }

                $tTypeExam=TTypeExam::find($request->input('selectTypeExam'));
                $tSubject=TSubject::find($request->input('selectSubject'));
                $tGrade=TGrade::find($request->input('selectGrade'));

                $tExam=new TExam();

                $tExam->idExam=uniqid();

                $tExam->idTypeExam = $request->input('selectTypeExam');
                $tExam->idGrade = $request->input('selectGrade');
                $tExam->idSubject = $request->input('selectSubject');
                $tExam->codeExam = '';
                $tExam->nameExam = 'Evaluación '.strtoupper($tTypeExam->acronymTypeExam).' '.$tSubject->nameSubject.' '.$tGrade->numberGrade.'° '.$tGrade->nameGrade;
                $tExam->descriptionExam = trim($request->input('txtDescriptionExam'));
                $tExam->totalPageExam = $request->input('txtTotalPageExam');
                $tExam->yearExam = $request->input('txtYearExam');
                $tExam->stateExam = 'Publico';
                $tExam->keywordExam = implode('__7SEPARATOR7__', $request->input('selectKeywordExam'));
                $tExam->extensionExam = strtolower($request->file('fileExamExtension')->getClientOriginalExtension());
                $tExam->statusAnwser = 0;

                $tExam->save();

                $tUserExam = new TUserExam();

                $tUserExam->idUserExam = uniqid();
                $tUserExam->idUser = session('idUser');
                $tUserExam->idExam = $tExam->idExam;
                $tUserExam->typeFunctionExam = 'Registro';
                $tUserExam->dataExam = $this->convertArray($tExam);
                $tUserExam->dateUserExam = date('Y-m-d');

                $tUserExam->save();

                $request->file('fileExamExtension')->move(storage_path('/app/file/exam/'), $tExam->idExam.'.'.$tExam->extensionExam);

                if ($request->has('txtValueResponseExam'))
                {
                    foreach ($request->input('txtValueResponseExam') as $number => $valueResponse)
                    {
                        $tAnswer = new TAnswer();

                        $tAnswer->idAnswer = uniqid();
                        $tAnswer->idExam = $tExam->idExam;
                        $tAnswer->numberAnswer = $number+1;
                        $tAnswer->descriptionAnswer = $valueResponse;

                        $tAnswer->save();
                    }

                    $tExam = TExam::find($tExam->idExam);
                    $tExam->statusAnwser = 1;

                    $tExam->save();
                }

                DB::commit();

                return PlatformHelper::redirectCorrect(['Inserción realizada correctamente.'], 'examen/insertar');
            }
            catch (\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'examen/insertar');
            }
        }

        $tTypeExam=TTypeExam::all();
        $tSubject=TSubject::all();
        $tGrade=TGrade::all();

        return view('exam/insert',
        [
            'tTypeExam' => $tTypeExam,
            'tSubject' => $tSubject,
            'tGrade' => $tGrade
        ]);
    }

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

                $tTypeExam=TTypeExam::find($request->input('selectTypeExam'));
                $tSubject=TSubject::find($request->input('selectSubject'));
                $tGrade=TGrade::find($request->input('selectGrade'));

                $tExam=new TExam();

                $tExam->idExam=uniqid();

                $tExam->idTypeExam = $request->input('selectTypeExam');
                $tExam->idGrade = $request->input('selectGrade');
                $tExam->idSubject = $request->input('selectSubject');
                $tExam->codeExam = '';
                $tExam->nameExam = 'Evaluación '.strtoupper($tTypeExam->acronymTypeExam).' '.$tSubject->nameSubject.' '.$tGrade->numberGrade.'° '.$tGrade->nameGrade;
                $tExam->descriptionExam = trim($request->input('txtDescriptionExam'));
                $tExam->totalPageExam = $request->input('txtTotalPageExam');
                $tExam->yearExam = $request->input('txtYearExam');
                $tExam->stateExam = 'Oculto';
                $tExam->keywordExam = implode('__7SEPARATOR7__', $request->input('selectKeywordExam'));
                $tExam->extensionExam = strtolower($request->file('fileExamExtension')->getClientOriginalExtension());
                $tExam->statusAnwser = 0;

                $tExam->save();

                $tUserExam = new TUserExam();

                $tUserExam->idUserExam = uniqid();
                $tUserExam->idUser = session('idUser');
                $tUserExam->idExam = $tExam->idExam;
                $tUserExam->typeFunctionExam = 'Registro';
                $tUserExam->dataExam = $this->convertArray($tExam);
                $tUserExam->dateUserExam = date('Y-m-d');

                $tUserExam->save();

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

                    $tExam = TExam::find($tExam->idExam);
                    $tExam->statusAnwser = 1;

                    $tExam->save();
                }

                DB::commit();

                return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'examen/registrar');
            }
            catch (\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'examen/registrar');
            }
        }

        $tTypeExam=TTypeExam::all();
        $tSubject=TSubject::all();
        $tGrade=TGrade::all();

        return view('exam/register',
        [
            'tTypeExam' => $tTypeExam,
            'tSubject' => $tSubject,
            'tGrade' => $tGrade
        ]);
    }


    public function actionEdit(Request $request)
    {
        if($request->has('hdIdExam'))
        {
            try
            {
                DB::beginTransaction();

                $this->_so->mo->listMessage=(new ExamValidation())->validationEdit($request);

                if($this->_so->mo->existsMessage())
                {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'examen/mostrar/1');
                }

                $tTypeExam=TTypeExam::find($request->input('selectTypeExam'));
                $tSubject=TSubject::find($request->input('selectSubject'));
                $tGrade=TGrade::find($request->input('selectGrade'));

                $tExam=TExam::find($request->input('hdIdExam'));

                $tExam->idTypeExam=$request->input('selectTypeExam');
                $tExam->idGrade=$request->input('selectGrade');
                $tExam->idSubject=$request->input('selectSubject');
                $tExam->nameExam='Evaluación '.strtoupper($tTypeExam->acronymTypeExam).' '.$tSubject->nameSubject.' '.$tGrade->numberGrade.'° '.$tGrade->nameGrade;
                $tExam->descriptionExam=trim($request->input('txtDescriptionExam'));
                $tExam->totalPageExam=$request->input('txtTotalPageExam');
                $tExam->yearExam=$request->input('txtYearExam');
                $tExam->keywordExam=implode('__7SEPARATOR7__', $request->input('selectKeywordExam'));

                $tExam->save();

                if($request->hasFile('fileExamExtension'))
                {
                    $tExam=TExam::find($tExam->idExam);

                    $directoryFiles= storage_path('app/file/exam/'.$tExam->idExam.'.'.$tExam->extensionExam);

                    if($tExam->extensionExam!='' && file_exists($directoryFiles)==true)
                    {
                        $direccionLink=storage_path('app/file/exam/'.$tExam->idExam.'.'.$tExam->extensionExam);

                        unlink($direccionLink);
                    }

                    $tExam->extensionExam=strtolower($request->file('fileExamExtension')->getClientOriginalExtension());
                    $tExam->updated_at=date('Y-m-d H:i:s');

                    $tExam->save();

                    $request->file('fileExamExtension')->move(storage_path('/app/file/exam/'), $tExam->idExam.'.'.$tExam->extensionExam);
                }

                DB::commit();

                return PlatformHelper::redirectCorrect(['Cambios guardado correctamente.'], 'examen/mostrar/1');
            }
            catch (\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'examen/mostrar/1');
            }
        }

        $tExam=TExam::find($request->input('idExam'));

        $tTypeExam=TTypeExam::all();
        $tSubject=TSubject::all();
        $tGrade=TGrade::all();

        if($tExam==null)
        {
            return PlatformHelper::ajaxDataNoExists();
        }

        return view('exam/edit',
        [
            'tExam' => $tExam,
            'tTypeExam' => $tTypeExam,
            'tSubject' => $tSubject,
            'tGrade' => $tGrade
        ]);
    }

    public function actionViewExam($idExam)
    {
        $tExam=TExam::find($idExam);

        $directoryFiles= storage_path('/app/file/exam/'.$tExam->idExam.'.'.$tExam->extensionExam);

        $response=new BinaryFileResponse($directoryFiles);

        BinaryFileResponse::trustXSendfileTypeHeader();

        return $response;
    }

    public function actionDelete($idExam)
    {
        try
        {
            $tExam=TExam::find($idExam);

            $directoryFiles= storage_path('app/file/exam/'.$tExam->idExam.'.'.$tExam->extensionExam);

            if($tExam->extensionExam!='' && file_exists($directoryFiles)==true)
            {
                unlink($directoryFiles);
            }

            DB::delete('delete from texam where idExam = ?', [$idExam]);

            return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'examen/mostrar/1');
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'examen/mostrar/1');
        }
    }

    public function actionChangeState($idExam)
    {
        try
        {
            DB::beginTransaction();

            $tExam=TExam::find($idExam);

            $valueStatus=$tExam->stateExam;

            $tExam->stateExam=$valueStatus=='Publico' ? 'Oculto' : 'Publico';

            $tExam->save();

            DB::commit();

            return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'examen/mostrar/1');
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'examen/mostrar/1');
        }
    }

    public function convertArray($data)
    {
        $tExamData = array(
            'idExam' => $data->idExam,
            'idTypeExam' => $data->idTypeExam,
            'idGrade' => $data->idGrade,
            'idSubject' => $data->idSubject,
            'codeExam' => $data->codeExam,
            'nameExam' => $data->nameExam,
            'descriptionExam' => $data->descriptionExam,
            'totalPageExam' => $data->totalPageExam,
            'yearExam' => $data->yearExam,
            'stateExam' => $data->stateExam,
            'keywordExam' => $data->keywordExam,
            'extensionExam' => $data->extensionExam,
            'statusAnwser' => $data->statusAnwser,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
        );

        return json_encode($tExamData);
    }
}
