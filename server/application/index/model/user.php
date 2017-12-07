<?php
/**
 * Created by PhpStorm.
 * User: 龙鲤
 * Date: 2017/10/20
 * Time: 15:14
 */

namespace app\index\model;

use think\Model;

class user extends Model
{
    protected $table = 'user';
    private $openid ;

    public function __construct($openid ='')
    {
        parent::__construct();
        $this->openid = $openid ;
    }

    //验证openid之前是否存在，即该微信用户是否绑定学号
    public function checkOpenid()
    {
        //是否有post提交
        if (!is_null($this->openid)) {
            $account = $this->getUser();
            //通过验证$account是否为空来验证用户之前是否绑定
            if (empty($account)) {
                //如果为空，说明之前没有绑定，返回false
                return 0;
            } else {
                //返回true
                return 1;
            }
        } else {
            return -1;
        }
    }

    //更新时间
    public function updateTime(){
        if($this->openid ){
            $this->save(['time'=>date("Y-m-d H:i:s")],['wopenid'=>$this->openid ]);
        }
    }

    //获取user账户
    public function getUser(){
        $account = $this->where('wopenid', '=', $this->openid )->field('account')->select();
        if(empty($account)){
            return null;
        }else{
            return $account[0]->openid;
        }
    }

    //判断学号是否唯一
    public function checkUniqueUser($user){
        $checkUser = $this->where('account', '=', $user )->field('wopenid')->select();
        if(!empty($checkUser)){
            if($checkUser[0]->openid['wopenid'] == $this->openid){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 2;
        }
    }

    //将数据插入数据库
    public function insertUser($user='')
    {
        if(isset($user)&&isset($this->openid )){
            //如果user和openid存在
            $this->save(['wopenid'=>$this->openid ,'account'=>$user,'status'=>getSOrT($user),'time'=>date('Y-m-d H:i:s')]);//插入数据库
            $_SESSION['user'] = $user;//设置session
            return 1;
        }else{
            return 0;
        }
    }
}