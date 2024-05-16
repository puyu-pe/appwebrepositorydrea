<?php

namespace App\Http\Controllers;

use App\Models\TGrade;
use App\Models\TSubject;
use App\Models\TTypeExam;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Object\DtoMessage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $_so;
    protected $_currentDate;
    protected $menuTypeExamItem;
    protected $menuSubjectItem;
    protected $menuGradeItem;

    public function __construct()
    {
        $this->_so= new \stdClass();
        $this->_so->mo= new DtoMessage;
        $this->_so->dto= new \stdClass();
        $this->menuTypeExamItem = TTypeExam::tTypeExamFront();
        $this->menuSubjectItem = TSubject::tSubjectExamFront();
        $this->menuGradeItem = TGrade::tGradeExamFront();

        view()->share('menuTypeExamItem', $this->menuTypeExamItem);
        view()->share('menuSubjectItem', $this->menuSubjectItem);
        view()->share('menuGradeItem', $this->menuGradeItem);

        $this->_currentDate=date('Y-m-d H:i:s');
    }
}
