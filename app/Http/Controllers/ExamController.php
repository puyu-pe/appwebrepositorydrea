<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TExam;
use App\Models\TGrade;
use App\Models\TSubject;
use App\Models\TTypeExam;
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

                $tExam->idTypeExam=$request->input('selectTypeExam');
                $tExam->idGrade=$request->input('selectGrade');
                $tExam->idSubject=$request->input('selectSubject');
                $tExam->codeExam='';
                $tExam->nameExam='Evaluación '.strtoupper($tTypeExam->acronymTypeExam).' '.$tSubject->nameSubject.' '.$tGrade->numberGrade.'° '.$tGrade->nameGrade;
                $tExam->descriptionExam=trim($request->input('txtDescriptionExam'));
                $tExam->totalPageExam=$request->input('txtTotalPageExam');
                $tExam->yearExam=$request->input('txtYearExam');
                $tExam->stateExam='Publico';
                $tExam->keywordExam=implode('__7SEPARATOR7__', $request->input('selectKeywordExam'));
                $tExam->extensionExam=strtolower($request->file('fileExamExtension')->getClientOriginalExtension());

                $tExam->save();

                $request->file('fileExamExtension')->move(storage_path('/app/file/exam/'), $tExam->idExam.'.'.$tExam->extensionExam);

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

    public function actionWelcome()
    {
        $tTypeExam=TTypeExam::all();

        return view('exam/welcome',
        [
            'tTypeExam' => $tTypeExam
        ]);
    }
}
