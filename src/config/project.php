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
 * 项目管理配置文件 
 */
#PROJECT模块的配置
define('PROJECT_KEY_SERVER_SVN_LIST',       'server_svn_list');
define('PROJECT_KEY_SERVER_FILE_LIST',      'server_file_list');
define('PROJECT_KEY_SERVER_COUNT',          'server_count');
define('PROJECT_KEY_PORJECT_GROUP_LIST',    'group_list');
define('PROJECT_KEY_GROUP_INFO',            'group_info');
#input键值定义
define('PROJECT_INPUT_ID',                  'id');
define('PROJECT_INPUT_NAME',                'project_name');
define('PROJECT_INPUT_GROUP_ID',            'group_id');
define('PROJECT_INPUT_SERVER_SVN',          'server_svn');
define('PROJECT_INPUT_SERVER_FILE',         'server_file');
define('PROJECT_INPUT_STATUS',              'status');
#项目action地址定义
define('PROJECT_TPL_CREATE',                'console/project_create.tpl');
define('PROJECT_ACTION_PROJECT',            '/index.php?mod=console.project');
define('PROJECT_ACTION_CREATE',             PROJECT_ACTION_PROJECT . '&act=create');
define('PROJECT_ACTION_DOCREATE',           PROJECT_ACTION_PROJECT . '&act=docreate');
define('PROJECT_ACTION_DELETE',             PROJECT_ACTION_PROJECT . '&act=delete');
define('PROJECT_ACTION_LIST',               PROJECT_ACTION_PROJECT . '&act=list');
#定义s_type的值
define('PROJECT_TYPE_SVN',                  0);
define('PROJECT_TYPE_FILE',                 1);
#定义项目状态0：在使用 1：停用
define('PROJECT_STATUS_USE',                0);
define('PROJECT_STATUS_STOP',               1);
#title定义
define('PROJECT_TITLE_CREATE',              '项目创建');
define('PROJECT_TITLE_LIST',                '项目列表');
#错误信息定义
define('PROJECT_MESS_PROJECT_NAME_ERR',     '项目名称长度必须是' . DESC_MIN_LENGTH . '-' . DESC_MAX_LENGTH . '个字符之间');
define('PROJECT_MESS_PROJECT_NAME_EXISTS',  '项目名称已存在');
define('PROJECT_MESS_GROUP_ID_EMPTY',       '项目组不能为空');
define('PROJECT_MESS_SERVER_SVN_EMPTY',     'SVN服务器为空');
define('PROJECT_MESS_SERVER_FILE_EMPTY',    'FILE服务器为空');

define('PROJECT_SERVER_TYPE_FIELD',         'server_type_field'); 
$GLOBALS[PROJECT_SERVER_TYPE_FIELD]   = array(
    PROJECT_TYPE_SVN        => DB_PROJECTS_SVN,
    PROJECT_TYPE_FILE       => DB_PROJECTS_SERVERS,
);
