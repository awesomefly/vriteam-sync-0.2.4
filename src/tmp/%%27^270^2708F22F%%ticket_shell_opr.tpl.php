<?php /* Smarty version 2.6.26, created on 2014-12-25 17:24:03
         compiled from web/ticket_shell_opr.tpl */ ?>
<div class="operate clearfix">
	<a <?php if (@CURRENT_UMOD & @USER_MOD_SELECT_FILE): ?>
    class="btn"	href="/index.php?mod=web.ticket&act=addshell&id=<?php echo @TICKET_ID; ?>
"
	action-type="act-add-shellpath" onclick="return false;" tabindex="3"
	<?php else: ?> title="没有对应的权限" class="without_select" <?php endif; ?>>添加脚本</a>

	<a <?php if (@CURRENT_UMOD & @USER_MOD_OPERATE_TICKET): ?>
	class="btn" href="/index.php?mod=web.ticket&act=run&id=<?php echo @TICKET_ID; ?>
"
	action-type="act-run-file" onclick="return false;" tabindex="3"
	<?php else: ?>title="没有对应的权限" class="without_want" <?php endif; ?>>执行脚本</a>
</div>