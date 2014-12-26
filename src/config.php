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
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('display_errors', 1);
header('Content-type:text/html; charset=utf-8');
define('AUTHOR',                        'vriteam');
define('AUTHOR_MAIL',                   'vriteam@163.com');
define('REV_KEY',                       'SYNC');
#操作系统路径分隔符
define('FS_DELIMITER',                  DIRECTORY_SEPARATOR);
#上线系统的名称
define('SYNC_OS_NAME',                  'SYNC');
define('SYNC_OS_NAME_CN',               '上线系统');
define('MAIN_TITLE',                    SYNC_OS_NAME);
define('SYNC_MAIN_TITLE',               SYNC_OS_NAME_CN . ' --');
#上线系统访问的地址
define('SYNC_OS_URL_NAME',              'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'].'/');
#web服务器的部署路径
define('WEB_PATH',                      dirname(__FILE__) . FS_DELIMITER);
#smary核心文件
define('SMARTYPAHT',                    WEB_PATH . '/lib/smarty/Smarty.class.php');
#模板根目录
define('SMARTY_TPL_PATH',               WEB_PATH . "/templates");
#模板缓存目录
define('SMARTY_TMP_PATH',               WEB_PATH . "/tmp");
#配置文件所在的文件夹
define('CONFIGPATH',                    WEB_PATH .'/config/');
#功能相关函数的文件夹
define('FUNCTIONPATH',                  WEB_PATH .'/function/');
#库函数的文件夹
define('LIBPATH',                       WEB_PATH .'/lib/');
#存放从svn取回的文件
define('LOCAL_PATH_PREFIX',             WEB_PATH. '/data/');
define('BACKUP_PATH_PREFIX',            WEB_PATH. '/data/backups/');
define('SYNC_LOG_PATH',                 LOCAL_PATH_PREFIX . '/sync.log');
#数据表的名称  
define("SYNC_TICKETS_TABLE",            'sync_tickets');            #上线单表
define("SYNC_USERS_TABLE",              'sync_users');              #用户列表
define("SYNC_PROJECTS_TABLE",           'sync_projects');           #项目表
define("SYNC_SERVERS_TABLE",            'sync_servers');            #服务器表
define("SYNC_HISTORY_TABLE",            'sync_history');            #服务器表
define("SYNC_CONFIGS_TABLE",            'sync_configs');            #配置参数表
define("SYNC_PROJECT_GROUP_TABLE",      'sync_project_group');      #项目组数据库表
define("SYNC_LIST_TABLE",                'sync_list');              #项目组数据库表
define("SYNC_TIPS_TABLE",                'sync_tips');              #小贴士表

#定义服务器信息数组的键值
define('SYNC_SERVER_INFO_KEY_ID',       'id');
define('SYNC_SERVER_INFO_KEY_IP',       'ip');
define('SYNC_SERVER_INFO_KEY_PORT',     'port');
define('SYNC_SERVER_INFO_KEY_USERNAME', 'username');
define('SYNC_SERVER_INFO_KEY_PASSWORD', 'password');
define('SYNC_SERVER_INFO_KEY_WWWROOT',  'wwwroot');
#标记svn信息数据 路径的 key
define('SVN_INFO_KEY',                  'path');
define('SVN_INFO_KEY_TRUNK',            'trunk');
define('SVN_INFO_KEY_PREFIX',           'prefix');
define('SVN_INFO_KEY_URI',              'uri');
define('SVN_INFO_KEY_SERVER',           'si');
define('SVN_INFO_KEY_SVNSE',            'svn_server');
define('SVN_INFO_KEY_FILESE',           'file_server');
define('SVN_INFO_KEY_CLOSE',            'close');
define('SVN_INFO_KEY_DESC',             'desc');
#操作时间到中文解释的对应关系
define('OP_TYPE_ROLLBACK',              'rollback_time');
define('OP_TYPE_SYNC_TIME',             'sync_time');
define('OP_TYPE_MODIFY_TIME',           'modify_time');
define('OP_TYPE_DEL_TIME',              'del_time');
define('OP_TYPE_CREATE_TIME',           'create_time');
#sync_servers表字段定义
define('DB_SERVERS_ID',                 's_id');
define('DB_SERVERS_DESC',               's_desc');
define('DB_SERVERS_SCHEME',             's_scheme');
define('DB_SERVERS_IP',                 's_ipv4');
define('DB_SERVERS_PORT',               's_port');
define('DB_SERVERS_PREFIX',             's_prefix');
define('DB_SERVERS_SURI',               's_uri');
define('DB_SERVERS_TURI',               's_trunk_uri');
define('DB_SERVERS_USERNAME',           's_username');
define('DB_SERVERS_PASSWORD',           's_password');
define('DB_SERVERS_TYPE',               's_type');
define('DB_SERVERS_DEL',                's_del');
#sync_users表的字段定义
define('DB_USERS_ID',                   's_userid');
define('DB_USERS_USERNAME',             's_username');
define('DB_USERS_PASSWORD',             's_password');
define('DB_USERS_CREATETIME',           's_createtime');
define('DB_USERS_UPDATETIME',           's_updatetime');
define('DB_USERS_MOD',                  's_usermod');
define('DB_USERS_DEL',                  's_del');
#sync_project_group表的字段定义
define('DB_PGROUP_ID',                  'pg_id');
define('DB_PGROUP_NAME',                'pg_name');
define('DB_PGROUP_DESC',                'pg_desc');
define('DB_PGROUP_DEL',                 'pg_del');
define('DB_PGROUP_CTIME',               'pg_createtime');
#sync_projects表的字段定义
define('DB_PROJECTS_ID',                'p_id');
define('DB_PROJECTS_NAME',              'p_name');
define('DB_PROJECTS_SVN',               'p_svn');
define('DB_PROJECTS_STATUS',            'p_status');
define('DB_PROJECTS_SERVERS',           'p_servers');
define('DB_PROJECTS_PGID',              'p_group_id');

