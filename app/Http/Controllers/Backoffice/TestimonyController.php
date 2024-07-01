<?php
namespace App\Http\Controllers\Backoffice;

use App\Helper\PlatformHelper;
use App\Http\Controllers\Controller;
use App\Models\TTestimony;
use App\Validation\TestimonyValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class TestimonyController extends Controller
{
    public function actionGetAll(Request $request, $currentPage)
    {
        $searchParameter = $request->has('searchParameter') ? $request->input('searchParameter') : '';

        $paginate = PlatformHelper::preparePaginate(TTestimony::whereRaw('compareFind(concat(description, firstName, surName, academic_level, place_origin), ?, 77)=1', [$searchParameter])
            ->orderby('created_at', 'desc'), 7, $currentPage);

        return view(
            'backoffice/testimony/getall',
            [
                'listTestimony' => $paginate['listRow'],
                'currentPage' => $paginate['currentPage'],
                'quantityPage' => $paginate['quantityPage'],
                'searchParameter' => $searchParameter
            ]
        );
    }

    public function actionChangeState($idTestimony)
    {
        try {
            DB::beginTransaction();

            $testimony = TTestimony::find($idTestimony);

            $valueStatus = $testimony->is_public;

            $testimony->is_public = $valueStatus == TTestimony::STATE['PUBLIC'] ? TTestimony::STATE['HIDDEN'] : TTestimony::STATE['PUBLIC'];

            $testimony->save();

            DB::commit();

            return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'testimonio/mostrar/1');
        } catch (\Exception $e) {
            DB::rollBack();

            return PlatformHelper::redirectError([$e->getMessage()], 'testimonio/mostrar/1');
        }
    }

    public function actionDelete($idTestimony)
    {
        try
        {
            $tTestimony = TTestimony::find($idTestimony);

            if ($tTestimony)
                $tTestimony->delete();

            return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'testimonio/mostrar/1');
        }
        catch(\Exception $e)
        {
            return PlatformHelper::redirectError([$e->getMessage()], 'testimonio/mostrar/1');
        }
    }

    public function actionEdit(Request $request)
    {
        if ($request->has('hdIdTestimony')) {
            try {
                DB::beginTransaction();

                $this->_so->mo->listMessage = (new TestimonyValidation())->validationEdit($request);

                if ($this->_so->mo->existsMessage()) {
                    DB::rollBack();

                    return PlatformHelper::redirectError($this->_so->mo->listMessage, 'testimonio/mostrar/1');
                }

                $tTestimony = TTestimony::find($request->input('hdIdTestimony'));

                $tTestimony->description = trim($request->input('txtDescription'));
                $tTestimony->firstName = $request->input('txtfirstName');
                $tTestimony->surName = $request->input('txtsurName');
                $tTestimony->academic_level = $request->input('txtAcademicLevel');
                $tTestimony->place_origin = $request->input('txtPlaceOrigin');
                $tTestimony->is_public = TTestimony::STATE['HIDDEN'];

                $tTestimony->save();

                DB::commit();

                return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'testimonio/mostrar/1');
            } catch (\Exception $e) {
                DB::rollBack();

                return PlatformHelper::redirectError([$e->getMessage()], 'testimonio/mostrar/1');
            }
        }

        $tTestimony=TTestimony::find($request->input('idTestimony'));

        if($tTestimony==null)
        {
            return PlatformHelper::ajaxDataNoExists();
        }

        return view('backoffice/testimony/edit',
            [
                'tTestimony' => $tTestimony
            ]);
    }
}
