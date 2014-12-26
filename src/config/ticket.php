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
#定义异常信息
$GLOBALS['web_ticket_msgs'] = array();
$GLOBALS['web_ticket_msgs']['empty_pjgrp']      = array('errno'=> 1, 'msg' => '项目组为空');
$GLOBALS['web_ticket_msgs']['empty_pj']         = array('errno'=> 2, 'msg' => '项目组内没有项目');
$GLOBALS['web_ticket_msgs']['browser_verson']   = array('errno'=> 3, 'msg' => '输入版本必须是数字');
$GLOBALS['web_ticket_msgs']['pname']            = array('errno'=> 4, 'msg' => '项目不存在');
$GLOBALS['web_ticket_msgs']['no_svn_log']       = array('errno'=> 5, 'msg' => '所指定的版本没有修改');
$GLOBALS['web_ticket_msgs']['no_fl']            = array('errno'=> 6, 'msg' => '文件列表为空');
$GLOBALS['web_ticket_msgs']['m_flist_fail']     = array('errno'=> 7, 'msg' => '修改文件列表失败');
$GLOBALS['web_ticket_msgs']['idnoexist']        = array('errno'=> 8, 'msg' => '上线单不存在');
$GLOBALS['web_ticket_msgs']['noservers']        = array('errno'=> 9, 'msg' => '恭喜你:上线单中没有文件');
$GLOBALS['web_ticket_msgs']['nosrvsltd']        = array('errno'=> 10, 'msg' => '没有选择要同步的文件服务器');
$GLOBALS['web_ticket_msgs']['exist']            = array('errno'=> 11, 'msg' => '上线单已经存在');
$GLOBALS['web_ticket_msgs']['etid']             = array('errno'=> 12, 'msg' => '上线单号码只能为正整数');
$GLOBALS['web_ticket_msgs']['nopri']            = array('errno'=> 13, 'msg' => '没有此操作权限');
$GLOBALS['web_ticket_msgs']['syncfailure']      = array('errno'=> 14, 'msg' => '同步失败');
$GLOBALS['web_ticket_msgs']['dirnoe']           = array('errno'=> 15, 'msg' => '本地缓存文件夹不存在:' . LOCAL_PATH_PREFIX);
$GLOBALS['web_ticket_msgs']['dirnow']           = array('errno'=> 16, 'msg' => '本地缓存文件夹不可写:' . LOCAL_PATH_PREFIX);
$GLOBALS['web_ticket_msgs']['syntaxerror']      = array('errno'=> 17, 'msg' => '文件列表中的php文件有语法错误');
$GLOBALS['web_ticket_msgs']['nosync']           = array('errno'=> 18, 'msg' => '没有同步过,不能回滚');

#定义php程序和模板交互的协议
define('WT_ID',    'id');
define('WT_FC',    'f_count');
define('WT_FL',    'f_list');
define('WT_OC',    'o_count');
define('WT_OW',    'o_owner');
define('WT_OT',    'o_time');
define('WT_OP',    'o_type');
define('WT_CT',    'o_ctime');
define('WT_ST',    'o_stime');

define('WT_EC',    'encode');
define('WT_PC',    'img');
define('WT_AR',    'action_r');
define('WT_UL',    'url');
define('WT_KY',    'key');
define('WT_NV',    'nversion');
define('WT_TV',    'tversion');

define('WT_EM',    'errmsg');
