<?php
namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Models\TExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TTypeExam;
use App\Validation\TypeExamValidation;

class TypeExamController extends Controller
{
    public function actionInsert(Request $request)
    {
        if($_POST)
        {
            try
            {
                DB::beginTransaction();

                $this->_so->mo->listMessage=(new TypeExamValidation())->validationInsert($request);

                if($this->_so->mo->existsMessage())
                {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'tipoexamen/mostrar/1');
                }

                $tTypeExamAcronym=TTypeExam::whereRaw('acronymTypeExam=?', [trim($request->input('txtAcronymTypeExam'))])->exists();

                if($tTypeExamAcronym==true)
                {
                    return PlatformHelper::redirectError(['Intente registrar otro tipo de siglas.'], 'tipoexamen/mostrar/1');

                }

                $tTypeExam=new TTypeExam();

                $tTypeExam->idTypeExam=uniqid();

                $tTypeExam->nameTypeExam=trim($request->input('txtNameTypeExam'));
                $tTypeExam->acronymTypeExam=trim($request->input('txtAcronymTypeExam'));
                $tTypeExam->descriptionTypeExam=trim($request->input('txtDescriptionTypeExam'));
                $tTypeExam->extensionImageType=strtolower($request->file('fileTypeExamLogo')->getClientOriginalExtension());

                $tTypeExam->save();

                $request->file('fileTypeExamLogo')->move(public_path('/img/logo/typeexam/'), $tTypeExam->idTypeExam.'.'.$tTypeExam->extensionImageType);

                DB::commit();

                return PlatformHelper::redirectCorrect(['Inserción realizada correctamente.'], 'tipoexamen/mostrar/1');
            }
            catch (\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'tipoexamen/mostrar/1');
            }
        }

        return view('backoffice/typeexam/insert');
    }

    public function actionEdit(Request $request)
    {
        if($request->has('hdIdTypeExam'))
        {
            try
            {
                DB::beginTransaction();

                $this->_so->mo->listMessage=(new TypeExamValidation())->validationEdit($request);

                if($this->_so->mo->existsMessage())
                {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'tipoexamen/mostrar/1');
                }

                $tTypeExam=TTypeExam::find($request->input('hdIdTypeExam'));

                $tTypeExam->nameTypeExam = trim($request->input('txtNameTypeExam'));
                $tTypeExam->acronymTypeExam = trim($request->input('txtAcronymTypeExam'));
                $tTypeExam->descriptionTypeExam = trim($request->input('txtDescriptionTypeExam'));
                $tTypeExam->numberExecuteYear = $request->input('numberExecute');

                $tTypeExam->save();

                if($request->hasFile('fileTypeExamLogo'))
                {
                    $tTypeExam=TTypeExam::find($tTypeExam->idTypeExam);

                    $directoryFiles= public_path('img/logo/typeexam/'.$tTypeExam->idTypeExam.'.'.$tTypeExam->extensionImageType);

                    if($tTypeExam->extensionImageType!='' && file_exists($directoryFiles)==true)
                    {
                        $direccionLink=public_path('img/logo/typeexam/'.$tTypeExam->idTypeExam.'.'.$tTypeExam->extensionImageType);

                        unlink($direccionLink);
                    }

                    $tTypeExam->extensionImageType=strtolower($request->file('fileTypeExamLogo')->getClientOriginalExtension());
                    $tTypeExam->updated_at=date('Y-m-d H:i:s');

                    $tTypeExam->save();

                    $request->file('fileTypeExamLogo')->move(public_path('/img/logo/typeexam/'), $tTypeExam->idTypeExam.'.'.$tTypeExam->extensionImageType);
                }

                DB::commit();

                return PlatformHelper::redirectCorrect(['Cambios realizados correctamente.'], 'tipoexamen/mostrar/1');
            }
            catch (\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'tipoexamen/mostrar/1');
            }
        }

        $tTypeExam=TTypeExam::find($request->input('idTypeExam'));

        if($tTypeExam==null)
        {
            return PlatformHelper::ajaxDataNoExists();
        }
        return view('backoffice/typeexam/edit',
        [
            'tTypeExam' => $tTypeExam
        ]);

    }

    public function actionDelete($idTypeExam)
    {
        try
        {
            $tExam=TExam::whereRaw('idTypeExam=?',[$idTypeExam])->exists();

            if($tExam==true)
            {
                return PlatformHelper::redirectError(['No puede eliminar este registro, ya existe evaluaciones que utilizan esta denominación.'], 'tipoexamen/mostrar/1');
            }

            $tTypeExam=TTypeExam::find($idTypeExam);

            $directoryFiles= public_path('img/logo/typeexam/'.$tTypeExam->idTypeExam.'.'.$tTypeExam->extensionImageType);

            if(file_exists($directoryFiles)==true)
            {
                unlink($directoryFiles);
            }

            DB::delete('delete from ttypeexam where idTypeExam = ?', [$idTypeExam]);

            return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'tipoexamen/mostrar/1');
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'tipoexamen/mostrar/1');
        }
    }

    public function actionGetAll(Request $request, $currentPage)
    {
        $searchParameter=$request->has('searchParameter') ? $request->input('searchParameter') : '';

        $paginate=PlatformHelper::preparePaginate(TTypeExam::whereRaw('compareFind(concat(nameTypeExam, acronymTypeExam, descriptionTypeExam), ?, 77)=1',[$searchParameter])
        ->orderby('created_at', 'desc'), 7, $currentPage);

        return view('backoffice/typeexam/getall',
        [
            'listTTypeExam' => $paginate['listRow'],
            'currentPage' => $paginate['currentPage'],
            'quantityPage' => $paginate['quantityPage'],
            'searchParameter' => $searchParameter
        ]);
    }
}
