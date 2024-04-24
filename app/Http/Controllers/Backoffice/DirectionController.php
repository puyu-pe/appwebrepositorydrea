<?php
namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Models\TExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TDirection;
use App\Validation\DirectionValidation;

class DirectionController extends Controller
{
    public function actionInsert(Request $request)
    {
        if($_POST)
        {
            try
            {
                DB::beginTransaction();

                $this->_so->mo->listMessage=(new DirectionValidation())->validationInsert($request);

                if($this->_so->mo->existsMessage())
                {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'direccion/mostrar/1');
                }

                $tDirectionExists=TDirection::whereRaw('compareFind(concat(namesortDirection), ?, 77)=1',[trim($request->input('txtNameSort'))])->exists();

                if($tDirectionExists==true)
                {
                    return PlatformHelper::redirectError(['Esta DRE ya fue registrada.'], 'direccion/mostrar/1');
                }

                $tDirection = new TDirection();

                $tDirection->idDirection = uniqid();
                $tDirection->namecompleteDirection = trim($request->input('txtNameComplete'));
                $tDirection->namesortDirection =  trim($request->input('txtNameSort'));
                $tDirection->nameRegion = trim($request->input('txtNameRegion'));
                $tDirection->logoExtension='';

                $tDirection->save();

                if($request->hasFile('fileLogoExtension'))
                {
                    $tDirection=TDirection::find($tDirection->idDirection);

                    $tDirection->logoExtension=strtolower($request->file('fileLogoExtension')->getClientOriginalExtension());

                    $tDirection->save();

                    $request->file('fileLogoExtension')->move(storage_path('/app/public/direction/'), $tDirection->idDirection.'.'.$tDirection->logoExtension);
                }

                DB::commit();

                return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'direccion/mostrar/1');
            }
            catch (\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'direccion/mostrar/1');
            }
        }

        return view('backoffice/direction/insert');
    }

    public function actionEdit(Request $request)
    {
        if($request->has('hdIdDirection'))
        {
            try
            {
                DB::beginTransaction();

                $this->_so->mo->listMessage=(new DirectionValidation())->validationEdit($request);

                if($this->_so->mo->existsMessage())
                {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'direccion/mostrar/1');
                }

                $tDirectionExists=TDirection::whereRaw('compareFind(concat(namesortDirection), ?, 77)=1 AND idDirection!=?',[trim($request->input('txtNameSort')), $request->input('hdIdDirection')])->exists();

                if($tDirectionExists==true)
                {
                    return PlatformHelper::redirectError(['Esta materia ya fue registrada, pruebe con otro nombre.'], 'direccion/mostrar/1');
                }

                $tDirection=TDirection::find($request->input('hdIdDirection'));

                $tDirection->namecompleteDirection = trim($request->input('txtNameComplete'));
                $tDirection->namesortDirection =  trim($request->input('txtNameSort'));
                $tDirection->nameRegion = trim($request->input('txtNameRegion'));

                $tDirection->save();


                if($request->hasFile('fileLogoExtension'))
                {
                    $tDirection=TDirection::find($tDirection->idDirection);

                    if($tDirection->logoExtension!='')
                    {
                        $direcciónLink=storage_path('app/public/direction/'.$tDirection->idDirection.'.'.$tDirection->logoExtension);

                        if (file_exists($direcciónLink))
                            unlink($direcciónLink);
                    }

                    $tDirection->logoExtension=strtolower($request->file('fileLogoExtension')->getClientOriginalExtension());
                    $tDirection->updated_at=date('Y-m-d H:i:s');

                    $tDirection->save();

                    $request->file('fileLogoExtension')->move(storage_path('/app/public/direction/'), $tDirection->idDirection.'.'.$tDirection->logoExtension);
                }

                DB::commit();

                return PlatformHelper::redirectCorrect(['Cambios realizados correctamente.'], 'direccion/mostrar/1');
            }
            catch (\Exception $e)
            {
                DB::rollBack();

                return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'direccion/mostrar/1');
            }
        }

        $tDirection=TDirection::find($request->input('idDirection'));

        if($tDirection==null)
        {
            return PlatformHelper::ajaxDataNoExists();
        }

        return view('backoffice/direction/edit',
        [
            'tDirection' => $tDirection
        ]);

    }

    public function actionDelete($idDirection)
    {
        try
        {
            $tExam=TExam::whereRaw('idDirection=?',[$idDirection])->exists();

            if($tExam==true)
            {
                return PlatformHelper::redirectError(['No puede eliminar este registro, ya existe evaluaciones que pertenecen a esta Direccción.'], 'direccion/mostrar/1');
            }

            $tDirection = TDirection::find($idDirection);

            if($tDirection->logoExtension!='')
            {
                $direcciónLink=storage_path('app/public/direction/'.$tDirection->idDirection.'.'.$tDirection->logoExtension);

                if (file_exists($direcciónLink))
                    unlink($direcciónLink);
            }

            DB::delete('delete from tdirection where idDirection = ?', [$idDirection]);

            return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'direccion/mostrar/1');
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'direccion/mostrar/1');
        }
    }

    public function actionGetAll(Request $request, $currentPage)
    {
        $searchParameter=$request->has('searchParameter') ? $request->input('searchParameter') : '';

        $paginate=PlatformHelper::preparePaginate(TDirection::whereRaw('compareFind(concat(namecompleteDirection, namesortDirection, nameRegion), ?, 77)=1',[$searchParameter])
        ->orderby('created_at', 'desc'), 7, $currentPage);

        return view('backoffice/direction/getall',
        [
            'listTDirection' => $paginate['listRow'],
            'currentPage' => $paginate['currentPage'],
            'quantityPage' => $paginate['quantityPage'],
            'searchParameter' => $searchParameter
        ]);
    }
}
