<?php
namespace app\index\controller;

use app\index\model\admin;
use app\index\model\loginSicau;
use app\index\model\user;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $openid = input('openId');
        //new user对象,并对openid进行判定
        $user = new user($openid);
        $checkOpenid = $user->checkOpenid();
        switch ($checkOpenid){
            //如果返回-1，则是非法提交，返回对应信息
            case -1:
                $returnJson = returnJson(-1,'非法请求');
                break;
            //如果返回0，则是还未绑定账号
            case 0:
                $returnJson = returnJson(0,'验证未通过，用户数据未绑定');
                break;
            case 1;
            //如果返回为1，则说明用户请求成功，并绑定账户，进行后续一些操作。。。
                $user->updateTime();
                $returnJson = returnJson(1,'验证通过');
                break;
        }
        return $returnJson;
    }

    public function login(){
        $login = new loginSicau(input('user'),input('password'));
        $result = $login->CheckLoad();
        //判断到教务处验证的结果
        if($result!=false){
            $user = new user(input('openId'));
            if($user->checkUniqueUser(input('user'))==2){
                $checkLogin = $user->insertUser(input('user'));
                //判断返回参数
                if($checkLogin == 1){
                    //插入数据库成功
                    $returnJson = returnJson(1,'登陆成功');
                }else{
                    $returnJson = returnJson(-1,'数据插入失败，请联系管理员');
                }
            }else if($user->checkUniqueUser(input('user'))==1){
                $user->updateTime();
                $returnJson = returnJson(1,'登陆成功');
            }else{
                $returnJson = returnJson(0,'该学号已经绑定了微信账号!');
            }
        }else{
            $returnJson = returnJson(0,'账号或密码错误');
        }
        return $returnJson;
    }

    public function getOpenId(){
        $code = input('code');
        if($code){
            $admin = new admin($code);
            return $admin -> getOpenId();
        }else{
            return '无法获取信息';
        }
    }
}
