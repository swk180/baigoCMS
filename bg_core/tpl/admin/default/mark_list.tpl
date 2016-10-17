{$cfg = [
    title          => "{$adminMod.article.main.title} - {$adminMod.article.sub.mark.title}",
    menu_active    => "article",
    sub_active     => "mark",
    baigoCheckall  => "true",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=mark&act_get=list&{$tplData.query}"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl"}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=list">{$adminMod.article.main.title}</a></li>
    <li>{$adminMod.article.sub.mark.title}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills nav_baigo">
                    <li>
                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=mark&act_get=form&view=iframe" data-toggle="modal" data-target="#mark_modal">
                            <span class="glyphicon glyphicon-plus"></span>
                            {$lang.href.add}
                        </a>
                    </li>
                    <li>
                        <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=tag#mark" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            {$lang.href.help}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pull-right">
            <form name="mark_search" id="mark_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="mark">
                <input type="hidden" name="act_get" value="list">
                <div class="form-group">
                    <div class="input-group input-group-sm">
                        <input type="text" name="key" class="form-control" value="{$tplData.search.key}" placeholder="{$lang.label.key}">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>

    <form name="mark_list" id="mark_list">
        <input type="hidden" name="{$common.tokenRow.name_session}" value="{$common.tokenRow.token}">

        <div class="panel panel-default">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-nowrap td_mn">
                                <label for="chk_all" class="checkbox-inline">
                                    <input type="checkbox" name="chk_all" id="chk_all" data-parent="first">
                                    {$lang.label.all}
                                </label>
                            </th>
                            <th class="text-nowrap td_mn">{$lang.label.id}</th>
                            <th>{$lang.label.markName}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $tplData.markRows as $key=>$value}
                            <tr>
                                <td class="text-nowrap td_mn"><input type="checkbox" name="mark_ids[]" value="{$value.mark_id}" id="mark_ids_{$value.mark_id}" data-validate="mark_ids" data-parent="chk_all"></td>
                                <td class="text-nowrap td_mn">{$value.mark_id}</td>
                                <td>
                                    <ul class="list-unstyled">
                                        <li>
                                            {if $value.mark_name}
                                                {$value.mark_name}
                                            {else}
                                                {$lang.label.noname}
                                            {/if}
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=mark&act_get=form&mark_id={$value.mark_id}&view=iframe" data-toggle="modal" data-target="#mark_modal">{$lang.href.edit}</a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><span id="msg_mark_ids"></span></td>
                            <td>
                                <input type="hidden" name="act_post" id="act_post" value="del">
                                <button type="button" id="go_submit" class="btn btn-primary btn-sm">{$lang.btn.del}</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </form>

    <div class="text-right">
        {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/page.tpl" cfg=$cfg}
    </div>

    <div class="modal fade" id="mark_modal">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl"}

    <script type="text/javascript">
    var opts_validator_list = {
        mark_ids: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='mark_ids']", type: "checkbox" },
            msg: { selector: "#msg_mark_ids", too_few: "{$alert.x030202}" }
        }
    };

    var opts_submit_list = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mark",
        confirm_selector: "#act_post",
        confirm_val: "del",
        confirm_msg: "{$lang.confirm.del}",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    $(document).ready(function(){
        $("#mark_modal").on("hidden.bs.modal", function() {
            $(this).removeData("bs.modal");
        });
        var obj_validate_list = $("#mark_list").baigoValidator(opts_validator_list);
        var obj_submit_list   = $("#mark_list").baigoSubmit(opts_submit_list);
        $("#go_submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#mark_list").baigoCheckall();
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}