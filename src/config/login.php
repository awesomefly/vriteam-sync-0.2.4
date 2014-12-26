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
/*
 * 登陆配置文件
 */
define('LOGIN_INPUT_REMEMBER_ME',                   'remember_me');
define('LOGIN_INPUT_REMEMBER_DAYS',                 'remember_days');
define('LOGIN_REMEMBER_ME_TRUE',                    'on');
define('LOGIN_KEY_SHOW_TIP',                        'show_tip'); 
define('LOGIN_OUT_URL',                             '/index.php?mod=web.login&act=out');

//定义登陆错误信息
$GLOBALS['web_login_msgs']              = array();
$GLOBALS['web_login_msgs']['empty']     = array('errno'=> 1, 'msg' => '没有输入用户名或者密码');
$GLOBALS['web_login_msgs']['nouser']    = array('errno'=> 2, 'msg' => '没有找到用户，请检查输入!');
$GLOBALS['web_login_msgs']['wrongpwd']  = array('errno'=> 3, 'msg' => '密码错误');
