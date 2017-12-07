<?php
/**
 * Created by PhpStorm.
 * User: 龙鲤
 * Date: 2017/11/20
 * Time: 16:55
 */

namespace app\index\model;


use think\Model;

class admin extends Model
{
    private $appid = '';   //小程序的appid
    private $secret = '';//小程序的secret
    private $openId;
    private $code;

    public function __construct($code)
    {
        parent::__construct();
        $this->code = $code;
    }

	//通过微信接口获取用户的openid
    private function setOpenid(){
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' .$this->appid. '&secret=' .$this->secret. '&js_code=' .$this->code. '&grant_type=authorization_code';
        $res = file_get_contents($url);
        $jsonReturn = json_decode($res);
        if(isset($jsonReturn->openid)){
            $this->openId = sha1($jsonReturn->openid);
        }else{
            $this->openId = '无法获取信息';
        }
    }

    public function getOpenId(){
        $this->setOpenid();
        return $this->openId;
    }
}