<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\TExam;
use App\Models\TResource;
use App\Models\TTypeExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DownloadController extends Controller
{
    public function packZipFile(Request $request)
    {
        $mode = $request->input('mode');
        $ids = $request->input('ids', []);

        $files = null;
        if ($mode == 'checked') {
            $files = TExam::findMany($ids);
        } else if ($mode == 'all') {

            $search = $ids['search'];
            $type = $ids['type'];
            $grade = $ids['grade'];
            $subject = $ids['subject'];
            $year = $ids['year'];

            $tTypeExam = TTypeExam::where('acronymTypeExam', $type)->first();

            $examsQuery = TExam::where('stateExam', TExam::STATUS['PUBLIC'])
                ->where(function ($query) use ($type, $grade, $subject, $year, $search, $tTypeExam) {
                    if ($type !== 'all') {
                        $query->where('idTypeExam', $tTypeExam->idTypeExam);
                    }
                    if ($grade !== 'all') {
                        $query->where('idGrade', $grade);
                    }
                    if ($subject !== 'all') {
                        $query->where('idSubject', $subject);
                    }
                    if ($year !== 'all') {
                        $query->where('yearExam', $year);
                    }
                    if (!empty($search)) {
                        $query->whereRaw('compareFind(concat(codeExam, nameExam, descriptionExam), ?, 77) = 1', [$search]);
                    }
                });

            $files = $examsQuery->get();
        } else {
            return response()->json(['error' => 'Invalid mode specified'], 400);
        }

        $zip = new ZipArchive();
        $zipFileName = 'descarga_' . time() . rand(1, 10) . '.zip';
        $zipPath = storage_path('app/public/zip/ ' . $zipFileName);

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($files as $file) {
                $filename = $file->idExam . '.' . $file->extensionExam;
                $zip->addFile(storage_path('app/file/exam/' . $filename), 'evaluaciones/'.$this->formatFileName($file->nameExam) . '.' . $file->extensionExam);

                $tResources = TResource::where('idExam', $file->idExam)->get();
                if ($tResources)
                {
                    foreach ($tResources as $tResource){
                        $file_resource = $tResource->idResource. '.' .$tResource->extension;
                        $zip->addFile(storage_path('app/public/resource/' . $file_resource), 'recursos/'.$this->formatFileName($tResource->namecompleteResource) . '.' . $tResource->extension);
                    }
                }
            }
            $zip->close();

            Storage::disk('zip')->put($zipFileName, file_get_contents($zipPath));
            unlink($zipPath);

            return response()->json(['downloadUrl' => url("download/zip/$zipFileName")]);
        } else {
            return response()->json(['error' => 'No se pudo crear el archivo'], 500);
        }
    }

    public function downloadZipFile($filename)
    {
        $filePath = storage_path('app/public/zip/' . $filename);

        if (file_exists($filePath)) {
            return response()->download($filePath)->deleteFileAfterSend(true);
        } else {
            return response()->json(['error' => 'Archivo no encontrado: ' . $filename], 404);
        }
    }

    private function formatFileName($filename){
        return preg_replace(['/ /', '/[\/\\\\]/', '/\./'], ['_', '', ''], $filename);
    }
}
