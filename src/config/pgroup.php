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
 * 后台控制配置文件 
 */
define('PGROUP_INPUT_NAME',                     'pgroup_name');
define('PGROUP_INPUT_GROUP_DESC',               'pgroup_desc');
define('PGROUP_INPUT_IS_DEL',                   'is_del');
#title定义
define('PGROUP_TITLE_CREATE',                   '项目组创建');
define('PGROUP_TITLE_LIST',                     '项目组列表');
#错误信息提示
define('PGROUP_MESS_GROUP_NAME_EXISTS',         '项目组已经存在');
define('PGROUP_MESS_GROUP_NAME_ERR',            '项目组名字长度必须是' . DESC_MIN_LENGTH . '-' . DESC_MAX_LENGTH . '个字符之间');
define('PGROUP_MESSAGE_GROUP_USED',             '项目组正在被项目使用中');
#项目组状态定义
define('PGROUP_DEL_NOT',                        0); 
define('PGROUP_DEL_YES',                        1); 
#action地址定义
define('PGROUP_TPL_CREATE',                     'console/pgroup_create.tpl');
define('PGROUP_ACTION_PGROUP',                  '/index.php?mod=console.pgroup');
define('PGROUP_ACTION_CREATE',                  PGROUP_ACTION_PGROUP . '&act=create');
define('PGROUP_ACTION_DOCREATE',                PGROUP_ACTION_PGROUP . '&act=docreate');
define('PGROUP_ACTION_DELETE',                  PGROUP_ACTION_PGROUP . '&act=delete');
define('PGROUP_ACTION_LIST',                    PGROUP_ACTION_PGROUP . '&act=list');
