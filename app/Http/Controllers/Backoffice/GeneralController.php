<?php

namespace App\Http\Controllers\Backoffice;

use App\Helper\PlatformHelper;
use App\Http\Controllers\Controller;
use App\Models\TExam;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

use Illuminate\Contracts\Routing\ResponseFactory;

class GeneralController extends Controller
{
    public function actionWelcomeDashboard()
    {
        return view('backoffice/general/panel');
    }

    public function actionBackupDatabase(ResponseFactory $responseFactory)
    {
        try {
            $db_database = env('DB_DATABASE');
            $db_user = env('DB_USERNAME');
            $db_password = env('DB_PASSWORD');
            $db_date = date('Y-m-d_H-i-s');

            $fileName = $db_database . '_' . $db_date . '.sql';
            $fileNameDownload = 'backup_' . $db_database . '_' . $db_date . '.sql';

            $directory = storage_path('/' . $fileName);

            $dump = "mysqldump $db_database -B -v --opt --events --routines --triggers --default-character-set=utf8 --user=$db_user --password=$db_password > $directory";

            //$dump="mysqldump $db_database --column-statistics=0 -B -v --opt --events --routines --triggers --default-character-set=utf8 --user=$db_user --password=$db_password > $directory";

            exec($dump);

            return $responseFactory->download(storage_path() . '/' . $fileName, $fileNameDownload)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
        }
    }

    public function actionDownloadExam(ResponseFactory $responseFactory)
    {
        try {
            $db_date = date('Y-m-d_H-i-s');

            $zip = new ZipArchive();

            $zip_name = 'backup_exam_' . $db_date . '.zip';
            $zip_directory = storage_path('/' . $zip_name);
            $zip->open($zip_directory, ZipArchive::CREATE || ZipArchive::OVERWRITE);
            $files = TExam::all();

            foreach ($files as $file) {
                $filename = $file->idExam . '.' . $file->extensionExam;
                $zip->addFile(storage_path('app/file/exam/' . $filename), $file->yearExam . '-' . $file->nameExam . '.' . $file->extensionExam);
            }
            $zip->close();

            return $responseFactory->download(storage_path() . '/' . $zip_name, $zip_name)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), '/panel');
        }
    }
}
