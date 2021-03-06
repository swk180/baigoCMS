<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------管理员模型-------------*/
class MODEL_ADMIN_FORGOT extends MODEL_ADMIN {

    function __construct() { //构造函数
        $this->obj_db = $GLOBALS['obj_db']; //设置数据库对象
    }

    function input_bymail() {
        if (!fn_captcha()) { //验证码
            return array(
                'rcode'     => 'x030205',
            );
        }

        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $_arr_adminName = fn_validate(fn_post('admin_name'), 1, 0);
        switch ($_arr_adminName['status']) {
            case 'too_short':
                return array(
                    'rcode'     => 'x010201',
                );
            break;

            case 'ok':
                $this->bymailInput['admin_name'] = $_arr_adminName['str'];
            break;
        }

        $this->bymailInput['rcode'] = 'ok';

        return $this->bymailInput;
    }


    function input_byqa() {
        if (!fn_captcha()) { //验证码
            return array(
                'rcode'     => 'x030205',
            );
        }

        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }


        $_arr_adminName = fn_validate(fn_post('admin_name'), 1, 0);
        switch ($_arr_adminName['status']) {
            case 'too_short':
                return array(
                    'rcode'     => 'x010201',
                );
            break;

            case 'ok':
                $this->byqaInput['admin_name'] = $_arr_adminName['str'];
            break;
        }

        for ($_iii = 1; $_iii <= 3; $_iii++) {
            $_arr_adminSecAnsw = fn_validate(fn_post('admin_sec_answ_' . $_iii), 1, 0);
            switch ($_arr_adminSecAnsw['status']) {
                case 'too_short':
                    return array(
                        'rcode' => 'x010237',
                    );
                break;

                case 'ok':
                    $this->byqaInput['admin_sec_answ_' . $_iii] = $_arr_adminSecAnsw['str'];
                break;
            }
        }

        $_arr_adminPassNew = fn_validate(fn_post('admin_pass_new'), 1, 0);
        switch ($_arr_adminPassNew['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x010222',
                );
            break;

            case 'ok':
                $this->byqaInput['admin_pass_new'] = $_arr_adminPassNew['str'];
            break;
        }

        $_arr_adminPassConfirm = fn_validate(fn_post('admin_pass_confirm'), 1, 0);
        switch ($_arr_adminPassConfirm['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x010224',
                );
            break;

            case 'ok':
                $this->byqaInput['admin_pass_confirm'] = $_arr_adminPassConfirm['str'];
            break;
        }

        if ($this->byqaInput['admin_pass_new'] != $this->byqaInput['admin_pass_confirm']) {
            return array(
                'rcode' => 'x010225',
            );
        }

        $this->byqaInput['rcode']  = 'ok';

        return $this->byqaInput;
    }
}
