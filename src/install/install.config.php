<?php
/**
 * 安装配置文件
 */
define('SYNC_INSTALLED',            true);
define('SYNC_ROOT',                 str_replace('\\', '/', substr(dirname(__FILE__), 0, -7)));
define('SYNC_VERSION',              '0.2.4');//当前版本
define('SYNC_CURR_VERSION',         '-' . SYNC_VERSION);
define('SYNC_INSTALL_DIR',          SYNC_ROOT . 'install/');
define('SYNC_SQL_FILE',             SYNC_INSTALL_DIR . 'sync.sql');
define('SYNC_DB_CONF_FILE',         '../db.cfg.php');
define('SYNC_DB_CONF_FILE_NAME',    'db.cfg.php');
define('SYNC_PROTOCOL',             'http://');
define('SYNC_SITE_URL',             SYNC_PROTOCOL . $_SERVER['HTTP_HOST'] . 
                                    rtrim(str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_NAME']))), '/'));
define('SYNC_ADMIN_UNAME',          'admin');
//db默认配置
define('SYNC_DEFAULT_DBHOST',       'localhost');
define('SYNC_DEFAULT_DBUSER',       'root');
define('SYNC_DEFAULT_DBNAME',       'sync');

define('SYNC_PASS_MIN_LENGTH',      6);
define('SYNC_DB_CHARSET',           'utf8');
define('SYNC_DEFAULT_FILEMOD',      0777);
define('SYNC_RX_FILEMOD',           0775);

define('SYNC_INSTALL_STEP_ONE',     1);
define('SYNC_INSTALL_STEP_TWO',     2);
define('SYNC_INSTALL_STEP_THREE',   3);
define('SYNC_INSTALL_STEP_FOUR',    4);
define('SYNC_INSTALL_STEP_FIVE',    5);
define('SYNC_INSTALL_STEP_SIX',     6);

define('SYNC_FORM_PREFIX',          './install.php?step=');
define('SYNC_FORM_ACSTEP_ONE',      SYNC_FORM_PREFIX . SYNC_INSTALL_STEP_ONE);
define('SYNC_FORM_ACSTEP_TWO',      SYNC_FORM_PREFIX . SYNC_INSTALL_STEP_TWO);
define('SYNC_FORM_ACSTEP_THREE',    SYNC_FORM_PREFIX . SYNC_INSTALL_STEP_THREE);
define('SYNC_FORM_ACSTEP_FOUR',     SYNC_FORM_PREFIX . SYNC_INSTALL_STEP_FOUR);
define('SYNC_FORM_ACSTEP_FIVE',     SYNC_FORM_PREFIX . SYNC_INSTALL_STEP_FIVE);
define('SYNC_FORM_ACSTEP_SIX',      SYNC_FORM_PREFIX . SYNC_INSTALL_STEP_SIX);

define('SYNC_LOCKED_FILE',          'install.lock');
//需要检测是否可写的目录
$check_write_dirs = array (
    'data',
    'tmp',
    'install',
);
