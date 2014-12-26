<?php /* Smarty version 2.6.26, created on 2014-12-26 16:30:51
         compiled from web/ticket_run.tpl */ ?>
<form id="act-run" action="/index.php?mod=web.ticket&act=run_shell&id=<?php echo @TICKET_ID; ?>
" method="POST">
	<div class="wantTongList">
		<?php $_from = $this->_tpl_vars['ticket']['p_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['p_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['p_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['item']):
        $this->_foreach['p_list']['iteration']++;
?>
		<div class="listFei">
			<h3>项目:<?php echo $this->_tpl_vars['k']; ?>
</h3>
			<ul>
				<?php $_from = $this->_tpl_vars['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['server_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['server_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['server']):
        $this->_foreach['server_list']['iteration']++;
?>
				<li>
					<input type="checkbox" value="<?php echo $this->_tpl_vars['server']['key']; ?>
"
					<?php if ($this->_foreach['server_list']['total'] == 1): ?>checked="checked"<?php endif; ?> name="servers[]" tabindex="1">
					<span><?php echo $this->_tpl_vars['server']['desc']; ?>
 (ip:<?php echo $this->_tpl_vars['server']['ip']; ?>
)</span>
				</li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</div>
		<?php endforeach; endif; unset($_from); ?>
		<div class="clearfix"></div>
	</div>
	<div style="margin-left: 10px; margin-top:15px;">
		<p>路 径:</p> <input type="text" id="sh_path" name="shellpath" style="width:400px;"/>
	</div>
	<div class="export">
		<a href="javascript:;" class="btn" action-type="act-run-shell" tabindex="1">执行</a>
	</div>
</form>