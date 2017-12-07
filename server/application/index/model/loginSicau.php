<?php
/**
 * Created by PhpStorm.
 * User: 龙鲤
 * Date: 2017/11/16
 * Time: 10:34
 */

namespace app\index\model;


class loginSicau extends indexSicau
{
    private $lb;	//类型
    private $user; //账户
    private $pwd; //密码
    public $load;   //登录页面

    function __construct($user,$pwd)
    {
        parent::__construct();
        $this->user = $user;
        $this->pwd = $pwd;
        $this->lb = getSOrT($this->user);
    }

    //模拟js的fromCharCode函数用于加密
    private function fromCharCode($codes) {
        if (is_scalar($codes)) $codes= func_get_args();
        $str= '';
        foreach ($codes as $code) $str.= chr($code);
        return $str;
    }

    //模拟js的charCodeAt函数进行编码转换
    private function charCodeAt($str, $index){
        $char = mb_substr($str, $index, 1, 'UTF-8');
        if (mb_check_encoding($char, 'UTF-8'))
        {
            $ret = mb_convert_encoding($char, 'UTF-32BE', 'UTF-8');
            return hexdec(bin2hex($ret));
        }
        else
        {
            return null;
        }
    }

    //对密码进行模拟加密
    private function password($pass,$dcode2){
        $dcode=$pass;
        $dcode1="";
        $dcode2="".$dcode2*137;
        $dcodelen=strlen($dcode);
        for($i=1;$i<=$dcodelen;$i++){
            $tmpstr=substr($dcode,$i-1,1);
            $dcode1=$dcode1.$this->fromCharCode($this->charCodeAt($tmpstr,0)-$i-substr($dcode2,$i-1,1));
        }
        return $dcode1;
    }

    //进行模拟登录
    private function Load(){
        $this->setCookie();
        $cookie = $this->cookie;
        $this->setDcode2();
        $d=$this->dcode2;
        $p=$this->password($this->pwd,$d);
        $p=urlencode($p);
        $data="user=".$this->user."&pwd=".$p."&lb=".$this->lb."&submit=";
        $url="http://jiaowu.sicau.edu.cn/jiaoshi/bangong/check.asp";
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_REFERER, $url);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_COOKIE, $cookie);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION, 1);
        $ret=curl_exec($ch);
        curl_close($ch);
        $ret=iconv('gbk', 'utf-8', $ret);
        return $ret;
    }

    //用于登录验证
    public function CheckLoad(){
        $result = $this->Load();
        if ($this->lb=="S"){
            $ret=strpos($result, "Location: ../../xuesheng/bangong/main/index1.asp");
        }elseif ($this->lb=="T"){
            $ret=strpos($result, "Location: main/note.asp");
        }
        return $ret;
    }
}