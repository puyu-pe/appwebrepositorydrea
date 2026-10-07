<?php
namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Models\TExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TGrade;
use App\Validation\GradeValidation;

class GradeController extends Controller
{
    public function actionInsert(Request $request)
    {
        if($_POST)
        {
            try
            {
                DB::beginTransaction();

                $this->_so->mo->listMessage=(new GradeValidation())->validationInsert($request);

                if($this->_so->mo->existsMessage())
                {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'grado/listar/1');
                }

                $tGradeExists=TGrade::whereRaw('codeGrade = ?',[$request->input('txtCodeGrade')])->exists();

                if($tGradeExists)
                {
                    DB::rollBack();

                    return PlatformHelper::redirectError(['Ya existe un grado registrado con este codigo, ingrese otro.'], 'grado/listar/1');
                }

                $tGrade=new TGrade();

                $tGrade->idGrade=uniqid();

                $tGrade->nameGrade = $request->input('selectNameGrade');
                $tGrade->descriptionGrade = $request->input('txtDescriptionGrade');
                $tGrade->codeGrade = $request->input('txtCodeGrade');

                $tGrade->save();

                DB::commit();

                return PlatformHelper::redirectCorrect(['Inserción realizada correctamente.'], 'grado/listar/1');
            }
            catch (\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'grado/listar/1');
            }
        }

        return view('backoffice/grade/insert');
    }

    public function actionEdit(Request $request)
    {
        if($request->has('hdIdGrade'))
        {
            try
            {
                DB::beginTransaction();

                $this->_so->mo->listMessage=(new GradeValidation())->validationEdit($request);

                if($this->_so->mo->existsMessage())
                {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'grado/listar/1');
                }

                $tGradeExists=TGrade::whereRaw('idGrade != ? AND codeGrade = ?',[$request->input('hdIdGrade'), $request->input('txtCodeGrade')])->exists();

                if($tGradeExists)
                {
                    DB::rollBack();

                    return PlatformHelper::redirectError(['Ya existe un grado registrado con este codigo, ingrese otro.'], 'grado/listar/1');
                }

                $tGrade=TGrade::find($request->input('hdIdGrade'));

                $tGrade->nameGrade = $request->input('selectNameGrade');
                $tGrade->descriptionGrade = $request->input('txtDescriptionGrade');
                $tGrade->codeGrade = $request->input('txtCodeGrade');

                $tGrade->save();

                DB::commit();

                return PlatformHelper::redirectCorrect(['Cambios realizados correctamente.'], 'grado/listar/1');
            }
            catch (\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'grado/listar/1');
            }
        }

        $tGrade=TGrade::find($request->input('idGrade'));

        if($tGrade==null)
        {
            return PlatformHelper::ajaxDataNoExists();
        }

        return view('backoffice/grade/edit',
        [
            'tGrade' => $tGrade
        ]);

    }

    public function actionDelete($idGrade)
    {
        try
        {
            $tExam=TExam::whereRaw('idGrade=?',[$idGrade])->exists();

            if($tExam==true)
            {
                return PlatformHelper::redirectError(['No puede eliminar este registro, ya existe evaluaciones que utilizan esta denominación.'], 'grado/listar/1');
            }

            $tGrade=TGrade::find($idGrade);

            if($tGrade!=null)
            {
                $tGrade->delete();
            }

            return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'grado/listar/1');
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'grado/listar/1');
        }
    }

    public function actionGetAll(Request $request, $currentPage=1)
    {
        $searchParameter=$request->has('searchParameter') ? $request->input('searchParameter') : '';

        $paginate=PlatformHelper::preparePaginate(TGrade::whereRaw('compareFind(concat(nameGrade, descriptionGrade, codeGrade), ?, 77)=1',[$searchParameter])
        ->orderby('created_at', 'desc'), 7, $currentPage);

        $viewData=[
            'listTGrade' => $paginate['listRow'],
            'currentPage' => $paginate['currentPage'],
            'quantityPage' => $paginate['quantityPage'],
            'searchParameter' => $searchParameter
        ];

        if($request->ajax())
        {
            return view('backoffice/grade/_list', $viewData);
        }

        return view('backoffice/grade/getall', $viewData);
    }
}
