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
 * 用户管理配置文件 
 */
#input键值定义
define('USER_INPUT_ID',                     'id');
define('USER_INPUT_USERNAME',               'user_name');
define('USER_INPUT_PASSWORD',               'password');
define('USER_INPUT_RPASSWORD',              'repassword');
define('USER_INPUT_USER_MOD',               'user_mod');
define('USER_INPUT_IS_DEL',                 'is_del');
#action地址定义
define('USER_TPL_CREATE',                   'console/user_create.tpl');
define('USER_ACTION_USER',                  '/index.php?mod=console.user');
define('USER_ACTION_LIST',                  USER_ACTION_USER . '&act=list');
define('USER_ACTION_CREATE',                USER_ACTION_USER . '&act=create');
define('USER_ACTION_DOCREATE',              USER_ACTION_USER . '&act=docreate');
define('USER_ACTION_DELETE',                USER_ACTION_USER . '&act=delete');
#默认值定义
define('USER_ADMIN_NAME',                   'admin');
define('USER_DEFAULT_PASSWORD',             '123123');
define('USER_MOD_DEFAULT_NULL',             0);
define('USER_MOD_SELECT_FILE',              1);
define('USER_MOD_OPERATE_TICKET',           2);
define('USER_PASSWD_MIN_LENGHT',            6);
define('USER_PASSWD_MAX_LENGHT',            15);
#用户状态定义 
define('USER_DEL_NOT',                      0);
define('USER_DEL_YES',                      1);
#错误信息定义
define('USER_MESS_USERNAME_EXISTS',         '用户已存在');
define('USER_MESS_USERNAME_ERR',            '用户名长度必须是' . DESC_MIN_LENGTH . '-' . DESC_MAX_LENGTH . '个字符之间');
define('USER_MESS_USERNAME_FBSTR',          '用户名含有非法字符');
define('USER_MESS_PASSWORD_ERR',            '密码长度是' . USER_PASSWD_MIN_LENGHT . '-' . USER_PASSWD_MAX_LENGHT . '个字符之间');
define('USER_RE_PASSWORD_ERR',              '两次密码输入不一致');
#title定义
define('USER_TITLE_CREATE',                 '用户创建');
define('USER_TITLE_LIST',                   '用户列表');
