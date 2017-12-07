<?php
/**
 * Created by PhpStorm.
 * User: 龙鲤
 * Date: 2017/11/12
 * Time: 14:57
 */

namespace app\index\controller;


use app\index\model\indexSicau;
use app\index\model\stuList;
use think\Request;

class Home extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    public function index(){
        $indexSicau = new indexSicau();
        $week = $indexSicau->getWeek();
        $course = new \app\index\model\course($this->userSession);
        $todayCourse = $course->getTodayCourse($week);
        $weekDay = $course->getWeekDay();
        $stu = new stuList($this->userSession);
        $stuData = $stu->getStuData();
        $notice = $indexSicau->getNotice($stuData['campus']);
        return json(array('weekNum'=>$week,'weekDay'=>$weekDay,'todayCourse'=>$todayCourse,'notice'=>$notice));
    }
}