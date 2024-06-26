<?php

namespace App\Http\Controllers\Frontoffice;

use App\Helper\ExamHelper;

use App\Helper\PlatformHelper;
use App\Http\Controllers\Controller;
use App\Models\TTestimony;
use App\Models\TTypeExam;
use App\Models\TExam;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

use Illuminate\Contracts\Routing\ResponseFactory;

class GeneralController extends Controller
{
    public function actionWelcome()
    {
        $tTypeExam = TTypeExam::tTypeExamFront();
        $topExams = TExam::with(['tTypeExam', 'tUserExam.tUser', 'tDirection'])
            ->whereHas('tUserExam', function ($query) {
                $query->where('typeFunctionExam', 'Registro');
            })
            ->orderBy('view_counter', 'desc')
            ->take(3)
            ->get();

        $tTotalTypeExams = TTypeExam::select('ttypeexam.idTypeExam', 'ttypeexam.acronymTypeExam')
            ->leftJoin('texam', 'ttypeexam.idTypeExam', '=', 'texam.idTypeExam')
            ->where('texam.stateExam', '=', 'Publico')
            ->groupBy('ttypeexam.idTypeExam', 'ttypeexam.acronymTypeExam')
            ->selectRaw('COUNT(texam.idExam) as totalExam')
            ->get();

        $tTotalTestimonys = TTestimony::where('is_public', TTestimony::STATE['PUBLIC'])->orderBy('created_at', 'DESC')->paginate(10);

        ExamHelper::getRatingAndUser($topExams);

        return view(
            'frontoffice/general/welcome',
            [
                'tTypeExam' => $tTypeExam,
                'topExams' => $topExams,
                'tTotalTypeExams' => $tTotalTypeExams,
                'tTotalTestimonys' => $tTotalTestimonys
            ]
        );
    }

    public function actionPrincipal()
    {
        return view('frontoffice/template');
    }

    public function actionWelcomeDashboard()
    {
        return view('general/panel');
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

            $directory_exam = storage_path('/app/file/exam');

            $zip->open($zip_directory, ZipArchive::CREATE || ZipArchive::OVERWRITE);

            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory_exam), RecursiveIteratorIterator::LEAVES_ONLY);

            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($directory_exam));

                    $zip->addFile($filePath, $relativePath);
                }
            }
            $zip->close();

            return $responseFactory->download(storage_path() . '/' . $zip_name, $zip_name)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), '/panel');
        }
    }
}
