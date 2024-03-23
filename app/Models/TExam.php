<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TExam extends Model
{
    protected $table = 'texam';
    protected $primaryKey = 'idExam';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    public const STATUS = [
        'PUBLIC' => 'Publico',
        'HIDDEN' => 'Oculto',
    ];

    public const REGISTER_RESPONSE = [
        'YES' => '1',
        'NO' => '0',
    ];

    public function tTypeExam()
    {
        return $this->belongsTo('App\Models\TTypeExam', 'idTypeExam');
    }

    public function tSubject()
    {
        return $this->belongsTo('App\Models\TSubject', 'idSubject');
    }

    public function tGrade()
    {
        return $this->belongsTo('App\Models\TGrade', 'idGrade');
    }

    public function tAnswer()
    {
        return $this->hasMany('App\Models\TAnswer', 'idExam');
    }

    public function tUserExam()
    {
        return $this->hasMany('App\Models\TUserExam', 'idExam');
    }

    public function tDirection()
    {
        return $this->belongsTo('App\Models\TDirection', 'idDirection');
    }

    public function tExamRating()
    {
        return $this->hasMany('App\Models\TExamRating', 'idExam');
    }

    //REPORTES

    public static function totals()
    {
        $totalExams = Texam::count();
        $totalPublicExams = Texam::where('stateExam', 'Publico')->count();
        $totalHiddenExams = Texam::where('stateExam', 'Oculto')->count();

        $data = [
            'total_exam' => $totalExams,
            'total_exam_public' => $totalPublicExams,
            'total_exam_hidden' => $totalHiddenExams
        ];

        return response()->json($data);
    }

    public static function totalsBySubject()
    {
        $colors = ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#8e44ad', '#27ae60', '#f1c40f', '#3498db'];

        $examCounts = TExam::select('idSubject', \DB::raw('COUNT(*) as count'))
            ->groupBy('idSubject')
            ->orderBy('count', 'desc')
            ->get();
        $subjects = TSubject::all();
        $PieData = [];
        $colorIndex = 0;
        foreach ($examCounts as $examCount) {
            $subject = $subjects->where('idSubject', $examCount->idSubject)->first();
            $PieData[] = [
                'value' => $examCount->count,
                'color' => $colors[$colorIndex],
                'highlight' => $colors[$colorIndex],
                'label' => $subject->nameSubject
            ];
            $colorIndex++;
        }

        return response()->json($PieData);
    }

    public static function topMostViewed()
    {
        $topMostViewedExams = Texam::select('texam.idExam', 'texam.codeExam', 'texam.yearExam', 'texam.nameExam', 'texam.view_counter', \DB::raw('AVG(texamrating.rating) as average_rating'))
            ->leftJoin('texamrating', 'texam.idExam', '=', 'texamrating.idExam')
            ->groupBy('texam.idExam', 'texam.codeExam', 'texam.yearExam', 'texam.nameExam', 'texam.view_counter')
            ->orderBy('texam.view_counter', 'desc')
            ->limit(10)
            ->get();

        return response()->json($topMostViewedExams);
    }

}

?>
