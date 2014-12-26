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
 * 服务器配置文件 
 */
#input键值定义
define('SERVER_INPUT_ID',               'id');
define('SERVER_INPUT_DESC',             'desc');
define('SERVER_INPUT_SCHEME',           'scheme');
define('SERVER_INPUT_TRUNK_URL',        'trunk_url');
define('SERVER_INPUT_IP_URL',           'ip_url');
define('SERVER_INPUT_PORT',             'port');
define('SERVER_INPUT_PREFIX',           'prefix');
define('SERVER_INPUT_S_URI',            's_uri');
define('SERVER_INPUT_TRUNK_URI',        'trunk_uri');
define('SERVER_INPUT_USER_NAME',        'user_name');
define('SERVER_INPUT_PASSWORD',         'password');
define('SERVER_INPUT_S_TYPE',           's_type');
define('SERVER_INPUT_VAL_URI',          'val_uri');
define('SERVER_INPUT_IS_DEL',           'is_del');
#action地址定义
define('SERVER_TPL_CREATE',             'console/server_create.tpl');
define('SERVER_ACTION_SERVER',          '/index.php?mod=console.server');
define('SERVER_ACTION_LIST',            SERVER_ACTION_SERVER . '&act=list');
define('SERVER_ACTION_CREATE',          SERVER_ACTION_SERVER . '&act=create');
define('SERVER_ACTION_DOCREATE',        SERVER_ACTION_SERVER . '&act=docreate');
define('SERVER_ACTION_DELETE',          SERVER_ACTION_SERVER . '&act=delete');
#定义s_type的值
define('SERVER_TYPE_SVN',               0);
define('SERVER_TYPE_FILE',              1);
#定义server的状态 0：正常 1：删除
define('SERVER_CLOSE_TRUE',             1);
define('SERVER_CLOSE_FALSE',            0);
#默认端口
define('FILE_SERVER_DEFAULT_PORT',      22);
#title定义
define('SERVER_TITLE_CREATE',           '服务器创建');
define('SERVER_TITLE_LIST',             '服务器列表');
#cache相关
define('SERVER_CACHE_LIST',             'servers_list');
#错误信息定义
define('SERVER_MESSAGE_DESC_ERR',       '服务器名称长度必须是' . DESC_MIN_LENGTH . '-' . DESC_MAX_LENGTH . '个字符之间');
define('SERVER_MESSAGE_DESC',           '已经有同名称的服务器存在');
define('SERVER_MESSAGE_SERVER_USED',    '服务器正在被项目使用中，不能删除');
#服务器错误信息对应位置表
define('SERVER_ERR_INPUT',              'err_input');
define('SERVER_ERR_BRANCH',             'branch');
define('SERVER_ERR_TRUNK',              'trunk');
define('SERVER_ERR_FLHOST',             'file_host');
$GLOBALS[SERVER_ERR_INPUT][SERVER_ERR_BRANCH] = array(
    1 => SERVER_INPUT_S_URI,
    2 => array(
        SERVER_INPUT_USER_NAME,
        SERVER_INPUT_PASSWORD,
    ),
    3 => SERVER_INPUT_S_URI,
    4 => SERVER_INPUT_USER_NAME,
    6 => SERVER_INPUT_S_URI,
);
$GLOBALS[SERVER_ERR_INPUT][SERVER_ERR_TRUNK] = array(
    1 => SERVER_INPUT_TRUNK_URI,
    2 => array(
        SERVER_INPUT_USER_NAME,
        SERVER_INPUT_PASSWORD,
    ),
    3 => SERVER_INPUT_TRUNK_URI,
    4 => SERVER_INPUT_USER_NAME,
    6 => SERVER_INPUT_TRUNK_URI,
);
#文件服务器错误信息
$GLOBALS[SERVER_ERR_INPUT][SERVER_ERR_FLHOST] = array(
    1 => SERVER_INPUT_IP_URL,
    2 => array(
        SERVER_INPUT_USER_NAME,
        SERVER_INPUT_PASSWORD,
    ),
    3 => SERVER_INPUT_PREFIX,
    4 => SERVER_INPUT_USER_NAME,
    5 => SERVER_INPUT_PASSWORD,
    6 => SERVER_INPUT_IP_URL,
);
