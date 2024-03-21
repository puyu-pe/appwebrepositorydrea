<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\TExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DownloadController extends Controller
{
    public function packZipFile(Request $request)
    {
        $ids = $request->input('ids', []);

        $files = TExam::findMany($ids);

        $zip = new ZipArchive;
        $zipFileName = 'descarga_' . time() . rand(1, 10) . '.zip';
        $zipPath = storage_path('app/public/zip/ ' . $zipFileName);

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($files as $file) {
                $filename = $file->idExam . '.' . $file->extensionExam;
                $zip->addFile(storage_path('app/file/exam/' . $filename), $file->nameExam . '.' . $file->extensionExam);
            }
            $zip->close();

            Storage::disk('zip')->put($zipFileName, file_get_contents($zipPath));
            unlink($zipPath);

            return response()->json(['downloadUrl' => url("/download/zipfile/$zipFileName")]);
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
}
