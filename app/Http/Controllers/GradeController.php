<?php
namespace App\Http\Controllers;

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

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'grado/mostrar/1');
                }

                $tGradeExists=TGrade::whereRaw('nameGrade=? AND numberGrade=?',[$request->input('selectNameGrade'), $request->input('txtNumberGrade')])->exists();

                if($tGradeExists==true)
                {
                    return PlatformHelper::redirectError(['Este grado ya fue registrado.'], 'grado/mostrar/1');
                }

                $tGrade=new TGrade();

                $tGrade->idGrade=uniqid();

                $tGrade->nameGrade=$request->input('selectNameGrade');
                $tGrade->numberGrade=$request->input('txtNumberGrade');

                $tGrade->save();

                DB::commit();

                return PlatformHelper::redirectCorrect(['Inserción realizada correctamente.'], 'grado/mostrar/1');
            }
            catch (\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'grado/mostrar/1');
            }
        }

        return view('grade/insert');
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

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'grado/mostrar/1');
                }

                $tGradeExists=TGrade::whereRaw('idGrade!=? AND nameGrade=? AND numberGrade=?',[$request->input('hdIdGrade'), $request->input('selectNameGrade'), $request->input('txtNumberGrade')])->exists();

                if($tGradeExists==true)
                {
                    return PlatformHelper::redirectError(['Este grado ya fue registrado, intenté cambiar el nombre o número.'], 'grado/mostrar/1');
                }

                $tGrade=TGrade::find($request->input('hdIdGrade'));

                $tGrade->nameGrade=$request->input('selectNameGrade');
                $tGrade->numberGrade=$request->input('txtNumberGrade');

                $tGrade->save();

                DB::commit();

                return PlatformHelper::redirectCorrect(['Cambios realizados correctamente.'], 'grado/mostrar/1');
            }
            catch (\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'grado/mostrar/1');
            }
        }

        $tGrade=TGrade::find($request->input('idGrade'));

        if($tGrade==null)
        {
            return PlatformHelper::ajaxDataNoExists();
        }

        return view('grade/edit',
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
                return PlatformHelper::redirectError(['No puede eliminar este registro, ya existe evaluaciones que utilizan esta denominación.'], 'grado/mostrar/1');
            }

            DB::delete('delete from tgrade where idGrade = ?', [$idGrade]);

            return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'grado/mostrar/1');
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'grado/mostrar/1');
        }
    }

    public function actionGetAll(Request $request, $currentPage)
    {
        $searchParameter=$request->has('searchParameter') ? $request->input('searchParameter') : '';

        $paginate=PlatformHelper::preparePaginate(TGrade::whereRaw('compareFind(concat(nameGrade, numberGrade), ?, 77)=1',[$searchParameter])
        ->orderby('created_at', 'desc'), 7, $currentPage);

        return view('grade/getall',
        [
            'listTGrade' => $paginate['listRow'],
            'currentPage' => $paginate['currentPage'],
            'quantityPage' => $paginate['quantityPage'],
            'searchParameter' => $searchParameter
        ]);
    }
}
