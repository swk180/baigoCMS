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
    'base'          => true,
    'ssin'          => true,
    'db'            => true,
);

$obj_runtime->run($arr_set);

$ctrl_cate = new CONTROL_CONSOLE_UI_CATE(); //初始化设置对象

switch ($GLOBALS['route']['bg_act']) {
    case 'order':
        $ctrl_cate->ctrl_order();
    break;

    case 'form':
        $ctrl_cate->ctrl_form();
    break;

    default:
        $ctrl_cate->ctrl_list();
    break;
}
