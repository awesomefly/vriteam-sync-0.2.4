<?php /* Smarty version 2.6.26, created on 2014-12-12 17:34:08
         compiled from web/ticket_list.tpl */ ?>
<ul class="list">
<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<li><span>上线单 ID：<a href="/index.php?mod=web.ticket&act=detail&id=<?php echo $this->_tpl_vars['item'][@WT_ID]; ?>
"><?php echo $this->_tpl_vars['item'][@WT_ID]; ?>
</a></span> 
<span>创建者：<a href="/index.php?mod=web.ticket&act=search&stype=username&key=<?php echo $this->_tpl_vars['item'][@WT_OW]; ?>
"><?php echo $this->_tpl_vars['item'][@WT_OW]; ?>
</a></span> 
<span>拥有文件的数目：<?php echo $this->_tpl_vars['item'][@WT_FC]; ?>
</span>　
<span>操作次数：<?php echo $this->_tpl_vars['item'][@WT_OC]; ?>
　</span>　
<span>最近操作的时间：<?php echo $this->_tpl_vars['item'][@WT_OT]; ?>
</span>　
<span>　最后操作的状态：<?php echo $this->_tpl_vars['item'][@WT_OP]; ?>
</span>　
<a href="/index.php?mod=web.ticket&act=detail&id=<?php echo $this->_tpl_vars['item'][@WT_ID]; ?>
" class="detail">详细信息</a></li>
<?php endforeach; endif; unset($_from); ?>
</ul>
<?php if ($this->_tpl_vars['list']): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "console/page.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>