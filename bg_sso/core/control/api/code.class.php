<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_CLASS . "api.class.php"); //载入模板类
include_once(BG_PATH_CLASS . "crypt.class.php"); //载入模板类
include_once(BG_PATH_CLASS . "sign.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "app.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "log.class.php"); //载入管理帐号模型

/*-------------用户类-------------*/
class API_CODE {

    private $obj_api;
    private $log;
    private $mdl_app;
    private $appAllow;
    private $appRequest;

    function __construct() { //构造函数
        $this->obj_api      = new CLASS_API();
        $this->obj_api->chk_install();
        $this->log          = $this->obj_api->log; //初始化 AJAX 基对象
        $this->obj_crypt    = new CLASS_CRYPT();
        $this->obj_sign     = new CLASS_SIGN();
        $this->mdl_app      = new MODEL_APP(); //设置管理组模型
        $this->mdl_log      = new MODEL_LOG(); //设置管理员模型
    }


    /**
     * api_encode function.
     *
     * @access public
     * @return void
     */
    function api_encode() {
        $this->app_check("post");

        $_arr_data = validateStr(fn_post("data"), 1, 0);
        switch ($_arr_data["status"]) {
            case "too_short":
                $_arr_return = array(
                    "alert" => "x050222",
                );
                $this->obj_api->halt_re($_arr_return);
            break;

            case "ok":
                $_str_data = fn_htmlcode($_arr_data["str"], "decode");
            break;
        }

        $_arr_sign = array(
            "act_post"   => $GLOBALS["act_post"],
            "data"       => $_str_data,
        );

        if (!$this->obj_sign->sign_check(array_merge($this->appRequest, $_arr_sign), $this->appRequest["signature"])) {
            $_arr_return = array(
                "alert" => "x050403",
            );
            $this->obj_api->halt_re($_arr_return);
        }

        $_str_code = $this->obj_crypt->encrypt($_str_data, $this->appRow["app_key"]);

        $_arr_return = array(
            "code"   => $_str_code,
            "alert"  => "y050405",
        );

        $this->obj_api->halt_re($_arr_return);
    }


    /**
     * api_decode function.
     *
     * @access public
     * @return void
     */
    function api_decode() {
        $this->app_check("post");

        $_arr_code = validateStr(fn_post("code"), 1, 0);
        switch ($_arr_code["status"]) {
            case "too_short":
                $_arr_return = array(
                    "alert" => "x050223",
                );
                $this->obj_api->halt_re($_arr_return);
            break;

            case "ok":
                $_str_code = $_arr_code["str"];
            break;
        }

        $_arr_sign = array(
            "act_post"   => $GLOBALS["act_post"],
            "code"       => $_str_code,
        );

        if (!$this->obj_sign->sign_check(array_merge($this->appRequest, $_arr_sign), $this->appRequest["signature"])) {
            $_arr_return = array(
                "alert" => "x050403",
            );
            $this->obj_api->halt_re($_arr_return);
        }

        $_str_result  = $this->obj_crypt->decrypt($_str_code, $this->appRow["app_key"]);

        exit($_str_result);
    }


    /**
     * app_check function.
     *
     * @access private
     * @return void
     */
    private function app_check($str_method = "get") {
        $this->appRequest = $this->obj_api->app_request($str_method);

        if ($this->appRequest["alert"] != "ok") {
            $this->obj_api->halt_re($this->appRequest);
        }

        $this->appRow = $this->mdl_app->mdl_read($this->appRequest["app_id"]);
        if ($this->appRow["alert"] != "y050102") {
            $this->log_do($this->appRow, "read");
            $this->obj_api->halt_re($this->appRow);
        }

        $_arr_appChk = $this->obj_api->app_chk($this->appRequest, $this->appRow);
        if ($_arr_appChk["alert"] != "ok") {
            $this->log_do($_arr_appChk, "check");
            $this->obj_api->halt_re($_arr_appChk);
        }
    }


    /**
     * log_do function.
     *
     * @access private
     * @param mixed $arr_logResult
     * @param mixed $str_logType
     * @return void
     */
    private function log_do($arr_logResult, $str_logType) {
        $_arr_targets[] = array(
            "app_id" => $this->appRequest["app_id"],
        );
        $_str_targets     = json_encode($_arr_targets);
        $_str_logResult   = json_encode($arr_logResult);

        $_arr_logData = array(
            "log_targets"        => $_str_targets,
            "log_target_type"    => "app",
            "log_title"          => $this->log["app"][$str_logType],
            "log_result"         => $_str_logResult,
            "log_type"           => "app",
        );

        $this->mdl_log->mdl_submit($_arr_logData, $this->appRequest["app_id"]);
    }
}
