<?php /* Smarty version 2.6.26, created on 2014-12-23 17:34:59
         compiled from web/ticket_sync.tpl */ ?>
<form id="act-sync" action="/index.php?mod=web.ticket&act=sync_files&id=<?php echo @TICKET_ID; ?>
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
	<div class="export">
		<?php if (@SYNC_SVN_TRUNK): ?>
		<em>从哪里导出文件：</em>
		<span>
			<input type="radio" name="from" checked="checked" value="branch" tabindex="1">branch</option>
			<input type="radio" name="from" value="trunk" tabindex="1">trunk</option>
		</span>
		<?php endif; ?>
		<a href="javascript:;" class="btn" action-type="act-sync" tabindex="1">同步</a>
		<?php if ($this->_tpl_vars['showrb']): ?>
		<a href="javascript:;" class="btn" action-type="act-rollback" tabindex="1">回滚</a>
		<?php endif; ?>
	</div>
</form>