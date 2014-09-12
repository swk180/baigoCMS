{* install_1.tpl 登录界面 *}
{$cfg = [
	sub_title  => $lang.page.installVisit,
	sub_active => "visit",
	mod_help   => "upgrade",
	act_help   => "visit"
]}
{include "include/upgrade_head.tpl" cfg=$cfg}

	<form name="install_form_visit" id="install_form_visit">
		<input type="hidden" name="token_session" value="{$common.token_session}">
		<input type="hidden" name="act_post" value="visit">

		{include "include/install_form.tpl" cfg=$cfg}

		<div class="form-group">
			<div class="btn-group">
				<button type="button" id="go_next" class="btn btn-primary btn-lg">{$lang.btn.save}</button>
				{include "include/upgrade_drop.tpl" cfg=$cfg}
			</div>
		</div>

	</form>

{include "include/install_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_form = {
		{foreach $opt["visit"] as $key=>$value}
			{if $value.type == "str" || $value.type == "textarea"}
				{$str_msg_min = "too_short"}
				{$str_msg_max = "too_long"}
			{else}
				{$str_msg_min = "too_few"}
				{$str_msg_max = "too_many"}
			{/if}
			"opt_{$key}": {
				length: { min: {$value.min}, max: 900 },
				validate: { type: "{$value.type}", format: "{$value.format}" },
				msg: { id: "msg_{$key}", {$str_msg_min}: "{$alert.x060201}{$value.label}", {$str_msg_max}: "{$value.label}{$alert.x060202}", format_err: "{$value.label}{$alert.x060203}" }
			}{if !$value@last},{/if}
		{/foreach}
	};

	var opts_submit_form = {
		ajax_url: "{$smarty.const.BG_URL_INSTALL}ajax.php?mod=upgrade",
		btn_text: "{$lang.btn.installNext}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$smarty.const.BG_URL_INSTALL}ctl.php?mod=upgrade&act_get=upload"
	};

	$(document).ready(function(){
		var obj_validator_form = $("#install_form_visit").baigoValidator(opts_validator_form);
		var obj_submit_form = $("#install_form_visit").baigoSubmit(opts_submit_form);
		$("#go_next").click(function(){
			if (obj_validator_form.validateSubmit()) {
				obj_submit_form.formSubmit();
			}
		});
	})
	</script>

</html>
