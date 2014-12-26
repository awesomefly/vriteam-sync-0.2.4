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
set_time_limit(0);
session_start();
date_default_timezone_set('Asia/Chongqing');
ini_set('default_socket_timeout', 5);
define('SWITCH_JSON',        true);

require 'config.php';
require 'function.php';
#检查系统是否已经安装
check_sync_build();

autoload(CONFIGPATH);
autoload(LIBPATH);
autoload(FUNCTIONPATH);

#检查登录
logined();
#初始化
init();

$inc_file = get_include_mod_file();
include_once($inc_file);

#获得模块的初始化函数，如果存在就调用
$mod_init = get_init_func();
if(function_exists($mod_init)) $mod_init();

#获得具体的入口函数
$func = get_func();
$av = $func();

output($av);
