<?php
/**
 * Created by PhpStorm.
 * User: 龙鲤
 * Date: 2017/11/17
 * Time: 18:44
 */

namespace app\index\model;


use think\Model;

class major extends Model
{
    protected $table = 'major';
    private $mId;
    private $mName;

    public function __construct($mId)
    {
        parent::__construct();
        $this->mId = $mId;
    }

    private function setName(){
        $result = $this->where('id','=',$this->mId)->select();
        $this->mName = $result[0]->mId['name'];
    }

    public function getName(){
        $this->setName();
        return $this->mName;
    }
}