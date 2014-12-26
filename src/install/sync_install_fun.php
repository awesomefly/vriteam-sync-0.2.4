<?php
/**
 * 安装模块所需要的函数
 * @author joker
 */

/**
 * 处理post和get数据
 */
function sync_treate_pgdt() {
    set_magic_quotes_runtime(0);
    if ( !get_magic_quotes_gpc() ) {
        sync_add_ls($_POST);
        sync_add_ls($_GET);
    }
}

/**
 * 将数组内的元素尽心addslashes处理，防注入
 * 支持多维数组
 */
function sync_add_ls(&$array) {
    if ( is_array($array) && count($array) > 0 ) {
        foreach ($array as $key => $value) 
            sync_add_ls($array[$key]);
    } elseif ( is_string($array) ) 
        $array = addslashes($array);
}

/**
 * 判断目录是否有可写权限
 */
function sync_is_writable($dir) {
    $can_write = false;
    $dir = SYNC_ROOT . $dir;
    if( !is_dir($dir) )
        @mkdir($dir, SYNC_DEFAULT_FILEMOD);
    if ( is_dir($dir) ) {
        $dir .= '/sync_tmp.txt';
        if ( ($fp = @fopen($dir, 'w')) && (fwrite($fp, 'sync_test')) ) {
            fclose($fp);
            @unlink($dir);
            $can_write = true;
        }
    }
    return $can_write;
}

/**
 * 判断是否是有效数组
 */
function sync_array($array) {
    if (is_array($array) && count($array) > 0 ) return true;
    else return false;
}

/**
 * 输出结果标示
 */
function _sync_parse_text($text = '', $ok = false, $succ = true) {
    $sync_msg = _sync_get_msgarr();
    if ( array_key_exists($text, $sync_msg) )
        $text = $sync_msg[$text];

    if ( $ok ) {
        if ( $succ ) $text .= ' ... <span class="blue">OK</span>';
        else $text .= ' ... <span class="pink">Failed</span>';
    }
    return $text;
}

/**
 * 返回成功后的html标签内容
 */
function sync_succ_ret($text = '') {
    return _sync_parse_text($text, true, true);
}

/**
 * 直接输出成功后的标签内容
 */
function sync_succ_out($msg = '') {
    echo _sync_parse_text($msg, true, true);
}

/**
 * 返回错误的html标签内容
 */
function sync_fail_ret( &$quit, $msg = '') {
    $quit = true;
    return _sync_parse_text($msg, true, false);
}

/**
 * 直接输出错的标签内容
 */
function sync_fail_out(&$quit, $msg = '') {
    $quit = true;
    echo _sync_parse_text($msg, true, false);
}

/**
 * 输出字符串
 */
function sync_output($str = '', $exit = false) {
    echo  _sync_parse_text($str);
    if ( $exit ) exit();
}

/**
 * 返回字符串 
 */
function sync_retstr($str = '') {
    return _sync_parse_text($str);
}

/**
 * 输出并且终端程序
 */
function sync_output_exit($str = '') {
    sync_output($str, true);
}

/**
 * 获取消息配置数组
 */
function _sync_get_msgarr() {
    static $sync_msg_cache;
    if ( sync_array($sync_msg_cache) )
        $sync_msg = $sync_msg_cache;
    else {
        global $sync_msg;
        $sync_msg_cache = $sync_msg;
    }
    return $sync_msg;
}

/**
 * 解析数据库信息
 */
function sync_check_mysql_info(&$quit, &$alert, &$sync_rebuild, &$msg) {
    init_db($msg, $quit);
    if ( $quit ) return ;

    //判断是否有用同名的数据库安装过
    $sql    = "SELECT COUNT(1) FROM `sync_users`";
    $result    =    mysql_query($sql);
    $info    =    mysql_fetch_row($result, $link);

    if( sync_array($info) ) {
        $sync_rebuild    =    true;
        $msg .= '<p>' . sync_retstr('sync_rebuild') . '</p>';
        $alert = ' onclick="return confirm(\'' . sync_retstr('sync_rebuild') . '\');"';
    }
}
/**
 * 连接数据方法 
 */
