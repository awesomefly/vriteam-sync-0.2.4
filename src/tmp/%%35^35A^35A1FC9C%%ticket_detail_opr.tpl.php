<?php /* Smarty version 2.6.26, created on 2014-12-25 15:51:09
         compiled from web/ticket_detail_opr.tpl */ ?>
<div class="operate clearfix">
	<a href="javascript:;" class="btn" action-type="act-delete-file">删除</a> 
	<a <?php if (@CURRENT_UMOD & @USER_MOD_SELECT_FILE): ?>
    class="btn"	href="/index.php?mod=web.ticket&act=select&id=<?php echo @TICKET_ID; ?>
"
	action-type="act-choose-file" onclick="return false;" tabindex="3"
	<?php else: ?> title="没有对应的权限" class="without_select" <?php endif; ?>>添加文件</a>

	<a <?php if (@CURRENT_UMOD & @USER_MOD_OPERATE_TICKET): ?>
	class="btn" href="/index.php?mod=web.ticket&act=sync&id=<?php echo @TICKET_ID; ?>
"
	action-type="act-sync-file" onclick="return false;" tabindex="3"
	<?php else: ?>title="没有对应的权限" class="without_want" <?php endif; ?>>同步文件</a>
</div>