<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {sync_notify}{/sync_notify} block plugin
 * 通知显示模板，全站通用
 *
 * Type:     block function<br>
 * Name:     textformat<br>
 * Purpose:  format text a certain way with preset styles
 *           or custom wrap/indent settings<br>
 * @link http://smarty.php.net/manual/en/language.function.textformat.php {textformat}
 *       (Smarty online manual)
 * @param array
 * <pre>
 * Params:   style: string (email)
 *           indent: integer (0)
 *           wrap: integer (80)
 *           wrap_char string ("\n")
 *           indent_char: string (" ")
 *           wrap_boundary: boolean (true)
 * </pre>
 * @author Monte Ohrt <monte at ohrt dot com>
 * @param string contents of the block
 * @param Smarty clever simulation of a method
 * @return string string $content re-formatted
 */
function smarty_block_sync_notify($params, $content, &$smarty)
{
    if (is_null($content)) {
        return;
    }

    $_output        = '';
    $notify_display = true;
    $user_id = current_userid();
    if ( (int)$user_id > 0 )
        $notify_display = check_notify_display($user_id);
    if ( !$notify_display ) return $_output;
    
    $_output = '<div style="width:600px;height:60px;border:solid 1px;text-align:center">';
    $_output = '<a href="#">xxx</a>说：请帮忙把3080同步到80环境！';
    $_output .= '</div>';

    return $_output;

}

/* vim: set expandtab: */

?>
