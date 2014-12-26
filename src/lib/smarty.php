<?php
/**
                +------------------------------------------------------------------------------+
                |                           上线系统       授权协议                            |
                |                  版权所有(c) 2013 VRITEAM团队. 保留所有权利                  |
                +------------------------------------------------------------------------------+
                |本软件的著作权归VRITEAM团队所有。具体使用许可请看软件包中的LICENSE文件。或者访|
                |问我们的网站http://www.vriteam.com/sync/license。我们欢迎给使用并给我们提出宝 |
                |贵的意见和建议。感谢团队中的成员为项目所做的努力！                            |
                +------------------------------------------------------------------------------+
                |                               作者：VRITEAM团队                              |
                +------------------------------------------------------------------------------+

 */
require_once(SMARTYPAHT);
/**
 * 调用一个模板文件展示给view层
 */
function html_output($params = array(), $tpl_file = '') {
    $smarty = new Smarty;
    $params = (array)$params;
    $smarty->assign($params);
    if ($tpl_file) $smarty->display($tpl_file);
}
/**
 * 赋值给模板
 */
function html_assign_value($params) {
    if ( !is_array($params) || count($params) == 0 ) return '';
    $smarty = new Smarty;
    $smarty->assign($params);
}
/**
 * fetch模板
 */
function html_fetch_tpl($params = array(), $tpl_file = '') {
    $smarty = new Smarty;
    $params = (array)$params;
    $smarty->assign($params);
    if ( $tpl_file ) 
        return $smarty->fetch($tpl_file);
    else
        return ;
}
