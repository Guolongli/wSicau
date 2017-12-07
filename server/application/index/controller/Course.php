<?php
/**
 * Created by PhpStorm.
 * User: 龙鲤
 * Date: 2017/11/4
 * Time: 12:26
 */

namespace app\index\controller;

use think\Request;

class Course extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    //获取用户课表
    public function index(){
        $course = new \app\index\model\course($this->userSession);
        return json($course->getCourse());
    }
}