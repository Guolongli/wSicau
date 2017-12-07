<?php
/**
 * Created by PhpStorm.
 * User: 龙鲤
 * Date: 2017/11/17
 * Time: 15:38
 */

namespace app\index\controller;


use app\index\model\grade;
use app\index\model\stuList;
use think\Request;

class My extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    public function index(){
        $stu = new stuList($this->userSession);
        $stuData = $stu->getStuData();
        return json($stuData);
    }

    public function grade(){
        $grade = new grade($this->userSession);
        return json($grade->getGData());
    }
}