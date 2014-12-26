<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 * Smarty {welcome}{/welcome} block plugin
 * 显示通知模块
 */
function smarty_block_welcome($params, $content, &$smarty) {
    if (is_null($content))  return ;

    $smarty->_tpl_vars['current_username'] = current_username();

    $smarty->assign('current_username', 'ddddd');

    return $content;
}

?>
