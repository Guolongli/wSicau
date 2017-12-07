<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//返回json数据格式
function returnJson($code=0,$message='',$data=array()){
    return json(['code'=>$code,'message'=>$message,'data'=>$data]);
}
//判断账号是学生还是老师
function getSOrT($account){
    if(isset($account)&&$account<8){
        return 'T';
    }else{
        return 'S';
    }
}