define('DB_SECTION_S_ID',               's_id');
define('DB_SECTION_FILE_LIST',          's_file_list');
define('DB_SECTION_OP_LIST',            's_op_list');
define('DB_SECTION_TRAC_ID',            's_trac_id');
define('DB_SECTION_OWNER',              's_owner');
#数据库操作历史记录的key的值
define('OP_LIST_KEY_PN',                'branch');
define('OP_LIST_KEY_V',                 'version');
define('OP_LIST_KEY_AUTHOR',            'author');
define('OP_LIST_KEY_DATE',              'date');
define('OP_LIST_KEY_ACTION',            'action');
define('OP_LIST_KEY_DIR',               'dir');
define('OP_LIST_KEY_URI',               'uri');
define('OP_LIST_KEY_URL',               'url');
define('OP_LIST_KEY_PREFIX',            'prefix');
define('OP_LIST_KEY_UPREFIX',           'uri_prefix');
define('OP_LIST_KEY_OPER',              'oper');
define('OP_LIST_KEY_HID',               'hid');
define('OP_LIST_KEY_OPTIME',            'optime');
define('OP_LIST_KEY_OPTYPE',            'optype');
define('OP_LIST_KEY_OPTYPER',           'optyper');
define('OP_LIST_KEY_RPATH',             'rpath');
define('OP_LIST_KEY_RV',                'rv');
define('OP_LIST_KEY_T',                 't');
#定义用到的正则表达是
define('REG_CREATE_NEW_SYNC_USER',      '^[a-z_]{4,}$');
define('REG_REPLACE_CSS',               '/\.css$/i');
define('REG_REPLACE_JS',                '/\.js$/i');
define('REG_REPLACE_PHP',               '/\.php$/i');
define('REG_REPLACE_PIC_WS',            '/\.(jpe?g|png|gif|swf)$/i');
define('REG_FORMAT_SVN_DATE',           "/^(?P<ymd>\d{4}(?:-\d{2}){2})T(?P<his>(?:\d{2}:){2}\d{2})/");
#定义错误提示信息
define('SYNC_E_CONNECT',                '连接到mysql失败!');
#压缩静态文件的命令行
define('COMPRESS_CMD',                  'java -jar /usr/share/java/yuicompressor-2.4.1.jar --charset utf-8 --type ');
#svn操作类型的关系
define('SVN_FILE_ACTION_TYPE_M',        'M');
define('SVN_FILE_ACTION_TYPE_D',        'D');
define('SVN_FILE_ACTION_TYPE_A',        'A');
define('SVN_FILE_ACTION_TYPE_R',        'R');
define('SYNC_CSS_OP',                   'css_op');
#定义系统是否检查php语法错误
define('SYNC_CHECK_PHP',                true);
#定义系统是压缩css和js
define('SYNC_COMPRESS',                 false);
#定义服务器的类型
define('SYNC_SERVER_TYPE_SVN',          0);
define('SYNC_SERVER_TYPE_FILE',         1);
define('SYNC_SERVER_TYPE_SVN_STATIC',   2);

define('REQUEST_INPUT_MOD',             'mod');
define('REQUEST_INPUT_ACT',             'act');
define('REQUEST_DEFAULT_MOD',           'web.ticket');
define('REQUEST_DEFAULT_MOD_LOGIN',     'web.login');

define('DESC_MIN_LENGTH',               2);
define('DESC_MAX_LENGTH',               30);
define('STANDERD_LETTERS',              "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/");

$db_cfg_file = WEB_PATH . FS_DELIMITER . 'db.cfg.php';
if ( file_exists($db_cfg_file) )
    require $db_cfg_file;

#错误信息定义
define('RET_KEY_CODE',                  'code');
define('RET_KEY_MSG',                   'message');
define('RET_KEY_DATA',                  'data');
define('SUCC_CODE',                     0);
define('WARING_CODE',                   1);
define('FAIL_CODE',                     -1);
define('OP_MESS_FAIL',                  '操作失败');
define('OP_MESS_SUCC',                  '操作成功');
#定义后台分页信息
define('FIRST_PAGE',                    1);
define('LIST_PER_PAGE',                 10);
define('INPUT_KEY_PAPE',                'p');
#安装首页地址
define('INSTALL_INDEX_URL',             '/install/index.html');
#数据库配置文件地址
define('DB_CONF_FILE',                  dirname(__FILE__) . '/db.cfg.php');
