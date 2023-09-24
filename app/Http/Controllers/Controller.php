<?php

namespace App\Http\Controllers;

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

    public function __construct()
    {
        $this->_so= new \stdClass();
        $this->_so->mo= new DtoMessage;
        $this->_so->dto= new \stdClass();
        $this->menuTypeExamItem = TTypeExam::all();

        view()->share('menuTypeExamItem', $this->menuTypeExamItem);

        $this->_currentDate=date('Y-m-d H:i:s');
    }
}