function db_connect($db_host, $db_user, $db_pass, &$link) {
    $link = mysql_connect($db_host, $db_user, $db_pass);
    if ( !$link )
        return false;
    else
        return true;

}
/**
 * 检查用户是否可以创建数据库
 */
function check_create_db($db_host, $db_user, $db_pass, $db_name, $db_charset) {
    if ( !db_connect($db_host, $db_user, $db_pass) )
        return false;
    $create_db_sql = "CREATE DATABASE IF NOT EXISTS `{$db_name}` DEFAULT CHARACTER SET {$db_charset}";
    return mysql_query($create_db_sql);
}
/**
 * 数据库初始化连接
 */
function init_db(&$msg, &$quit, &$link) {
    $db_info    =    $_SESSION['sync_db_info'];
    if ( sync_array($db_info) ) {//初始化数据库操作参数
        $db_host    = $db_info['db_host'];
        $db_user    = $db_info['db_username']; 
        $db_pass    = $db_info['db_password'];
        $db_name    = $db_info['db_name'];
        $db_charset = str_replace('-', '', $db_info['db_charset']);
    }

    if ( !$db_host && !$db_name ) {
        $msg .= '<p>' . sync_retstr('db_info_failed') . '</p>';
        $quit = TRUE;
    } else {
        db_connect($db_host, $db_user, $db_pass, $link);
        if (mysql_get_server_info() > '5.0')
            mysql_query("SET sql_mode = ''");
        $create_db_sql = "CREATE DATABASE IF NOT EXISTS `{$db_name}` DEFAULT CHARACTER SET {$db_charset}";
        @mysql_query($create_db_sql);
        $format_db_sql = "SET character_set_connection={$db_info['db_charset']}, 
            character_set_results={$db_info['db_charset']}, character_set_client=binary";
        mysql_query($format_db_sql);

        if ( mysql_errno() ) {
            $mysql_err = mysql_error();
            $msg .= '<p>'.($mysql_err ? $mysql_err : sync_retstr('database_errno')).'</p>';
            $quit = TRUE;
        } else 
            mysql_select_db($db_name);
    }
}

/**
 * 创建表的方法
 */
function sync_create_tb($sql, $db_charset) {
    $db_charset = str_replace('-', '', $db_charset);
    $type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
    $type = in_array($type, array("MYISAM", "HEAP")) ? $type : "MYISAM";
    return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).
        (mysql_get_server_info() > "4.1" ? " ENGINE=$type DEFAULT CHARSET=$db_charset" : " TYPE=$type");
}

/**
 * 创建管理员账号
 */
function sync_create_admin() {
    init_db();
    $admin_user =    $_SESSION['sync_amdin_info'];
    $now        = time();
    $admin_user['password'] = md5($admin_user['password']);
    $sql        =    "INSERT INTO `sync_users` ( `s_username`, `s_password`, `s_createtime`, `s_updatetime`, `s_usermod`) 
        VALUES ('" . SYNC_ADMIN_UNAME .  "', '{$admin_user['password']}', {$now}, {$now}, 3)";
    return mysql_query($sql);
}
/**
 * 初始化系统配置表
 */
function sync_insert_configs() {
    init_db();
	$sql = "insert into sync_configs values('svn_log_max', '10', 1),('svn_diff_max', '60', 1),('svn_trunk', '0', 1)";
	if($conn) mysql_query($sql, $conn);
	else mysql_query($sql);
}
/**
 * 初始化小贴士表
 */
function sync_init_tips() {
    global $tips_arr;
    init_db();
	if($conn) mysql_query($sql, $conn);
    else {
        if  ( is_array($tips_arr) && !empty($tips_arr) ) {
            foreach ( $tips_arr as $k => $tips ) {
                $sql = "select * from `sync_tips` where `t_content` = '{$tips}'";
                $result = mysql_query($sql);
                $row = mysql_fetch_row($result);
                if ( !$row ) {
                    $sql1    = "insert into `sync_tips` set `t_content` = '{$tips}', `t_del` = 0, `t_createtime` = " . time();
                    $result1 = mysql_query($sql1);
                }
            }
        }
    }
}
