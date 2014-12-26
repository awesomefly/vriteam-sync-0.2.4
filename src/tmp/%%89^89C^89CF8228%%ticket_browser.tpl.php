<?php /* Smarty version 2.6.26, created on 2014-12-11 14:46:08
         compiled from web/ticket_browser.tpl */ ?>
<div class="selectLists">
	<div class="document">
        <form id="act-save" method="post" class="mask-scroll-y" action="index.php?id=<?php echo @TICKET_ID; ?>
&mod=web.ticket&act=save">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "web/ticket_detail_fls.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </form>
		<div class="handy act-choose">
			<input type="checkbox" checked="checked" action-type="all" tabindex="1"> 全选　　　
			<input type="checkbox" action-type="reverse" tabindex="1"> 反选　　　
			<a href="javascript:;" class="delete btn" action-type="act-save-choose" tabindex="1">保存</a> 
		</div>
	</div>
</div>