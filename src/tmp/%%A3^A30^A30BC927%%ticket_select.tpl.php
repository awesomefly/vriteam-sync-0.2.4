<?php /* Smarty version 2.6.26, created on 2014-12-25 18:40:50
         compiled from web/ticket_select.tpl */ ?>
<!--选择文件-->
	<div class="fileMain">
        	<form id="select-file" method="post" action="index.php?mod=web.ticket&act=browser&id=<?php echo @TICKET_ID; ?>
">
		<div class="projecName">
			<em>项目组名字：</em>
			<span>
				<select name="" class="projec" action-type="act-pro-select" tabindex="1">
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
			<em>svn版本：</em>
			<input type="text" name="version" value="1" title="10以内为查看最新N次的修改" style="width:100px" tabindex="1">
			<a href="##" class="btn browse" action-type="act-browse-file" tabindex="1">浏览</a>
			<em>(<?php echo @SYNC_SVN_LOG_MAX; ?>
以内为查看最新N次的修改)</em>
			<input type="checkbox" name="sort" value="1" tabindex="1" style="margin:5px 4px 0 4px;"/><em>是否按版本排序</em>
		</div>
        	</form>
	</div>
        <div class="ajax-callback-list">
        </div>
	<!--文件列表需要放到这里-->