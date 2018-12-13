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
function returnApiSuccess($msg = null, $data) {
    $result = array(
        'flag' => 'Success',
        'msg' => $msg,
        'data' => $data
    );
    header("Access-Control-Allow-Origin: *");
    header("Content-type: text/html; charset=utf-8");
    print json_encode($result, JSON_UNESCAPED_UNICODE);
}
/**
 * @param null $msg  返回正确的提示信息
 * @param flag success CURD 操作成功
 * @param array $data 具体返回信息
 * Function descript: 返回带参数，标志信息，提示信息的json 数组
 *
 */
function returnSuccess($data = array()) {
    $result = array(
        'flag' => 'Success',
        'data' => $data
    );
    header("Access-Control-Allow-Origin: *");
    header("Content-type: text/html; charset=utf-8");
    print json_encode($result, JSON_UNESCAPED_UNICODE);
}

/**
 * @param null $msg  返回具体错误的提示信息
 * @param flag success CURD 操作失败
 * Function descript:返回标志信息 ‘Error'，和提示信息的json 数组
 */
function returnApiError($msg = null) {
    $result = array(
        'flag' => 'Error',
        'msg' => $msg,
    );
    header("Access-Control-Allow-Origin: *");
    header("Content-type: text/html; charset=utf-8");
    print json_encode($result, JSON_UNESCAPED_UNICODE);
}

//删除session文件
function delSessionFile($id){
    $dir='D:/xampp/htdocs/tmp/';
    $dh=opendir($dir); 
    while ($file=readdir($dh)) { 
        if(strstr($file,$id)) { 
            unlink($dir.$file); 
            return;
        }  
    } 
}

function returnSuccessLogin($msg,$data = array()) {
    $result = array(
        'flag' => 'Success',
        'msg' => $msg,
        'data' => $data
    );
    header("Access-Control-Allow-Origin: *");
    header("Content-type: text/html; charset=utf-8");
    print json_encode($result, JSON_UNESCAPED_UNICODE);
}

