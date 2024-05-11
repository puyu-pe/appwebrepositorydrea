<?php
namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Models\TExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TSubject;
use App\Validation\SubjectValidation;

class SubjectController extends Controller
{
    public function actionInsert(Request $request)
    {
        if($_POST)
        {
            try
            {
                DB::beginTransaction();

                $this->_so->mo->listMessage=(new SubjectValidation())->validationInsert($request);

                if($this->_so->mo->existsMessage())
                {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'curso/mostrar/1');
                }

                $tSubjectCodeExists=TSubject::whereRaw('codeSubject=?', [trim($request->input('txtCodeSubject'))])->exists();

                if($tSubjectCodeExists)
                    return PlatformHelper::redirectError(['Intente registrar otro código.'], 'curso/mostrar/1');

                $tSubject=new TSubject();

                $tSubject->idSubject = uniqid();
                $tSubject->nameSubject = trim($request->input('txtNameSubject'));
                $tSubject->codeSubject = trim($request->input('txtCodeSubject'));

                $tSubject->save();

                DB::commit();

                return PlatformHelper::redirectCorrect(['Inserción realizada correctamente.'], 'curso/mostrar/1');
            }
            catch (\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'curso/mostrar/1');
            }
        }

        return view('backoffice/subject/insert');
    }

    public function actionEdit(Request $request)
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

                $tSubjectCodeExists=TSubject::whereRaw('codeSubject = ? AND idSubject != ?',
                    [trim($request->input('txtCodeSubject')), $request->input('hdIdSubject')])->exists();

                if($tSubjectCodeExists)
                    return PlatformHelper::redirectError(['Intente registrar otro código.'], 'curso/mostrar/1');

                $tSubject=TSubject::find($request->input('hdIdSubject'));

                $tSubject->nameSubject = trim($request->input('txtNameSubject'));
                $tSubject->codeSubject = trim($request->input('txtCodeSubject'));

                $tSubject->save();

                DB::commit();

                return PlatformHelper::redirectCorrect(['Cambios realizados correctamente.'], 'curso/mostrar/1');
            }
            catch (\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'curso/mostrar/1');
            }
        }

        $tSubject=TSubject::find($request->input('idSubject'));

        if($tSubject==null)
        {
            return PlatformHelper::ajaxDataNoExists();
        }

        return view('backoffice/subject/edit',
        [
            'tSubject' => $tSubject
        ]);

    }

    public function actionDelete($idSubject)
    {
        try
        {
            $tExam=TExam::whereRaw('idSubject=?',[$idSubject])->exists();

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

    public function actionGetAll(Request $request, $currentPage)
    {
        $searchParameter=$request->has('searchParameter') ? $request->input('searchParameter') : '';

        $paginate=PlatformHelper::preparePaginate(TSubject::whereRaw('compareFind(concat(nameSubject), ?, 77)=1',[$searchParameter])
        ->orderby('created_at', 'desc'), 7, $currentPage);

        return view('backoffice/subject/getall',
        [
            'listTSubject' => $paginate['listRow'],
            'currentPage' => $paginate['currentPage'],
            'quantityPage' => $paginate['quantityPage'],
            'searchParameter' => $searchParameter
        ]);
    }
}
