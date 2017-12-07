<?php
/**
 * Created by PhpStorm.
 * User: 龙鲤
 * Date: 2017/11/17
 * Time: 19:18
 */

namespace app\index\model;


use think\Model;

class grade extends Model
{
    protected $table = 'grade';
    private $sId;   //学号
    private $gData = array(); //成绩

    public function __construct($sId)
    {
        parent::__construct();
        $this->sId = $sId;
    }

    private function setGData(){
        $result = $this->where('studentid','=',$this->sId)->order('semester')->select();
        for($i=0;$i<count($result);$i++){
            $this->gData[$i] = array('semester'=>$result[$i]->sId['semester'],'courseName'=>$result[$i]->sId['coursename'],'credits'=>$result[$i]->sId['credits'],'grade'=>$result[$i]->sId['grade'],'nature'=>$result[$i]->sId['nature']);
        }
    }

    public function getGData(){
        $this->setGData();
        return $this->gData;
    }
}