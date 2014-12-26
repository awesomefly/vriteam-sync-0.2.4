<?php /* Smarty version 2.6.26, created on 2014-12-11 14:45:59
         compiled from web/ticket_select_options.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'web/ticket_select_options.tpl', 4, false),)), $this); ?>
<option value="0">请选择</option>
<?php $_from = $this->_tpl_vars['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['option']):
?>
<option value="<?php echo $this->_tpl_vars['option']['pv']; ?>
" <?php if ($_COOKIE['pgid'] == $this->_tpl_vars['option']['pv'] || $_COOKIE['pname'] == $this->_tpl_vars['option']['pv']): ?>
selected="selected"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['option']['pn'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30, '', 'TRUE') : smarty_modifier_truncate($_tmp, 30, '', 'TRUE')); ?>
</option>
<?php endforeach; endif; unset($_from); ?>