<?php
/**
 * Created by PhpStorm.
 * User: 龙鲤
 * Date: 2017/11/17
 * Time: 18:40
 */

namespace app\index\model;


use think\Model;

class banji extends Model
{
    protected $table = 'classes';
    private $banjiId;
    private $bName;

    public function __construct($banjiId)
    {
        parent::__construct();
        $this->banjiId = $banjiId;
    }

    private function setName(){
        $result = $this->where('id','=',$this->banjiId)->select();
        $this->bName = $result[0]->banjiId['name'];
    }

    public function getName(){
        $this->setName();
        return $this->bName;
    }
}