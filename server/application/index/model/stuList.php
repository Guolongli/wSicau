<?php
/**
 * Created by PhpStorm.
 * User: 龙鲤
 * Date: 2017/11/16
 * Time: 13:15
 */

namespace app\index\model;


use think\Model;

class stuList extends Model
{
    protected $table = 'stu_list';
    private $stuNu;     //学生学号
    private $stuName;      //学生姓名
    private $banji;     //班级
    private $major;     //专业
    private $campus;    //校区

    public function __construct($stu)
    {
        parent::__construct();
        $this->stuNu = $stu;
    }

    //根据学号查出的所有数据
    private function setStuData(){
        $result = $this->where('stu_no','=',$this->stuNu)->select();
        $this->stuName = $result[0]->stuNu['stu_name'];            //姓名
        $this->campus = $result[0]->stuNu['school_zone'];       //校区
        $banji = new banji($result[0]->stuNu['classes']);
        $this->banji = $banji->getName();                       //班级
        $major = new major($result[0]->stuNu['major']);
        $this->major = $major->getName();                       //专业
    }

    //获取学生信息
    public function getStuData(){
        $this->setStuData();
        return array('num'=>$this->stuNu,'name'=>$this->stuName,'banji'=>$this->banji,'major'=>$this->major,'campus'=>$this->campus);
    }

}