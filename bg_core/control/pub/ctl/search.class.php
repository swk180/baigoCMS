<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------文章类-------------*/
class CONTROL_SEARCH {

	private $obj_tpl;
	private $search;
	private $mdl_tag;
	private $mdl_tagBelong;
	private $mdl_article;
	private $mdl_attach;

	function __construct() { //构造函数
		$this->search_init();
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL_PUB . $this->config["tpl"]); //初始化视图对象
		$this->mdl_tag        = new MODEL_TAG();
		$this->mdl_tagBelong  = new MODEL_TAG_BELONG();
		$this->mdl_articlePub = new MODEL_ARTICLE_PUB(); //设置文章对象
		$this->mdl_attach     = new MODEL_ATTACH(); //设置文章对象
	}


	/**
	 * ctl_list function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_show() {
		if ($this->search["key"]) {
			$_num_articleCount    = $this->mdl_articlePub->mdl_count($this->search["key"]);
			$_arr_page            = fn_page($_num_articleCount); //取得分页数据
			$_str_query           = http_build_query($this->search);
			$_arr_articleRows     = $this->mdl_articlePub->mdl_list(BG_SITE_PERPAGE, $_arr_page["except"], $this->search["key"]);

			foreach ($_arr_articleRows as $_key=>$_value) {
				$_arr_tagBelongRows = $this->mdl_tagBelong->mdl_list($_value["article_id"]);
				foreach ($_arr_tagBelongRows as $_key_tag=>$_value_tag) {
					$_arr_tagRow = $this->mdl_tag->mdl_read($_value_tag["belong_tag_id"]);
					if ($_arr_tagRow["tag_status"] == "show") {
						$_arr_articleRows[$_key]["tagRows"][$_key_tag] = $_arr_tagRow;
					}
				}

				if ($_value["article_attach_id"] > 0) {
					$_arr_attachThumb                       = $this->mdl_thumb->mdl_list(100);
					$_arr_attachRow                         = $this->mdl_attach->mdl_read($_value["article_attach_id"]);
					$_arr_articleRows[$_key]["attachRow"]   = $this->mdl_attach->mdl_url($_arr_attachRow["attach_id"], $_arr_attachThumb);
				}
			}
		}

		$_arr_tplData = array(
			"query"          => $_str_query,
			"pageRow"        => $_arr_page,
			"search"         => $this->search,
			"articleRows"    => $_arr_articleRows,
		);

		$this->obj_tpl->tplDisplay("search_show.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y130102",
		);
	}


	private function search_init() {
		if(defined("BG_SITE_TPL")) {
			$this->config["tpl"] = BG_SITE_TPL;
		} else {
			$this->config["tpl"] = "default";
		}
		$_act_get = fn_getSafe($_GET["act_get"], "txt", "");
		$_str_key = fn_getSafe($_GET["key"], "txt", "");

		$this->search = array(
			"act_get"    => $_act_get,
			"key"        => $_str_key,
		);

	}
}
?>