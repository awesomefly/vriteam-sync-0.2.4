<?php /* Smarty version 2.6.26, created on 2014-12-11 14:45:45
         compiled from web/ticket_detail_his.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'web/ticket_detail_his.tpl', 9, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['ticket'][@WT_OL]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['o_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['o_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['o_list']['iteration']++;
?>
<li>
<span>
<?php echo $this->_foreach['o_list']['iteration']; ?>
:
<?php if ($this->_tpl_vars['item'][@OP_LIST_KEY_HID]): ?>
<a href="/index.php?mod=web.ticket&act=history_detail&hid=<?php echo $this->_tpl_vars['item'][@OP_LIST_KEY_HID]; ?>
"
action-type="act-history-detal" onclick="return false;">
<?php endif; ?>
操作人：<?php echo $this->_tpl_vars['item'][@OP_LIST_KEY_OPER]; ?>
，操作：<?php echo $this->_tpl_vars['item'][@OP_LIST_KEY_OPTYPER]; ?>
 时间截：<?php echo ((is_array($_tmp=$this->_tpl_vars['item'][@OP_LIST_KEY_OPTIME])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>

<?php if ($this->_tpl_vars['item'][@OP_LIST_KEY_HID]): ?>
</a>
<?php endif; ?>
</span>
</li>
<?php endforeach; endif; unset($_from); ?>