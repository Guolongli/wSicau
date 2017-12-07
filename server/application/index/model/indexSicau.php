<?php
/**
 * Created by PhpStorm.
 * User: 龙鲤
 * Date: 2017/11/16
 * Time: 8:37
 */

namespace app\index\model;


use think\Model;

class indexSicau extends Model
{
    private $index;   //存放教务处主页面
    protected $cookie;  //存放cookie
    protected $dcode2; //存放dcode2，dcode2与cookie一一对应
    private $notice = array(); //存放三校区以及总的教务通知
    private $week; //获取当前周次

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->setIndex();  //因为该类几乎所有操作都基于首页面，所以将首页面写在构造函数中
    }

    /**
     * 获取index界面
     */
    private function setIndex(){
        $url = 'http://jiaowu.sicau.edu.cn/web/web/web/index.asp';//教务处首页网址
        $ch = curl_init();  //开启curl请求，需要开启apache的curl扩展
        curl_setopt($ch, CURLOPT_URL, $url);//请求网址
        curl_setopt($ch, CURLOPT_HEADER, 1);//是否返回头部信息，因为要获取cookie，所以此处选择获取
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//是否返回页面信息
        $ret=curl_exec($ch);//执行curl
        curl_close($ch);//关闭curl
        $this->index =iconv('gbk', 'utf-8', $ret); //进行转码
    }

    /**
     * 获取页面cookie
     */
    protected function setCookie(){
        preg_match('/Set-Cookie:(.*);/iU',$this->index,$str);
        $this->cookie = $str[1];
    }

    /**
     * 获取dcode2，与cookie对应
     */
    protected function setDcode2(){
        $start=strpos($this->index,'dcode2=');
        $this->dcode2=substr($this->index,$start+7,10);
    }

    /**
     * 获取教学周
     */
    private function setWeek(){
        preg_match('/第(.*)教学周/',$this->index,$str);
        $this->week = $str[1];
    }

    public function getWeek(){
        $this->setWeek();
        return $this->week;
    }

    /**
     * 获取三校区通知
     */
    private function setNotice($campus){
        switch ($campus){
            case '雅安':
                $this->notice= $this->matchNotice('tabcontent1');
                break;
            case '成都':
                $this->notice = $this->matchNotice('tabcontent2');
                break;
            case '都江堰':
                $this->notice = $this->matchNotice('tabcontent3');
                break;
        }
    }

    public function getNotice($campus){
        $this->setNotice($campus);
        return $this->notice;
    }

    /**
     * 匹配校区公告
     * @param $tabcontent 三个校区对应不同的id
     */
    private function matchNotice($tabcontent){
        //匹配校区的公告
        $pattern = "/<div id=\"".$tabcontent."\">[\w\W]*?<\/div>/";
        preg_match($pattern,$this->index,$str); //通过<div id="tabcontent*">将校区通知部分匹配出来
        $str[0] = str_replace("a href=\"..","a href=\"http://jiaowu.sicau.edu.cn/web/web",$str[0]);//将通知详情的链接前缀补齐
        preg_match_all("/<a href=\"([\w\W]*?)\" target=\"_parent\" title=\"([\w\W]*?)\">([\w\W]*?)<font color=gray>([\w\W]*?)<\/font><\/a>/",$str[0],$noticeAll);//正则匹配每一条通知数据
        //将匹配出来的数据进行矩阵转秩
        for($i=0;$i<count($noticeAll[1]);$i++){
            $notice[$i]['href'] = $noticeAll[1][$i];
            $notice[$i]['title'] = $noticeAll[2][$i];
            $notice[$i]['font'] = $noticeAll[4][$i];
        }
        return $notice;
    }
}