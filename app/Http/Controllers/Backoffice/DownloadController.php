<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\TExam;
use App\Models\TGrade;
use App\Models\TResource;
use App\Models\TRole;
use App\Models\TSubject;
use App\Models\TTypeExam;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use ZipArchive;

class DownloadController extends Controller
{
    public function packZipFile(Request $request)
    {
        $mode = $request->input('mode');

        $files = collect();
        $downloadPayload = [];
        if ($mode == 'checked') {
            $downloadPayload = $this->normalizeRequestedExamIds($request->input('ids', []));
            $files = $this->resolveCheckedExams($downloadPayload);
        } else if ($mode == 'all') {
            $downloadPayload = $this->normalizeAllDownloadFilters($request->input('ids', []));
            $files = $this->resolveAllExams($downloadPayload);
        } else {
            return response()->json(['error' => 'Invalid mode specified'], 400);
        }

        if ($files->isEmpty()) {
            return response()->json(['error' => 'No se encontraron archivos permitidos para descargar'], 422);
        }

        $zip = new ZipArchive();
        $zipFileName = 'descarga_' . Str::random(40) . '.zip';
        $zipDirectory = $this->zipDirectoryPath();

        if (!is_dir($zipDirectory)) {
            mkdir($zipDirectory, 0755, true);
        }

        $zipPath = $this->zipFilePath($zipFileName);

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

            $this->storeZipDownloadAuthorization($request, $zipFileName, $mode, $downloadPayload, $files);

            return response()->json(['downloadUrl' => url("download/zip/$zipFileName")]);
        } else {
            return response()->json(['error' => 'No se pudo crear el archivo'], 500);
        }
    }

    public function downloadZipFile(Request $request, $filename)
    {
        $filePath = $this->zipFilePath($filename);

        if ($filePath !== null && file_exists($filePath) && $this->isZipDownloadAuthorized($request, $filename)) {
            $this->forgetZipDownloadAuthorization($request, $filename);

            return response()->download($filePath)->deleteFileAfterSend(true);
        } else {
            return response()->json(['error' => 'Archivo no encontrado: ' . $filename], 404);
        }
    }

    private function resolveAllExams($filters)
    {
        $search = $filters['search'];
        $type = $filters['type'];
        $grade = $filters['grade'];
        $subject = $filters['subject'];
        $year = $filters['year'];

        $tTypeExam = TTypeExam::where('acronymTypeExam', $type)->first();
        $tGrade = TGrade::where('codeGrade', $grade)->first();
        $tSubject = TSubject::where('codeSubject', $subject)->first();

        $exams = TExam::where('stateExam', TExam::STATUS['PUBLIC'])
            ->where(function ($query) use ($tSubject, $tGrade, $type, $grade, $subject, $year, $search, $tTypeExam) {
                if ($type !== 'all') {
                    if ($tTypeExam) {
                        $query->where('idTypeExam', $tTypeExam->idTypeExam);
                    } else {
                        $query->where('idTypeExam', $type);
                    }
                }
                if ($grade !== 'all') {
                    if ($tGrade) {
                        $query->where('idGrade', $tGrade->idGrade);
                    } else {
                        $query->where('idGrade', $grade);
                    }
                }
                if ($subject !== 'all') {
                    if ($tSubject) {
                        $query->where('idSubject', $tSubject->idSubject);
                    } else {
                        $query->where('idSubject', $subject);
                    }
                }
                if ($year !== 'all') {
                    $query->where('yearExam', $year);
                }
                if (!empty($search)) {
                    $query->whereRaw('compareFind(concat(codeExam, nameExam, descriptionExam), ?, 77) = 1', [$search]);
                }
            })
            ->get();

        return $this->filterExamsWithExistingFiles($exams);
    }

    private function resolveCheckedExams($ids)
    {
        $normalizedIds = $this->normalizeRequestedExamIds($ids);

        if (empty($normalizedIds)) {
            return collect();
        }

        $query = TExam::whereIn('idExam', $normalizedIds);

        if (!$this->canDownloadRestrictedExams()) {
            $query->where('stateExam', TExam::STATUS['PUBLIC']);
        }

        return $this->filterExamsWithExistingFiles($query->get());
    }

    private function filterExamsWithExistingFiles($exams)
    {
        return $exams->filter(function ($exam) {
            return file_exists(storage_path('app/file/exam/' . $exam->idExam . '.' . $exam->extensionExam));
        })->values();
    }

    private function normalizeAllDownloadFilters($filters)
    {
        return [
            'search' => is_array($filters) && array_key_exists('search', $filters) ? trim((string)$filters['search']) : '',
            'type' => $this->normalizeDownloadFilterValue($filters, 'type'),
            'grade' => $this->normalizeDownloadFilterValue($filters, 'grade'),
            'subject' => $this->normalizeDownloadFilterValue($filters, 'subject'),
            'year' => $this->normalizeDownloadFilterValue($filters, 'year'),
        ];
    }

    private function normalizeDownloadFilterValue($filters, $key)
    {
        if (!is_array($filters) || !array_key_exists($key, $filters)) {
            return 'all';
        }

        $value = trim((string)$filters[$key]);

        return $value === '' ? 'all' : $value;
    }

    private function storeZipDownloadAuthorization(Request $request, $filename, $mode, $payload, $files)
    {
        $downloadAuthorizations = $request->session()->get('downloadZipFiles', []);
        $downloadAuthorizations[$filename] = [
            'mode' => $mode,
            'payload' => $payload,
            'examIds' => $files->pluck('idExam')->map(function ($idExam) {
                return (string)$idExam;
            })->values()->all(),
        ];

        $request->session()->put('downloadZipFiles', $downloadAuthorizations);
    }

    private function isZipDownloadAuthorized(Request $request, $filename)
    {
        $downloadAuthorizations = $request->session()->get('downloadZipFiles', []);

        if (!is_array($downloadAuthorizations) || !array_key_exists($filename, $downloadAuthorizations)) {
            return false;
        }

        $downloadAuthorization = $downloadAuthorizations[$filename];

        if (!is_array($downloadAuthorization) || !array_key_exists('mode', $downloadAuthorization) || !array_key_exists('examIds', $downloadAuthorization)) {
            return false;
        }

        $storedExamIds = $this->normalizeRequestedExamIds($downloadAuthorization['examIds']);

        if (empty($storedExamIds)) {
            return false;
        }

        if ($downloadAuthorization['mode'] === 'all') {
            $authorizedExamIds = $this->resolveAllExams($this->normalizeAllDownloadFilters($downloadAuthorization['payload'] ?? []))
                ->pluck('idExam')
                ->map(function ($idExam) {
                    return (string)$idExam;
                })
                ->all();
        } else if ($downloadAuthorization['mode'] === 'checked') {
            $authorizedExamIds = $this->resolveCheckedExams($downloadAuthorization['payload'] ?? [])
                ->pluck('idExam')
                ->map(function ($idExam) {
                    return (string)$idExam;
                })
                ->all();
        } else {
            return false;
        }

        foreach ($storedExamIds as $storedExamId) {
            if (!in_array($storedExamId, $authorizedExamIds, true)) {
                return false;
            }
        }

        return true;
    }

    private function forgetZipDownloadAuthorization(Request $request, $filename)
    {
        $downloadAuthorizations = $request->session()->get('downloadZipFiles', []);

        if (!is_array($downloadAuthorizations) || !array_key_exists($filename, $downloadAuthorizations)) {
            return;
        }

        unset($downloadAuthorizations[$filename]);
        $request->session()->put('downloadZipFiles', $downloadAuthorizations);
    }

    private function normalizeRequestedExamIds($ids)
    {
        if (!is_array($ids)) {
            return [];
        }

        return array_values(array_unique(array_filter(array_map(function ($id) {
            return is_scalar($id) ? trim((string)$id) : '';
        }, $ids), function ($id) {
            return $id !== '';
        })));
    }

    private function canDownloadRestrictedExams()
    {
        $roleUser = (string)session('roleUser', '');

        return stristr($roleUser, TRole::ROLE['ADMIN']) !== false
            || stristr($roleUser, TRole::ROLE['SUPERVISOR']) !== false
            || stristr($roleUser, TRole::ROLE['REGISTER']) !== false;
    }

    private function formatFileName($filename){
        return preg_replace(['/ /', '/[\/\\\\]/', '/\./'], ['_', '', ''], $filename);
    }

    private function zipDirectoryPath()
    {
        return storage_path('app/public/zip');
    }

    private function zipFilePath($filename)
    {
        if (!$this->isValidZipFileName($filename)) {
            return null;
        }

        return $this->zipDirectoryPath() . DIRECTORY_SEPARATOR . $filename;
    }

    private function isValidZipFileName($filename)
    {
        return is_string($filename)
            && $filename === basename($filename)
            && preg_match('/^descarga_[A-Za-z0-9_-]+\.zip$/', $filename) === 1;
    }
}
