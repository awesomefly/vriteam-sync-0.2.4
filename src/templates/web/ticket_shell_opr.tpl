<div class="operate clearfix">
	<a {if $smarty.const.CURRENT_UMOD&$smarty.const.USER_MOD_SELECT_FILE}
    class="btn"	href="/index.php?mod=web.ticket&act=addshell&id={$smarty.const.TICKET_ID}"
	action-type="act-add-shellpath" onclick="return false;" tabindex="3"
	{else} title="没有对应的权限" class="without_select" {/if}>添加脚本</a>

	<a {if $smarty.const.CURRENT_UMOD&$smarty.const.USER_MOD_OPERATE_TICKET}
	class="btn" href="/index.php?mod=web.ticket&act=run&id={$smarty.const.TICKET_ID}"
	action-type="act-run-file" onclick="return false;" tabindex="3"
	{else}title="没有对应的权限" class="without_want" {/if}>执行脚本</a>
</div>
