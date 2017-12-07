<?php
/**
 * Created by PhpStorm.
 * User: 龙鲤
 * Date: 2017/11/4
 * Time: 12:31
 */

namespace app\index\model;


use think\Model;

class course extends Model
{
    protected $table = 'course';
    private $week = array('一','二','三','四','五','六','日');
    private $weekTime = array('19:30','8:10','10:10','14:20','16:20');
    private $user;
    private $course = array();//课表

    public function __construct($user)
    {
        parent::__construct();
        $this->user = $user;
        $this->setCourse();
    }

    //获取课程表
    public function setCourse(){
        //获取查询结果
        $user = $this->user;
        $sql = "SELECT * FROM `course` WHERE `bianhao` IN (SELECT course_id FROM stu_course WHERE stu_id = $user)";
        $course = $this->query($sql);
        $courseRe = array();
        //根据课表中的time字段对课表进行排序
        foreach ($course as $cArray){
            $tArray = preg_split('/,/',$cArray['time']);//通过，对time进行分割
            $crArray = preg_split('/<br>/',$cArray['classroom']);//通过<br>,对教室进行分割，分割后教室与time一一对应
            //如果存在上课时间time
            if(!empty($tArray[0])){
                foreach ($tArray as $key => $time){
                    //用新数组course来接收结果
                    $courseRe[$time]['coursename'] = $cArray['coursename'];
                    $courseRe[$time]['teacher'] = $cArray['teacher'];
                    $courseRe[$time]['weekmessage'] = $cArray['weekmessage'];
                    $courseRe[$time]['week'] = $cArray['week'];
                    $courseRe[$time]['campus'] = $cArray['campus'];
                    $courseRe[$time]['classroom'] = $crArray[$key];
                }
            }
        }
        $this->course = $courseRe;
    }

    //现实的时间转化为周次时间（星期几第几节课）
    private function timeToWeektime(){
        $day = date('w');
        $timeDay = ($day+6)%7;
        $time = date('G');
        switch ($time){
            case $time<9:
                $timeNum = 1;
                break;
            case $time<11:
                $timeNum = 2;
                break;
            case $time<15:
                $timeNum = 3;
                break;
            case $time<17:
                $timeNum = 4;
                break;
            case $time<20:
                $timeNum = 5;
                break;
            default:
                $timeNum = 6;
                break;
        }
        $weekTime = $timeNum+$timeDay*5;
        return $weekTime;
    }

    //周次时间转化为现实时间
    private function weektimeToTime($weektime){

    }

    //获取course
    public function getCourse(){
        $course = array();
        foreach ($this->course as $key=>$val){
            preg_match('/\d+/',$val['coursename'],$num);
            $val['coursename'] = str_replace($num[0],'',$val['coursename']);
            $course[$key-1] = $val;
        }
        return $course;
    }

    public function getWeekDay(){
        $day = date('w');
        $timeDay = ($day+6)%7;
        return $this->week[$timeDay];
    }

    //获取今日课程
    public function getTodayCourse($week){
        $course = $this->course;  //获取课表
        $day = date('w');
        $timeDay = ($day+6)%7+1;
        $todayCourse=array();
        $camWeek = pow(2,$week-1);
        foreach ($course as $key=>$val){
            if($key/5==$timeDay&&($val['week']&$camWeek)){
                $val['time'] = $this->weekTime[$key%5];
                $todayCourse[$key] = $val;
            }
        }
        if(empty($todayCourse)){
            return array('notice'=>0);
        }else{
            return $todayCourse;
        }
    }
}