<?php
/**
 * Created by PhpStorm.
 * User: 龙鲤
 * Date: 2017/11/4
 * Time: 12:26
 */

namespace app\index\controller;


use app\index\model\user;
use think\Controller;
use think\Request;

class Base extends Controller
{
    protected $userSession;    //通过传递过来的openid获取学号/工号

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $openid = input('openId');
        $u = new user($openid);
        $result = $u->getUser();
        if(empty($result)){
            print_r(returnJson('555','非法请求'));die;
        }else{
            $this->userSession = $result['account'];
        }
    }




}