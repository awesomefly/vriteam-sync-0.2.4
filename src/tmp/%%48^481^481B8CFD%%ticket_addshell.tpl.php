<?php /* Smarty version 2.6.26, created on 2014-12-25 18:52:33
         compiled from web/ticket_addshell.tpl */ ?>
<div class="fileMain">
<form id="add-shell" method="post" action="index.php?mod=web.ticket&act=saveshell&id=<?php echo @TICKET_ID; ?>
">
	<div class="projecName">
	<em>项目组名字：</em>
	<span>
		<select name="grp" class="projec" action-type="act-pro-select" tabindex="1">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "web/ticket_select_options.tpl", 'smarty_include_vars' => array('cache_lifetime' => 0,'options' => $this->_tpl_vars['list'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</select>
		<?php if ($this->_tpl_vars['listse']): ?>
		<select name="pname" class="branch" tabindex="1">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "web/ticket_select_options.tpl", 'smarty_include_vars' => array('options' => $this->_tpl_vars['listse'],'cache_lifetime' => 0)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</select>
		<?php endif; ?>
	<!--项目下拉菜单放到这里-->
	</span>
	</div>
	<div class="version">
	<em>路径：</em>
	<input type="text" name="path" style="width:400px" tabindex="1">
	<a href="##" class="delete btn" action-type="act-save-shell" tabindex="1">保存</a>
	</div>
</form>
</div>