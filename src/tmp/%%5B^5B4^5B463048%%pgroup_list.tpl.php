<?php /* Smarty version 2.6.26, created on 2014-12-11 14:44:44
         compiled from console/pgroup_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'console/pgroup_list.tpl', 11, false),array('modifier', 'date_format', 'console/pgroup_list.tpl', 13, false),)), $this); ?>
<table width="660" border="0" class="table table-bordered table-striped projectTable">
	<?php if ($this->_tpl_vars['list']): ?>
	<tr class="trTitle">
		<td width="150" height="30" align="center"><span class="STYLE1">项目组名称</span></td>
		<td width="190" height="30" align="center"><span class="STYLE1">项目组描述</span></td>
		<td width="270" height="30" align="center"><span class="STYLE1">创建时间</span></td>
		<td width="60" height="30" align="center"><span class="STYLE1">操作</span></td>
	  </tr>
	<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
	<tr acttion-type="act-pgroup-info" <?php if ($this->_tpl_vars['item'][@DB_PGROUP_DEL]): ?>style="color:#f00"<?php endif; ?>>
		<td width="150" height="30" align="center" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['item'][@DB_PGROUP_NAME])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][@DB_PGROUP_NAME])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
		<td width="190" height="30" align="center"><?php if ($this->_tpl_vars['item'][@DB_PGROUP_DESC]): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][@DB_PGROUP_DESC])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php else: ?>无<?php endif; ?></td>
		<td width="270" height="30" align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][@DB_PGROUP_CTIME])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y:%m:%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y:%m:%d %H:%M:%S")); ?>
</td>
		<td width="60" height="30" align="center">
            <a href="<?php echo @PGROUP_ACTION_CREATE; ?>
&id=<?php echo $this->_tpl_vars['item'][@DB_PGROUP_ID]; ?>
" class="edits" title="编辑">【编辑】</a>
            <a href="<?php echo @PGROUP_ACTION_DELETE; ?>
&id=<?php echo $this->_tpl_vars['item'][@DB_PGROUP_ID]; ?>
" class="del" title="删除" action-type="act-pgroup-del">【删除】</a>
        </td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
	<?php else: ?>
		<p class="none"><img src="../../static/core/img/none.png" border="0"> <span>还没有创建项目组？赶紧<a href="<?php echo @PGROUP_ACTION_PGROUP; ?>
">创建</a>一个吧！</span></p>
	<?php endif; ?>
</table>
<?php if ($this->_tpl_vars['list']): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "console/page.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

</div>
<div class="CtentFoor"></div>
</div>
</div>
</div>