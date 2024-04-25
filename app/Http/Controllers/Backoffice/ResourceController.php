<?php
namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Models\TExam;
use App\Models\TResource;
use App\Models\TRole;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResourceController extends Controller
{
    public function actionInsert(Request $request)
    {
        try
        {
            if ($request->has('hdIdExam'))
            {
                DB::beginTransaction();

                $tExam = TExam::find($request->input('hdIdExam'));
                $files = $request->file('fileResource');

                foreach ($files as $key => $file) {
                    $tResource = new TResource();

                    $tResource->idResource = uniqid();
                    $tResource->idExam = $tExam->idExam;
                    $tResource->namecompleteResource = 'Material ' . date('Y-m-d_H:i:s') . '_' . ($key+1) . ' ' . $tExam->nameExam;
                    $tResource->type = TResource::TYPE_RESOURCE['MATERIAL'];
                    $tResource->extension = strtolower($file->getClientOriginalExtension());

                    $tResource->save();

                    $filename = $tResource->idResource . '.' . $tResource->extension;

                    $file->move(storage_path('/app/public/resource/'), $filename);
                }

                DB::commit();

                return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'examen/mostrar/1');
            }

            $tExam = TExam::find($request->input('idExam'));
            $tResource = TResource::whereRaw('idExam = ? AND type = ?', [$tExam->idExam, TResource::TYPE_RESOURCE['MATERIAL']])->get();


            if($tResource == null)
            {
                return PlatformHelper::ajaxDataNoExists();
            }

            return view('backoffice/resource/insert',
                [
                    'tExam' => $tExam,
                    'tResource' => $tResource,
                ]);
        }
        catch (\Exception $e)
        {
            DB::rollBack();

            return PlatformHelper::redirectError([$e->getMessage()], 'examen/mostrar/1');
        }
    }

    public function actionDelete($idResource)
    {
        try
        {
            $tResource = TResource::find($idResource);

            if(!$tResource)
            {
                return response()->json(['error' => 'Sucedió un error.'], 400);
            }

            $directoryFiles = storage_path('app/public/resource/' . $tResource->idResource . '.' . $tResource->extension);

            if ($tResource->extensionExam != '' && file_exists($directoryFiles)){
                unlink($directoryFiles);
            }

            DB::delete('delete from tresource where idResource = ?', [$idResource]);

            return response()->json([
                'status'  => 200,
                'message' => 'Recurso eliminado correctamente.'
            ]);
        }
        catch(\Exception $e)
        {
            abort(500);
        }
    }

    public function actionViewResource($idResource)
    {
        try {
            $tResource = TResource::find($idResource);
            $tExam = $tResource->idExam ? TExam::find($tResource->idExam) : null;

            if (!$tResource) {
                $message = 'No se encontró el recurso perteneciente a la evaluación';

                return view(
                    'frontoffice/exam/error',
                    [
                        'message' => $message
                    ]
                );
            }

            if (($tExam && $tExam->stateExam != TExam::STATUS['PUBLIC']) &&
                !stristr(session('roleUser'), TRole::ROLE['ADMIN']) && !stristr(session('roleUser'), TRole::ROLE['SUPERVISOR'])
            ) {
                $message = 'El archivo del recurso no está disponible por el momento.';

                return view(
                    'frontoffice/exam/error',
                    [
                        'message' => $message
                    ]
                );
            }

            $fileName = preg_replace(['/ /', '/[\/\\\\]/', '/\./'], ['_', '', ''], $tResource->namecompleteResource);
            $directoryFiles = storage_path('/app/public/resource/' . $tResource->idResource . '.' . $tResource->extension);

            $response = new BinaryFileResponse($directoryFiles);
            $response->setContentDisposition('inline', $fileName . '.' . $tResource->extension);

            BinaryFileResponse::trustXSendfileTypeHeader();

            return $response;
        } catch (\Exception $e) {
            $message = 'No se encontró el documento pdf del recurso mencionado, consulte al administrador del sistema.';
            return view(
                'frontoffice/exam/error',
                [
                    'message' => $message
                ]
            );
        }
    }
}
