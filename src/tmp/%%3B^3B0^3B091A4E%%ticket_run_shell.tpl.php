<?php /* Smarty version 2.6.26, created on 2014-12-25 14:22:07
         compiled from web/ticket_run_shell.tpl */ ?>
<!--同步后结果开始-->
<div class="mask-scroll-y">
	<div class="document">
		<ul class="fileList">
<?php $_from = $this->_tpl_vars['ticket']['run_shell_result']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			<li>
			<h4>服务器: <?php echo $this->_tpl_vars['item']['server_info']['desc']; ?>
 (ip:<?php echo $this->_tpl_vars['item']['server_info']['ip']; ?>
)</h4>
			<h4>脚本路径: <?php echo $this->_tpl_vars['item']['file']; ?>
</h4>
<?php if ($this->_tpl_vars['item']['suc']): ?>
	<?php $_from = $this->_tpl_vars['item']['suc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sitem']):
?>
	<span style="color:green">执行成功: <?php echo $this->_tpl_vars['sitem']; ?>
</span>
	<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['item']['fal']): ?>
	<?php $_from = $this->_tpl_vars['item']['fal']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['fitem']):
?>
	<span class="listWrong">执行错误: <?php echo $this->_tpl_vars['fitem']; ?>
</span>
	<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
			</li>
<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
</div>
<!--同步结果结束-->