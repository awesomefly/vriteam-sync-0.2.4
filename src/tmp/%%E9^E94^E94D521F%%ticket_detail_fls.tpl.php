<?php /* Smarty version 2.6.26, created on 2014-12-11 14:45:45
         compiled from web/ticket_detail_fls.tpl */ ?>
<ul class="fileList act-file-list">
<?php if ($this->_tpl_vars['ticket'][@WT_FL]): ?>
<?php $_from = $this->_tpl_vars['ticket'][@WT_FL]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f_list']['iteration']++;
?>
<li>
<?php if ($this->_tpl_vars['ticket']['browser']): ?>
<input type="checkbox" name="files[]" value="<?php echo $this->_tpl_vars['item'][@WT_EC]; ?>
" checked="checked" tabindex="1"/>
<?php else: ?>
<input type="checkbox" value="<?php echo $this->_tpl_vars['item'][@WT_KY]; ?>
" name="key[]" tabindex="1">
<?php endif; ?>
<span><img src="/static/frontEnd/img/<?php echo $this->_tpl_vars['item'][@WT_PC]; ?>
" border="0">&nbsp&nbsp&nbsp
　<?php echo $this->_foreach['f_list']['iteration']; ?>
.
项目：<strong><?php echo $this->_tpl_vars['item'][@OP_LIST_KEY_PN]; ?>
</strong>，
版本：<?php echo $this->_tpl_vars['item'][@OP_LIST_KEY_V]; ?>
，
日期：<?php echo $this->_tpl_vars['item'][@OP_LIST_KEY_DATE]; ?>
，
作者：<?php echo $this->_tpl_vars['item'][@OP_LIST_KEY_AUTHOR]; ?>
，
操作：<?php echo $this->_tpl_vars['item'][@WT_AR]; ?>

<?php if ($this->_tpl_vars['item'][@WT_NV] === null): ?>
未获取(因文件过多,不影响使用)
<?php else: ?>
最新版本：<strong><?php echo $this->_tpl_vars['item'][@WT_NV]; ?>
</strong>
<?php if (@SYNC_SVN_TRUNK): ?>：trunk文件版本：<strong><?php echo $this->_tpl_vars['item'][@WT_TV]; ?>
</strong><?php endif; ?>
<?php endif; ?>
<br />
<?php echo $this->_tpl_vars['item'][@WT_UL]; ?>

</span>
</li>
<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
<p class="none clearfix"><img src="/static/core/img/none.png" border="0">　<span>上线单中还没有文件</span></p>
<?php endif; ?>
</ul>
