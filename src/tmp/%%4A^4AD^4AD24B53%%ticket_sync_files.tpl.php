<?php /* Smarty version 2.6.26, created on 2014-12-11 14:46:54
         compiled from web/ticket_sync_files.tpl */ ?>
<!--同步后结果开始-->
<div class="mask-scroll-y">
	<div class="document">
		<ul class="fileList">
<?php $_from = $this->_tpl_vars['ticket']['sync_result']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			<li>
			<h4><?php echo $this->_tpl_vars['item']['server_info']['desc']; ?>
 (ip:<?php echo $this->_tpl_vars['item']['server_info']['ip']; ?>
)</h4>
<?php if ($this->_tpl_vars['item']['sync_result']['suc']): ?>
	<?php $_from = $this->_tpl_vars['item']['sync_result']['suc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sitem']):
?>
	<span style="color:green">远程路径:<?php echo $this->_tpl_vars['sitem'][@OP_LIST_KEY_RPATH]; ?>
</span>
	<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['item']['sync_result']['fal']): ?>
	<?php $_from = $this->_tpl_vars['item']['sync_result']['fal']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['fitem']):
?>
	<span class="listWrong">远程路径:<?php echo $this->_tpl_vars['fitem'][@OP_LIST_KEY_RPATH]; ?>
(<?php echo $this->_tpl_vars['fitem']['errmsg']; ?>
)</span>
	<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
			</li>
<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
</div>
<!--同步结果结束-->