<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

$arr_set = array(
    'base'          => true, //基本设置
    'ssin'          => true, //启用会话
    'db'            => true, //连接数据库
);

$obj_runtime->run($arr_set);

$ctrl_login = new CONTROL_CONSOLE_REQUEST_LOGIN(); //初始化登录

switch ($GLOBALS['method']) {
    case 'post':
        switch ($GLOBALS['route']['bg_act']) {
            case 'login':
                $ctrl_login->ctrl_login(); //登录
            break;
        }
    break;
}