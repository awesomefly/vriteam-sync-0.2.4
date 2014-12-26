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
/**
 * 检查系统是否安装
 */
# ====================================================系统相关函数封装开始==================================== #
/**
 *检查系统参数，级别最高的检查
 */
function check_sync_build() {
    if ( filesize(DB_CONF_FILE) < 1 ) 
        redirect(INSTALL_INDEX_URL);
}
/**
 * 初始化系统可自定义参数
 */
function sync_init_configs() {
    $cs = configs_gets();
    if(sync_array($cs))
        foreach($cs as $k => $v){
            $k = strtoupper(REV_KEY . '_' . $k);
            define($k, $v);
        }
    return true;
}
/**
 * 系统初始化方法
 */
function init() {
    define('CURR_MOD', get_mod());
    define('CURR_ACT', get_act());
    set_error_handler('warning_handler', E_WARNING);
    #初始化系统参数
    sync_init_configs();
}
/**
 * 系统的警告处理函数
 * 有些异常信息在警告中需要关心
 */
function warning_handler($errno, $errmsg) {
    #先捕获svn的warning暂时丢弃其它warning
    $errmsg = svn_warning_handler($errmsg);
    if($errmsg){
        if(strpos($errmsg, 'Auth') !== false) err_set(2);
        elseif(strpos($errmsg, 'Filesystem') !== false) err_set(5);
        elseif(strpos($errmsg, 'repository') !== false) err_set(3);
        elseif(preg_match('/operation.*directory/i', $errmsg)) err_set(7);
        elseif(preg_match('/bad url/i', $errmsg)) err_set(3);
        elseif(preg_match('/not *readable/i', $errmsg)) err_set(8);
        elseif(preg_match('/invalid\s+authz\s+configuration/i', $errmsg)) err_set(9);
        else err_set(6);
    }
    return true;
}
/**
 * 和js交互的协议
 */
function ajax_protocol($code, $msg, $data) {
    return array(
        RET_KEY_CODE    => $code,
        RET_KEY_MSG     => $msg,
        RET_KEY_DATA    => $data
    );
}
/**
 * 系统统一输出函数
 */
function output($params = array()) {
    #获得要输出的模板，纯数据结构的时候为空或者null
    $tpl_file = get_tpl($params);
    if(smt_appended_json($params) && SWITCH_JSON){
        if($tpl_file) $data = html_fetch_tpl($params, $tpl_file);
        else {$data = $params;smt_sub_json($data);}
        $r = json_encode(ajax_protocol(err_get(), msg_get(), $data));
        echo $r;
    }else html_output($params, $tpl_file);
    exit(0);
}
/**
 * 分页方法 
 */
function get_page($count) {
    return get_page_html(LIST_PER_PAGE, $count);
}
function get_page_html($rows, $count) {
    $page = new Page($rows, $count);
    return $page->show();
}
/**
 * 获取统一分页参数
 */
function page() {
    return (int)$_REQUEST[INPUT_KEY_PAPE] > 0 ? (int)$_REQUEST[INPUT_KEY_PAPE] : FIRST_PAGE;
}
/**
 * 获取分页sql中最后limit部分
 */
function get_limit_str($page = NULL, $rows = NULL) {
    $limit_str = '';
    if ( (int)$page > 0 && (int)$rows > 0 ) {
        $start = ($page - 1) * $rows;
        return " limit $start, $rows";
    }
    return $limit_str;
}
/**
 * 全局错误码的设置和错误信息的设置和获取
 */
function err_set($code = NULL) {
    static $err = 0;
    if ( $code !== NULL ) $err = $code;
    return $err;
}
/**
 * 错误获取
 */
function err_get() {
    return err_set();
}
/**
 * 错误的mod返回
 */
function err_mod_get($key) {
    $mod = get_mod_name();
    $ekey = $mod . '_msgs';
    if(isset($GLOBALS[$ekey]) && array_key_exists($key, $GLOBALS[$ekey]))
        return $GLOBALS[$ekey][$key]['errno'];
    return 99;
}
/**
 * 消息设置
 */
function msg_set($msg = NULL) {
    static $sync_msg = '';
    if ( $msg !== NULL ) $sync_msg = $msg;
    return $sync_msg;
}
/**
 * 消息获取
 */
function msg_get() {
    return msg_set();
}
function msg_mod_get($key) {
    $mod = get_mod_name();
    $ekey = $mod . '_msgs';
    if(isset($GLOBALS[$ekey]) && array_key_exists($key, $GLOBALS[$ekey]))
        return $GLOBALS[$ekey][$key]['msg'];
    return '未知错误';
}
function error($key) {
    err_set(err_mod_get($key));
    msg_set(msg_mod_get($key));
}
function error_json($key, &$av) {
    err_set(err_mod_get($key));
    msg_set(msg_mod_get($key));
    smt_append_json($av, '');
}
/**
 *判断文件是否是php
 */
function is_php_file($path) {
    $result = preg_match(REG_REPLACE_PHP, $path);
    return $result;
}
/**
 *自动加载目录下所有php文件
 */
function autoload($dir_path) {
    if( is_dir($dir_path) ){
        $handle = opendir($dir_path);
        while( ($filename = readdir($handle)) !== false )
            if( is_php_file($filename) )
                require_once $dir_path . FS_DELIMITER . $filename;
    }
}
/**
 * 从请求中解析act参数
 */
function get_act($da = 'index') {
    $a = $_REQUEST['act'];
    if(!$a || !preg_match('/^[a-z_0-9]+$/i', $a)) $a = $da;
    return $a;
}
/**
 * 从请求中解析mod参数
 */
function get_mod() {
    $m = $_REQUEST[REQUEST_INPUT_MOD];
    if(!defined('SYNC_LOGINED') || !SYNC_LOGINED)
        $m = REQUEST_DEFAULT_MOD_LOGIN;
    elseif(!$m || !preg_match('/^([a-z_]+)\.(?1)$/i', $m))
        $m = REQUEST_DEFAULT_MOD;
    elseif(!mod_exist($m))
        $m = REQUEST_DEFAULT_MOD;
    return str_replace('.', '/', $m);
}
/**
 * 解析请求中mod名字，以'_'分割
 */
function get_mod_name() {
    return str_replace('/', '_', get_mod());
}
/**
 * 判断请求中的mod文件是否存在
 */
function mod_exist($mod) {
    list($d, $m) = explode('.', $mod);
    $rfile = $d . '/' . $m . '.php';
    return @file_exists(WEB_PATH . $rfile);
}
/**
 * 从请求中解析func方法
 */
function get_func() {
    $mod = get_mod();
    $mod = str_replace('/', '_', $mod);
    $act = get_act();

    $func = $mod . '_' . $act;
    if(function_exists($func))
        return $func;
    set_act();
    return get_dafult_func($mod);
}
/**
 * 设置act主要用于处理错误的action
 */
function set_act($default = 'index') {
    $_REQUEST['act'] = $default;
}
/**
 * 获取默认的func
 */
function get_dafult_func($mod) {
    return $mod . '_index';
}
/**
 * 获得模块初始化的函数
 */
function get_init_func() {
    $mod = get_mod();
    $mod = str_replace('/', '_', $mod);

    return $mod . '_init';
}
/**
 * 从请求中解析tpl
 */
function get_tpl(&$av) {
    $mod = get_mod();
    $act = get_act();
    if ( !isset($av['curr_tpl']) )
        $av['curr_tpl'] = $mod . '_' .  $act . ".tpl";
    if ( smt_appended_json($av) )
        return $av['curr_tpl'];
    return $mod . '.tpl';
}
/**
 * 获得要运行的php文件名
 */
function get_include_mod_file() {
    $file = get_mod();
    $file .= '.php';
    return $file;
}
/**
 * 页面跳转 
 */
function redirect($url) {
    @header("Location:" . $url);
    exit;
}
/**
 * 数组且有数据
 */
function sync_array($a) {
    return is_array($a) && $a;
}
/**
 * 上线系统其它功能的相关函数
 */
function vd() {
    $i = func_num_args();
    $a = func_get_args();
    for($k = 0; $k < $i; ++$k)
        var_dump($a[$k]);

}
/**
 * 检查本地缓存文件夹是否可写
 */
function sync_expdir_e() {
    return file_exists(LOCAL_PATH_PREFIX);
}
function sync_expdir_w() {
    return is_writable(LOCAL_PATH_PREFIX);
}
function sync_bkdir_e() {
    return file_exists(BACKUP_PATH_PREFIX);
}
function sync_bkdir_r() {
    return is_writable(BACKUP_PATH_PREFIX);
}
/**
 * 将文件列表导出到本地
 */
function sync_export_files($flist, $t = false, $rb = false) {
    $r = array();
    $rbs = 0;
    if(!sync_array($flist)) return $r;
    #遍历将文件到处到本地文件系统
    foreach($flist as $k => $v){
        #如果是回滚,则修改文件属性
        if($rb === true) $rbs = sync_item_lv($v, $t);
        if($rbs === null){
            $errmsg = '没有成功同步的历史版本';
            #将出错的文件返回
            $r[$k] = array(
                    'errno' => 9,
                    WT_EM => $errmsg,
                    OP_LIST_KEY_PN => ticket_fl_p($v),
                    OP_LIST_KEY_URL => ticket_fl_u($v),
                    );
            $rbs = 0;
            continue;
        }
        $errmsg = '';
        $rv = 0;
        $result = sync_cp_files_to_path($v, $t, $rv);
        if(!$result){
            if(err_get() === 5) {
                $errmsg = '从svn获得文件失败,url:';
                $errmsg .= $t ? sync_trunk_uri(ticket_fl_u($v),
                    ticket_fl_p($v)) : ticket_fl_u($v);
            }elseif(err_get() === 1)
                $errmsg = '将文件写入本地失败';
            elseif(err_get() === 2)
                $errmsg = 'php文件语法解析错误';
            elseif(err_get() === 7)
                $errmsg = '目录不支持cat操作';
            #将出错的文件返回
            $r[$k] = array(
                    'errno' => err_get(),
                    WT_EM => $errmsg,
                    OP_LIST_KEY_PN => ticket_fl_p($v),
                    OP_LIST_KEY_URL => ticket_fl_u($v),
                    );
        }else $r[$k] = ticket_append_rv($v, $rv, $t);
        err_set(0);
    }
    return $r;
}
/**
 * 格式化打印输出函数,print_r
 */
function pr($str) {
    echo "<pre>"; 
    print_r($str);
    echo "</pre>";
}

# ====================================================用户相关封装函数开始=================================== #
/**
 * 检查用户是否登陆
 */
function check_login() {
    $ck = user_get_cookie_key();
    $cv = isset($_COOKIE[$ck]) ? $_COOKIE[$ck] : null;
    if($cv === null) return false;
    if(strpos($cv, '$')) list($un, $token) = explode('$', $cv);
    else{ logout();return false;}
    $ui = user_info($un);
    $r = $cv === user_get_cookie_token($ui) ? true : false;
    if(!$r) { logout();return false;}
    return true;
}
/**
 * 根据cookie解析用户名
 */
function cookie_username() {
    $ck = user_get_cookie_key();
    $cv = $_COOKIE[$ck];
    if(strpos($cv, '$')) list($un, $token) = explode('$', $cv);
    return $un;
}
/**
 * 检查是否是后台管理员账号
 */
function check_admin_user() {
    if ( current_username() != USER_ADMIN_NAME ) 
        redirect(LOGIN_REDIRECT_LIST_TICKET);
}
/**
 * 获取管理员的uid
 */
function get_admin_uid() {
    $user_info = user_info(USER_ADMIN_NAME);
    if ( sync_array($user_info) )
        return $user_info[USER_FILED_USERID];
    return 0;
}
/**
 * 解析用户的权限
 */
function tidy_user_mod(&$uinfo) {
    if ( sync_array($uinfo) ) 
        $uinfo['user_mod'] = parse_user_mod($uinfo[DB_USERS_MOD]);
    return $uinfo;
}
/**
 * 用户列表 追加用户权限
 */
function tidy_users_mod(&$ulist) {
    if ( sync_array($ulist) ) 
        foreach ( $ulist as $key => &$item ) 
            $ulist[$key] = tidy_user_mod($item);
}
/**
 * 解析用户权限
 */
function parse_user_mod($umod) {
    $r = array();
    $r['select_file']    = ((int)$umod & USER_MOD_SELECT_FILE) == USER_MOD_SELECT_FILE;
    $r['operate_ticket'] = ((int)$umod & USER_MOD_OPERATE_TICKET) == USER_MOD_OPERATE_TICKET;
    return $r;
}
/**
 *用户校验
 */
function check_usermod($username, $password) {
    $user_info = user_info($username);
    if( sync_array($user_info) &&
            isset($user_info[DB_USERS_PASSWORD]) &&
            md5($password) == $user_info[DB_USERS_PASSWORD] )
        return true;
    return false;
}
/**
 * 检查是否有选择文件和同步的权限
 * 默认检查当前用户
 */
function check_mod_f($username = null) {
    $um = user_mod($username);
    $pm = parse_user_mod($um);
    return sync_array($pm) ? $pm['select_file'] : false;
}
function check_mod_o($username = null) {
    $um = user_mod($username);
    $pm = parse_user_mod($um);
    return sync_array($pm) ? $pm['operate_ticket'] : false;
}
/**
 *将用户信息放到cookie里边(如果没有存的话
 */
function sign_logined($user_info, $expire = NULL) {
    $ck = user_get_cookie_key();
    if( !isset($_COOKIE[$ck]) ){
        $cv = user_get_cookie_token($user_info);
        if ($expire == 0)
            setcookie($ck, $cv, $expire, "/");
        else
            setcookie($ck, $cv, time() + $expire, "/");
    }
    return true;
}
/**
 * 获得当前用户名
 */
function current_username() {
    return $GLOBALS['current_username'];
}
/**
 * 获得当前用户id
 */
function current_userid() {
    $ui = user_info();
    return $ui[DB_USERS_ID];
}
/**
 * 获得用户信息加密时候的私钥
 */
function user_get_key() {
    return 'A ITEAM PRODUCT';
}
/**
 * 获得cookie的key
 */
function user_get_cookie_key() {
    return 'synccookie';
}
/**
 * 获得用户信息
 */
function user($un = null) {
    return user_info($un);
}
/**
 * 获得用户的原始信息
 */
function user_raw($un = null) {
    return user_info_raw($un, true);
}
/**
 * 用户退出
 */
function logout() {
    $ck = user_get_cookie_key();
    setcookie($ck, '', time(), '/');
    @session_destroy();
    @session_regenerate_id(true);
    return true;
}
/**
 * 获得登录令牌字符串
 */
function user_get_cookie_token($ui) {
    if(!sync_array($ui)) return false;
    $str = md5($ui[DB_USERS_USERNAME] . $ui[DB_USERS_ID] .
            $ui[DB_USERS_PASSWORD] . $ui[DB_USERS_CREATETIME] . user_get_key());
    return $ui[DB_USERS_USERNAME] . '$' . $str;
}
/**
 * 检查用户登录相关
 */
function logined() { 
    if(check_login()){
        define('SYNC_LOGINED', true);
        #放到全局变量中
        $GLOBALS['current_username']   = cookie_username();
        #标记当前用户名,为smarty使用
        define('CURRENT_USERNAME', current_username());
        #标记当前用户权限
        define('CURRENT_UMOD', user_mod($username));

        $GLOBALS['current_userid']     = current_userid();
    }else define('SYNC_LOGINED', false);
    return SYNC_LOGINED;
}
/**
 * 根据一个svn地址获得版本库相关信息
 */
function sync_svn_repos_info($url, $u, $p) {
    if($u || $p) svn_auth($u, $p);
    return sync_svn_infos($url);
}
/**
 * 比对一个svn分支和一个分支的文件修改是否是相同分支
 * 当某次提交的时候，一并提交了多个项目的文件(修复找到的文件不是本分支的问题)
 */
function comp_svn_url_and_path($path, $pn) {
    $prefix = sync_get_svn_uri($pn);
    if( !$prefix || strpos($path, $prefix) === 0 ) return true;
    return false;
}
/**
 * 根据分支名称获得svn信息
 * 所有需要获取服务器信息的都从这里做入口
 */
function sync_get_svn_uri($pname) {
    $ret = '';
    $svn_id = project_get_svn_id_by_name($pname);
    if(is_int($svn_id) && $svn_id){
        $ret = server_get_svn_uri($svn_id);
    }
    return $ret;
}
/**
 * 根据版本号码和svn路径信息
 * 查看某路径的该版本更新文件信息
 */
function svn_version_file_list($version, $pn, $sort = null) {
    $si = sync_svn_info_p($pn);
    $nr = 1;
    sync_svn_auth($si);
    $array = sync_svn_log($si[SVN_INFO_KEY], $version, $version, $nr);
    #格式化成自己的格式(用路径做键值)
    $ret = svn_log_info_to_array($array, $nr, false, $pn);
    if($sort) sort_svn_log_info_array($ret, 'sort_svn');
    return $ret;
}
/*
 * 根据版本号码和svn路径信息
 * 查看某路径的该版本更新文件信息
 */
function svn_version_file_list_laster_n($version, $pn, $sort = null) {
    $si = sync_svn_info_p($pn);
    #获得路径的所有日志
    sync_svn_auth($si);
    $array = sync_svn_log($si[SVN_INFO_KEY], SVN_REVISION_HEAD, SVN_REVISION_INITIAL, $version);
    #格式化成自己的格式(用路径做键值)
    $ret = svn_log_info_to_array($array, $version , true, $pn);
    if($sort) sort_svn_log_info_array($ret, 'sort_svn');
    return $ret;
}
/**
 * 对结果的排序函数
 * 会丢弃索引,这正是我想要的
 */
function sort_svn_log_info_array(&$array , $callback) {
    usort($array, $callback);
}
/**
 * 设置svn登录信息
 */
function sync_svn_auth($si) {
    svn_auth($si[SYNC_SERVER_INFO_KEY_USERNAME], $si[SYNC_SERVER_INFO_KEY_PASSWORD]);
}
/**
 * 根据一个svn的url获得该地址的最新的版本和trunk的版本
 */
function sync_svn_url_info($fl_item, $brlst = 0x11) {
    $url = $fl_item[OP_LIST_KEY_URL];
    $turl = sync_trunk_uri($url, $fl_item[OP_LIST_KEY_PN]);
    $v = $tv = 0;
    sync_svn_auth_by_pname($fl_item[OP_LIST_KEY_PN]);
    
    #如果是浏览最新的版本的时候，就不需要重新获取文件最新版本了
    if($brlst & 0x20) $v = $fl_item[OP_LIST_KEY_V];
    else $v = $brlst & 0x10 ? svn_file_lv($url) : null;
    if($turl != $url)
        $tv = $brlst & 0x01 ? svn_file_lv($turl): null;
    else $tv = $v;
    return array($v, $tv);
}
/**
 *比对当前分支文件和trunk文件的版本的函数
 */
function sync_svn_cmp($file_path, $pn,
                $version, &$tversion = null,
                &$blv, $full_path = true) {
    $blv = 0;
    $i = sync_svn_info_p($pn);    
    sync_svn_auth($i);
    if($full_path){#库地址
        $trunk_uri = sync_trunk_uri($file_path, $pn);
        $tversion = svn_file_lv($trunk_uri);
        $blv = svn_file_lv($file_path);
        if($version) return $version - $tversion;
    }
    return 0;
}
/**
 * 根据项目名称设置svn登录信息
 */
function sync_svn_auth_by_pname($pname) {
    $si = sync_svn_info_p($pname);
    #获得路径的所有日志
    sync_svn_auth($si);
}
/**
 * 判断将svn文件导出到本地是否成功
 */
function sync_export_ok($r) {
    if(!sync_array($r)) return true;
    foreach($r as $k => $v)
        if(isset($v['errno']) && $v['errno'] != 0)
            return false;
    return true;
}
/**
 * 根据项目名称替换文件的svn地址到trunk
 * 需要修改为提供uri直接返回trunk地址的形式，因为uri中去掉了svn://等等
 */
function sync_trunk_uri($uri, $pn) {
    $uri = sync_trim_path($uri);
    if(!defined('SYNC_SVN_TRUNK') || !SYNC_SVN_TRUNK) return $uri;
    $sif = sync_svn_info_p($pn);
	if( $sif[SVN_INFO_KEY] == $sif[SVN_INFO_KEY_TRUNK] ) return $uri;
    if( $sif[SVN_INFO_KEY] != $sif[SVN_INFO_KEY_TRUNK] && strpos($uri, $sif[SVN_INFO_KEY]) === 0 )
        return str_replace($sif[SVN_INFO_KEY], $sif[SVN_INFO_KEY_TRUNK], $uri);
    return ticket_fmt_uri($sif[SVN_INFO_KEY_TRUNK], '', $uri);
}

# ====================================================ticket相关封装函数开始================================= #
function sync_ticket_info($t_id) {
    return ticket_info($t_id);
}
function sync_ticket_sum($t_id) {
    return ticket_sum($t_id);
}
function sync_history_stime($t_id) {
    return history_get_stime($t_id);
}
function sync_history_get($h_id) {
    return history_info($h_id);
}
function ticket_history_detail($id) {
    $hi = history_info($id);
    #上线单修改
    if($hi['h_type'] == 1)
        $hi['h_sum'] = ticket_unfmt_l($hi['h_sum']);
    #同步历史
    elseif($hi['h_type'] == 2)
        $hi = ticket_fmt_sync_files($hi['h_sum']);
    #同步历史失败
    elseif($hi['h_type'] == 3)
        $hi = unserialize($hi['h_sum']);
    return $hi;
}
function sync_ticket_sync_op($ti) {
    return ticket_sync_op($ti);
}
function sync_history_type($hid) {
    return history_type($hid);
}
/**
 * 上线单列表 
 */
function ticket_list($page = 1, $rows = 10) {
    $r = array();
    $l = ticket_get_latest($page, $rows);
    if(!sync_array($l)) return $r;
    foreach($l as $v) $r[] = ticket_fmt($v);
    return $r;
}
/**
 * 我的上线单列表
 */
function ticket_list_mine($page = 1, $rows = 10) {
    return ticket_list_u(null, $page, $rows);
}
/**
 * 取某个用户的上线单列表
 */
function ticket_list_u($username = null, $page = 1, $rows = 10) {
    if($username === null) $username = current_username();
    $r = array();
    $l = ticket_get_mine($username, $page, $rows);
    if(!sync_array($l))
        return $r;
    foreach($l as $v){
        $r[] = ticket_fmt($v);
    }
    return $r;
}
/**
 * 取某个用户的上线单列表
 */
function ticket_list_t($bt, $et, $type, $page = 1, $rows = 10) {
    $r = array();
    $l = ticket_get_bytime($bt, $et, $page, $rows, $type);
    if(!sync_array($l))
        return $r;
    foreach($l as $v){
        $r[] = ticket_fmt($v);
    }
    return $r;
}
/**
 * 上线单数目
 */
function ticket_list_t_count($bt, $et, $type) {
    return ticket_get_bytime_count($bt, $et, $type);
}
/**
 * 我的上线单的数量
 */
function ticket_list_mine_count() {
    return ticket_count(current_username());
}
/**
 * 某个用户的上线单数量
 */
function ticket_list_count($username) {
    return ticket_count($username);
}
/**
 * 所有上线单数量
 */
function ticket_list_latest_count() {
    return ticket_count();
}
/**
 * 获取自己最新的一个上线单id
 */
function ticket_mine_latest_id() {
    $tid = 0;
    $lt = ticket_get_mine(current_username(), 1, 1);
    if ( sync_array($lt) ) 
        $tid = ticket_id($lt[0]);
    return $tid;
}
/**
 * 格式化一个上线单详情
 */
function ticket_fmt($i) {
    $r = array();
    $r[WT_ID] = ticket_id($i);

    $r[WT_FC] = ticket_sum_fl($i);
    $r[WT_OC] = ticket_sum_op($i);

    $r[WT_OW] = ticket_owner($i);
    $r[WT_OT] = date('Y-m-d H:i:s', ticket_last_op_time($i));
    $r[WT_OP] = sync_op2str(ticket_last_op($i));
    return $r;
}
/**
 * 将文件列表加密用于添加到上线单的时候传递数据
 */
function ticket_flist_encode($flist) {
    if(!sync_array($fl)) return array();
    foreach($flist as $v)
        $r[] = ticket_fitem_encode($v);
    return $r;
}
function ticket_flist_decode($flist) {
    if(!sync_array($flist)) return array();
    foreach($flist as $v)
        $r[] = ticket_fitem_decode($v);
    return $r;
}
function ticket_fitem_encode($f_item) {
    return base64_encode(serialize($f_item));
}
function ticket_fitem_decode($f_item) {
    return unserialize(base64_decode($f_item));
}
function ticket_flist_fmt($fl, $brlst = 0x11) {
    $r = array();
    $oerrno = err_get();
    if(!sync_array($fl))
        return $r;
    $flc = count($fl);
    foreach($fl as $k => $v){
        #获得文件属性信息字符串
        $v[WT_EC] = ticket_fitem_encode($v);
        #获得文件的唯一url
        $v[WT_UL] = ticket_fl_u($v);
        #获得最新和trunk版本
        if($flc <= SYNC_SVN_DIFF_MAX){
            list($lv, $lvt) = sync_svn_url_info($v, $brlst);
            $v[WT_NV] = $lv;
            $v[WT_TV] = $lvt;
        }else{
            $v[WT_NV] = null;
            $v[WT_TV] = null;
        }
        #获得前缀图片文件名
        $v[WT_PC] = ticket_f2png($v);
        $v[WT_AR] = sync_file_op2str($v['action']);
        $v[WT_KY] = $k;
        $r[] = $v;
    }
    err_set($oerrno);
    return $r;
}
/**
 * 新创建上线单
 */
function ticket_create($id) {
    if(!ticket_info($id) &&
        ticket_create_new($id)) {
        return true;
    }
    return false;
}
/**
 * 获得上线单的详情
 */
function ticket_detail($id, $nfl = true) {
    $r = array();
    $ti = ticket_info($id);
    if($ti){
        $r[WT_ID] = ticket_id($ti);
        $r[WT_OW] = ticket_owner($ti);
        $r[WT_FC] = ticket_sum_fl($ti);
        if($nfl) $r[WT_FL] = ticket_flist_fmt(ticket_flist($r[WT_ID]));
        $r[WT_OP] = sync_op2str(ticket_last_op($ti));
        $r[WT_OL] = ticket_ops($r[WT_ID]);
        $r[WT_CT] = date('Y-m-d H:i:s', ticket_first_op_time($ti));
        $r[WT_ST] = ticket_sync_op($ti) ? true : false;
        $r[WT_ST] = $r[WT_ST] && sync_rollbackalbe(ticket_flist($id)) ? true : false;
    }
    return $r;
}
/**
 * 判断上线单是否存在
 */
function ticket_exist($id) {
    $ti = ticket_info(intval($id));
    return $ti ? true : false;
}
/**
 * 获得上线单的详情
 * id 上线单id
 * dfilist 要删除的文件列表的md5校验值
 */
function ticket_delete_flist($id, $dflist) {
    $ti = ticket_info($id);
    if(!$ti) error('idnoexist');
    $tid = ticket_id($ti);
    
    $hid = history_create_flist($id, 0, '', current_username(), '', time());
    if( !ticket_del_flist($id, $dflist, $hid, $dlist) ) error('m_flist_fail');
    history_update($hid, $dlist, 1);
    return ticket_get_flist($id);
}
/**
 * 选择文件的首屏
 */
function ticket_select() {
    $r = array();
    $pl = project_group_list_all();
    if(sync_array($pl))
        foreach($pl as $k => $v)
            $r[] = array('pn' => $k, 'pv' => $v);
    return $r;
}
/**
 * 选择文件的项目组的项目集合
 */
function ticket_select_project($gid) {
    $r = array();
    $t = project_get_group_list($gid);
    if(sync_array($t))
        foreach($t as $v)
            $r[] = array('pn' => $v[DB_PROJECTS_NAME], 'pv' => $v[DB_PROJECTS_NAME]);
    return $r;
}
/**
 * ------------------------非常重要
 * 文件列表内部统一数据结构
 * uri  文件相对(项目)地址
 * v 文件版本
 * pn 项目名称
 * author 文件修改者
 * date 文件修改时间
 * action 文件修改类型
 * isdir 是否是目录
 * px 项目svn前缀
 * up 项目svn 用户定义前缀
 */
function ticket_fmt_fl($uri, $v, $pn, $author, $date, $action, $isdir, $px, $up) {
    return array(
            OP_LIST_KEY_ACTION        => $action,
            OP_LIST_KEY_AUTHOR        => $author,
            OP_LIST_KEY_PN            => $pn,
            OP_LIST_KEY_DATE          => $date,
            OP_LIST_KEY_DIR           => $isdir,
            OP_LIST_KEY_URI           => $uri,
            OP_LIST_KEY_V             => $v,
            OP_LIST_KEY_PREFIX        => $px,
            OP_LIST_KEY_UPREFIX       => $up,
        );
}
/**
 * 在文件对象中追加真实导出的版本
 */
function ticket_append_rv($item, $rv, $t) {
    $item[OP_LIST_KEY_RV] = $rv;
    $item[OP_LIST_KEY_T]  = $t;
    return $item;
}
/**
 * 同步结果的数据结构
 * 包含文件对象的数据结构的一部分
 */
function ticket_fmt_sync_fl($item, $rpath, $errno, $msg) {
    return array(
                OP_LIST_KEY_RPATH    => $rpath,
                'item'     => $item,
                'errno'    => $errno,
                'errmsg'   => $msg,
            );
}
/**
 * 浏览一个项目的svn版本历史
 */
function ticket_browser($pn, $version, $sort = false) {
    $flist = array();
    if( intval($version) < SYNC_SVN_LOG_MAX){#浏览某分支最新的n条提交
        $flist = svn_version_file_list_laster_n($version, $pn, $sort);
        $brlst = 0x21;
    }else{
        $flist = svn_version_file_list($version, $pn, $sort);
        $brlst = 0x11;
    }
    #获得了底层的数据结构需要格式化成展示的数据结构    
    $flist = ticket_browser_fmt($pn, $flist, $brlst);
    return $flist;
}
/**
 * 格式化浏览时候的文件列表
 * 是否查看对应文件的最新版本和trunk的最新版本
 */
function ticket_browser_fmt($pn, $flist, $brlst = 0x11) {
    $r = array();
    if(!sync_array($flist)) return $r;
    $flist = ticket_tidy($pn, $flist);
    $flist = ticket_flist_fmt($flist, $brlst);
    return $flist;
}
/**
 * 更新上线单文件列表
 */
function ticket_save_flist($id, $pname, $flist) {
    $ti = ticket_info($id);
    if(!$ti) error('idnoexist');
    #检查项目是否存在
    if( !sync_svn_info_p($pname) ) return $false;
    #文件列表是否为空
    if(!sync_array($flist)) return false;

    $flist = ticket_flist_decode($flist);
    if(!sync_array($flist)) return false;
    #检查php语法错误    
    $php_erros = sync_php_syntax_flist($flist);
    if(sync_array($php_erros)) {
        error('syntaxerror');
        foreach($php_erros as $v)
            $el[] = ticket_fl_uri($v);
        $el = implode("<br />\n", $el);
        msg_set(msg_get() . ':<br />' . $el);
        return;
    }

    #获得操作结果的历史记录id
    $hid = history_create_flist($id, 0, '',
            current_username(), ticket_fmt_l($flist), time());

    $result = sync_ticket_info_m($id, $pname, $flist, $hid);
    #保存失败，在这里设置错误信息是否合适？
    if(!$result) {error('m_flist_fail');return;}
    return ticket_get_flist($id);
}
/**
 * 获得格式化的最新的文件列表
 */
function ticket_get_flist($id) {
    $r[WT_FL] = ticket_flist_fmt(ticket_flist($id));
    return $r;
}
/**
 * 获得格式化的最新的操作列表
 */
function ticket_get_history($id) {
    $r[WT_OL] = ticket_ops($id);
    return $r;
}
/**
 * 根据上线单中的文件版本与最新版本的比较获得图片
 * 如果是最新版本返回 0
 * cv    当前版本
 * lv    最新版本
 * tv    trunk最新版本
 */
function ticket_fv2png($cv, $lv, $tv) {
    if($lv > $cv) return 'filenotlst.png';
    elseif($tv > $cv) return 'filemerged.png';
    return 0;
}
/**
 * 根据上线单中的文件版本的操作获得图片
 * act 文件操作
 * dir 是否是目录
 */
function ticket_fa2png($act = SVN_FILE_ACTION_TYPE_M, $dir = false) {
    if(!$dir) return 'file' . strtolower($act) . '.png';
    return 'dir' . strtolower($act) . '.png';
}
function ticket_f2png($fitem) {
    $t = ticket_fv2png($fitem['version'], $fitem[WT_NV], $fitem[WT_TV]);
    if($t === 0) return ticket_fa2png(ticket_fl_c($fitem), ticket_fl_dir($fitem));
    return $t;
}
/**
 * 输出同步页面
 */
function ticket_sync($id) {
    $r = array();
    $p_names = ticket_get_project_names($id);
    if(!sync_array($p_names)) return $r;
    foreach($p_names as $k => $v){
        $sids = project_get_servers($k);
        foreach($sids as $sk => $sv){
            $desc = server_desc($sv);
            $ip = server_ip($sv);
            $key =  sync_project_server_uid($k, $sv);
            $r[$k][] = array('desc' => $desc, 'ip' => $ip, 'key' => $key);
        }
    }
    return $r;
}
/**
 * 输出执行脚本页面
 */
function ticket_run($id) {
    $r = array();
    $p_names = ticket_get_project_names($id);
    if(!sync_array($p_names)) return $r;
    foreach($p_names as $k => $v){
        $sids = project_get_servers($k);
        foreach($sids as $sk => $sv){
            $desc = server_desc($sv);
            $ip = server_ip($sv);
            $key =  sync_project_server_uid($k, $sv);
            $r[$k][] = array('desc' => $desc, 'ip' => $ip, 'key' => $key);
        }
    }
    return $r;
}

/**
 * 执行指定脚本 
 * id 上线单的id
 * servers 服务器标识
 */ 
function ticket_run_shell($id, $servers, $f) {
	error_log('ticket_run_shell',0);
	$r = array();
    $t = time();
	
	$r = run_shells_on_servers($id, $servers, $t, $f);
	if($r == null  ){
        return false;
    }
    return $r;
}
/**
 * 同步上线单的文件到指定服务器
 * id 上线单的id
 * servers 要同步的服务器标识
 */
function ticket_sync_files($id, $servers, $f) {
    $r = array();
    $t = time();
    $hid = history_create_sync($id, 0, $f, current_username(), '', $t);
    #记录上线单历史
    ticket_sync_action($id, $hid);
    #同步上线单
    $sync_flist = sync_files_to_servers($id, $servers, $t, $f === 'trunk');
    #导出文件到本地过程中失败了
    if($sync_flist === false && err_get()){
        err_set(0);        
        history_update($hid, msg_get(), 3);
        return false;
    }

    $r = ticket_fmt_sync_files($sync_flist);
    #记录同步历史
    history_update($hid, $sync_flist);
    #更新文件部署情况
    $o = sync_file_list($sync_flist);
    if(sync_array($o)) sync_list_appends($o);

    return $r;
}
/**
 * 回滚操作
 */
function ticket_rolback_files($id, $servers) {
    $r = array();
    $t = time();
    $hid = history_create_rollback($id, 0, $f, current_username(), '', $t);
    #记录上线单历史
    ticket_sync_action($id, $hid, OP_TYPE_ROLLBACK);
    #同步上线单
    $sync_flist = sync_files_to_servers($id, $servers, $t, $f === 'trunk', true);
    #导出文件到本地过程中失败了
    if($sync_flist === false && err_get()){
        err_set(0);        
        history_update($hid, msg_get(), 3);
        return false;
    }
    $r = ticket_fmt_sync_files($sync_flist);
    #记录同步历史
    history_update($hid, $sync_flist);
    return $r;
}
/**
 * 格式化同步结果
 */
function ticket_fmt_sync_files($s) {
    if(is_string($s)) $s = unserialize($s);
    if(sync_array($s))
        foreach($s as $sid => $v){
            $si = sync_format_server_info($sid);
            $r[] = array('server_info' => $si, 'sync_result' => $v);
        }
    return $r;
}
/**
 *上线单排序
 */
function sync_fl_sort(&$fl, $sort_fun) {
    uasort($sort_fun, $sort_fun);
}
/**
 * 回滚方法
 */
function sync_files_rollback_to_server($h_id) {
    $hi = history_get_byid($h_id);    
    $s_id = history_server_id($hi);
    $server = sync_format_server_info($s_id);
    $r = ssh2_scp_files_rollback($server, $h_id);
    return $r;
}
function run_shells_on_servers($tid, $psuids = array(), $time, $file)
{
	error_log('run_shells_on_servers',0);
	$ret = array();
    if(!$tid || !$psuids || !$file) return array();
    #找到需要同步的项目和服务器
    $pns = sync_format_psuids($psuids);
    if(!$pns) return array();
    $s_ids = sync_fmt_sids($pns); 
    if(!$s_ids) return array();
    #获得所有要同步的ip
    foreach($s_ids as $s_id => $iv){
		$ret[$s_id] = run_shell_fl($s_id, $file);
		#error_log($file .'-'. $s_id, 0);
	}
    return $ret;
 
}
/**
 * 将上线单的文件同步到相应项目指定的服务器上去
 * 工作流程
 * 1: 将需要同步的文件复制到本地
 * 2: 将要同步的文件格式化成特定数据结构，其中有要本地和目标服务器的绝对路径和目标服务器的ip
 * 3: 将2步骤的数据结构重新格式化,使用ip为索引,方便复制数据
 * 4: 依次将各个服务器的文件复制过去
 */
function sync_files_to_servers($tid, $psuids = array(), $time, $t = false, $rb = false){
    $ret = array();
    if(!$tid || !$psuids) return array();
    #找到需要同步的项目和服务器
    $pns = sync_format_psuids($psuids);
    if(!$pns) return array();
    $s_ids = sync_fmt_sids($pns); 
    if(!$s_ids) return array();
    #获得所有要同步的ip
    if(sync_array($fl = ticket_flist($tid) ) ){
        #将文件检出到本地
        $result = sync_export_files($fl, $t, $rb);
        if(sync_export_ok($result)){
            $newfl = $result;
            /**
             * 文件准备好了，我要依次同步到各个服务器上
             */
            foreach($s_ids as $s_id => $iv)
                $ret[$s_id] = sync_scp_fl($s_id, $newfl);
        }else{
            err_set(1);
            msg_set($result);
            return false;
        }
    }
    return $ret;
}
/**
 * 执行文件列表
 */
function run_shell_fl($s_id, $fl) {
	#error_log("run_shell_fl",0);
	$s = sync_format_server_info($s_id);
    return ssh2_run_files($s, $fl);
}

/**
 * 将文件列表中的文件同步到某台服务器
 */
function sync_scp_fl($s_id, $fl) {
    $s = sync_format_server_info($s_id);
    return ssh2_scp_files($s, $fl);
}
/**
 * 判断是否要备份指定服务器的文件列表
 * 如果是首次同步就备份下为回滚做准备
 * 暂时不使用此功能
 */
function sync_backup($t_id, $s_id, $fl, $t, $time) {
    #记录同步历史
    $sum = sync_ticket_sum($t_id);
    $hid = history_create($t_id, $s_id, $t, current_username(), $sum, $time, 0);
    $s = sync_format_server_info($s_id);
    #开始从远程服务器备份文件
    $r = ssh2_scp_files_backup($t_id, $s, $fl, $hid);
    return $r;
}
/**
 * 修改上线单信息
 */
function sync_ticket_info_m($t_id, $pname, $file_list = array(), $hid = null){
    sync_svn_auth_by_pname($pname);
    return ticket_modify($t_id, $pname, $file_list, $hid);
}
/**
 * 文件列表中匹配某个server的文件
 */
function sync_file_filter($fl, $sid) {
    $r = array();
    if(sync_array($fl))
        foreach($fl as $k => $item)
            if(sync_fs_match($item, $sid))
                $r[$k] = $item;
    return $r;
}
function sync_file_abs_path($uri, $pname) {
    return file_abs_path($uri, $pname);
}
function sync_file_abs_path_backup($name) {
    return file_abs_path_backup($name);
}
function sync_file_path_backup($name) {
    return file_path_backup($name);
}
/**
 * 获得所有的需要同步的ip
 */
function sync_fmt_sids($a = array()){
    $sids = array();
    if(!$a || !is_array($a))
        return array();
    foreach($a as $k => $v)
        if(sync_array($v))
            foreach($v as $sid)
                $sids[$sid] = true;
    return $sids;
}
/**
 * 将数据格式化成项目为key的数据
 */
function sync_format_spids($psuids = array()){
    if(!$psuids || !is_array($psuids)) return array();
    $servers = array();
    foreach($psuids as $k => $v)
        foreach($v as $vv)
            $servers[$vv][$k] = true;
    return $servers;
}
function sync_get_version($url, $t , $v, $rv) {
    if(!$t) return $v;
    if($rv) return $rv;
    return svn_file_lv($url);
}
/**
 * 根据文件列表的文件信息将文件cp到指定前缀的地方
 * 如果是回滚就获得文件最后的版本
 */
function sync_cp_files_to_path($item, $t = false, &$rv) {
    #获得svn服务器信息，并设置登录信息
    sync_svn_auth_by_pname(ticket_fl_p($item));

    #当操作不是删除时候需要导出文件
    if( ticket_fl_c($item) == SVN_FILE_ACTION_TYPE_D) return true;
    #是文件
    if(!ticket_fl_dir($item)){
        #获得对应分支的trunk的url
        $url = $t ? sync_trunk_uri(ticket_fl_u($item), ticket_fl_p($item)) :
                                ticket_fl_u($item);
        $ver = sync_get_version($url, $t, ticket_fl_v($item), ticket_fl_rv($item));
        #trunk文件不存在
        if($ver === 0) return false;
        $rv = $ver;
        $contents = sync_svn_cat($url, $ver);

        if($contents === false) return false;

        if(sync_create_file(ticket_fl_uri($item), $contents,
                    ticket_fl_p($item), ticket_fl_dir($item))){
            if(!sync_file_post_action($item)) return false;
            return true;
        }
        return false;
    }else{#是目录就要判断是否存在,不存在就建立
        return sync_mkdir(ticket_fl_uri($item), $pn, ticket_fl_dir($item));
    }
}
function sync_file_post_action($item) {
    $abs_path = file_abs_path(ticket_fl_uri($item), ticket_fl_p($item));
    if(is_css_or_js(ticket_fl_uri($item)))#如果是css或者js就压缩
        file_compress_static($abs_path);

    if(!need_syntax($item)) return true;

    $r = php_check_syntax($abs_path);
    if($r){ err_set(2); return false; }
    return true;
}
/**
 * 将操作类型转换成可读字符
 */
function sync_op2str($op) {
/**
 *定义对上线单做操作的map
 */
    $_ACTION_TYPE_TO_CHAR = array(
            OP_TYPE_ROLLBACK        => '回滚',
            OP_TYPE_CREATE_TIME     => '创建上线单',
            OP_TYPE_MODIFY_TIME     => '增加文件',
            OP_TYPE_DEL_TIME        => '删除文件',
            OP_TYPE_SYNC_TIME       => '同步',
            );
    return $_ACTION_TYPE_TO_CHAR[$op];
}
/**
 * 将文件的修改类型转换成可读文字
 */
function sync_file_op2str($op) {
    $SVN_ACTION_MAP = array(
            SVN_FILE_ACTION_TYPE_M  => '修改',
            SVN_FILE_ACTION_TYPE_D  => '删除',
            SVN_FILE_ACTION_TYPE_A  => '增加',
            SVN_FILE_ACTION_TYPE_R  => '替换'
    );
    return $SVN_ACTION_MAP[$op];
}
# ====================================================ticket相关封装函数结束================================= #

# ==================================================server相关封装函数开始=================================== #
/**
 * 判断一个项目是否有要同步的服务器
 */
function sync_project_servers($pn, $pservers) {
    return array_key_exists($pn, $pservers) && $pservers[$pn] ? true : false;
}
/**
 * 将数据格式化成项目为key的数据
 */
function sync_format_psuids($a = array()){
    if(!$a || !sync_array($a)) return array();
    $servers = array();
    foreach($a as $v){
        $t = sync_project_server_by_uid($v);
        if(is_array($t) && count($t) == 1)
            foreach($t as $pn => $sid)
                $servers[$pn][] = $sid;
    }
    return $servers;
}
function sync_format_server_info_svn($s_id) {
    return sync_format_server_info($s_id);
}
function sync_format_server_info_ssh2($s_id) {
    return sync_format_server_info($s_id);
}
/**
 * 判断一个文件是否匹配一个server
 */
function sync_fs_match($item, $sid) {
    $ss = project_get_servers(ticket_fl_p($item));
    if(sync_array($ss))
        return in_array($sid, $ss);
    return false;
}
/**
 * 判断服务器的22端口是否对方存活
 */
function sync_ssh2_server_alive($host, $u, $p, $port = 22) {
    return ssh_connect_to_server($host, $port, $u, $p) ? true : false;
}
/**
 * 根据分支名称获得svn信息
 * 所有需要获取服务器信息的都从这里做入口
 */
function sync_svn_info_p($pn) {
    $ret = array();
    $pif = project_get_by_name($pn);
    $svn_id = project_get_svn_id_by_name($pn);
    if(is_int($svn_id) && $svn_id)
        $ret = sync_format_server_info($svn_id);
    return $ret;
}
/**
 * 获得文件服务器的绝对路径
 */
function sync_server_abs_path($uri, $s_id) {
    return server_abs_path($uri, $s_id);
}
/**
 * 根据server的id获得服务器信息的数据结构
 * 如果给定的数据结构是数组，那么直接进行格式化
 * 根据scheme不同发挥不同的数据结构
 */
function sync_format_server_info($s_id) {
    $ret = array();
    $s_info = sync_array($s_id) ? $s_id : server_get($s_id);
    if($s_info){
        $ret[SYNC_SERVER_INFO_KEY_ID] = $s_info[DB_SERVERS_ID];
        if(server_svn($s_info[DB_SERVERS_TYPE])){
            $ret[SVN_INFO_KEY] = sync_trim_path(sprintf("%s://%s:%s/%s/%s",
                                    $s_info[DB_SERVERS_SCHEME], $s_info[DB_SERVERS_IP],
                                    $s_info[DB_SERVERS_PORT], $s_info[DB_SERVERS_PREFIX],
                                    $s_info[DB_SERVERS_SURI]));
            $ret[SVN_INFO_KEY_TRUNK] = sync_trim_path(sprintf("%s://%s:%s/%s/%s",
                                    $s_info[DB_SERVERS_SCHEME], $s_info[DB_SERVERS_IP],
                                    $s_info[DB_SERVERS_PORT], $s_info[DB_SERVERS_PREFIX],
                                    $s_info[DB_SERVERS_TURI]));
            $ret[SVN_INFO_KEY_PREFIX] = sync_trim_path(sprintf("%s://%s:%s/%s", $s_info[DB_SERVERS_SCHEME],
                                    $s_info[DB_SERVERS_IP], $s_info[DB_SERVERS_PORT], $s_info[DB_SERVERS_PREFIX]));
            $ret[SVN_INFO_KEY_URI] = sync_trim_path($s_info[DB_SERVERS_SURI]);
            $ret[SYNC_CSS_OP] = $s_info[DB_SERVERS_TYPE] & SYNC_SERVER_TYPE_SVN_STATIC ? true : false;
            $ret[SVN_INFO_KEY_SERVER] = $s_info;
            $ret[SVN_INFO_KEY_SVNSE]  = true;
        }elseif(server_file($s_info[DB_SERVERS_TYPE])){
            $ret[SYNC_SERVER_INFO_KEY_IP]       = ($s_info[DB_SERVERS_IP]);
            $ret[SYNC_SERVER_INFO_KEY_PORT]     = ($s_info[DB_SERVERS_PORT]);
            $ret[SYNC_SERVER_INFO_KEY_WWWROOT]  = sync_trim_path($s_info[DB_SERVERS_PREFIX]);
            $ret[SVN_INFO_KEY_FILESE]           = true;
        }
        $ret[SVN_INFO_KEY_CLOSE]            = $s_info[DB_SERVERS_DEL];
        $ret[SVN_INFO_KEY_DESC]             = sync_trim_path($s_info[DB_SERVERS_DESC]);
        $ret[SYNC_SERVER_INFO_KEY_USERNAME] = sync_trim_path($s_info[DB_SERVERS_USERNAME]);
        $ret[SYNC_SERVER_INFO_KEY_PASSWORD] = sync_trim_path($s_info[DB_SERVERS_PASSWORD]);
    }
    return $ret;
}
/**
 * 服务器是否是在使用状态 
 */
function server_use($sid) {
    $ret    = false;
    $server = server_get($sid);
    if ( is_array($server) && $server[DB_SERVERS_ID] > 0 ) {
        $s_type = $server[DB_SERVERS_TYPE];
        $s_list = project_list_by_server($sid, $s_type);
        if ( sync_array($s_list) )
            $ret = true;
    }
    return $ret;
}
# ==================================================server相关封装函数结束=================================== #

# ==================================================project相关封装函数开始================================== #
/**
 * 根据项目名字判断项目是否已经存在
 */
function sync_project_exists($pn) {
    if(!$pn) return false;
    return project_get_by_name($pn) ? true : false;
}
/**
 * 根据项目获得svn前缀svn://ip:port/prefix
 */
function sync_svn_prefix($pn) {
    $si = sync_svn_info_p($pn);
    return isset($si[SVN_INFO_KEY_PREFIX]) ? $si[SVN_INFO_KEY_PREFIX] : '';
}
/**
 * 根据项目名字获取项目的svn branch地址
 */
function sync_svn_uri($pn) {
    $si = sync_svn_info_p($pn);
    return isset($si[SVN_INFO_KEY_URI]) ? $si[SVN_INFO_KEY_URI] : '';
}
/**
 * 根据项目名字获取项目的trunk的url
 */
function sync_svn_turl($pn) {
    $si = sync_svn_info_p($pn);
    return isset($si[SVN_INFO_KEY_TRUNK]) ? $si[SVN_INFO_KEY_TRUNK] : '';
}
/**
 * 获得项目名称和服务器id的唯一串
 */
function sync_project_server_uid($pn, $sid) {
    return base64_encode($pn . '$' . $sid);
}
/**
 * 获得项目名称和服务器id的唯一串
 */
function sync_project_server_by_uid($s) {
    list($pn, $sid) = explode('$', base64_decode($s));
    return array($pn => $sid);
}
/**
 * 获取项目信息
 */
function sync_project_get($id) {
    return project_get($id);
}
# --------------------------------------------------------project相关封装函数结束----------------------------------------#

# ========================================================smarty封装开始===================================== #
/**
 * 以$k为键赋值
 */
function smt_append_value(&$a, $v, $k = 'list') {
    $a[$k] = $v;
}
/**
 * 以list为key赋值
 */
function smt_append_list(&$a, $v, $k = 'list') {
    smt_append_value($a, $v, $k);
}
/**
 * 以ticket为key赋值
 */
function smt_append_ticket(&$a, $v, $k = 'ticket') {
    smt_append_value($a, $v, $k);
}
/**
 * 以curr_tpl为key赋值
 */
function smt_append_tpl(&$a, $v, $k = 'curr_tpl') {
    smt_append_value($a, $v, $k);
}
/**
 * 以page_str为key赋值
 */
function smt_append_page(&$a, $v, $k = 'page_str') {
    smt_append_value($a, $v, $k);
}
/**
 * 以guide为key赋值
 */
function smt_append_guide(&$a, $v, $k = 'guide') {
    smt_append_value($a, $v, $k);
}
/**
 * 以item为key赋值 
 */
function smt_append_item(&$a, $v, $k = 'item') {
    smt_append_value($a, $v, $k);
}
/**
 * 以href为key赋值 
 */
function smt_append_href(&$a, $v, $k = 'href') {
    smt_append_value($a, $v, $k);
}
/**
 * 以json为key赋值
 */
function smt_append_json(&$a, $tpl = NULL, $v = true, $k = 'json') {
    if($tpl !== NULL) smt_append_tpl($a, $tpl);
    smt_append_value($a, $v, $k);
}
/**
 * 以title为key赋值
 */
function smt_append_title(&$a, $v, $k = 'sync_title') {
    if ( $v ) $v = SYNC_MAIN_TITLE . $v;
    smt_append_value($a, $v, $k);
}
/**
 * 判断是否有json为key
 */
function smt_appended_json(&$a) {
    return sync_array($a) && array_key_exists('json', $a) ? true : false;
}
function smt_sub_json(&$a, $k = 'json') {
    if(isset($a['curr_tpl'])) unset($a['curr_tpl']);
    unset($a[$k]);
}
# ========================================================smarty封装结束===================================== #

# ========================================================后台相关方法开始=================================== #
/**
 * 解析post数据
 */
function get_post_dt() {
    $dt = array();
    switch ( CURR_MOD ) {
    case 'console/server':
        get_s_dt($dt);
        break;
    case 'console/pgroup':
        $dt['id']   = CONSOLE_ID;
        $dt['gn']   = (string)$_REQUEST[PGROUP_INPUT_NAME];//项目组名称
        $dt['gd']   = (string)$_REQUEST[PGROUP_INPUT_GROUP_DESC];//项目组描述
        $dt['cl']   = (string)$_REQUEST[PGROUP_INPUT_IS_DEL];//项目组状态
        break;
    case 'console/project':
        $dt['id']   = CONSOLE_ID;
        $dt['pn']   = (string)$_REQUEST[PROJECT_INPUT_NAME];//项目名称
        $dt['gid']  = (string)$_REQUEST[PROJECT_INPUT_GROUP_ID];//项目组id
        $dt['sn']   = (int)$_REQUEST[PROJECT_INPUT_SERVER_SVN];//svn服务器
        $dt['sf']   = $_REQUEST[PROJECT_INPUT_SERVER_FILE];//文件服务器
        $dt['cl']   = $_REQUEST[PROJECT_INPUT_STATUS];//项目状态
        break;
    case 'console/user':
        $dt['id'] = (int)$_REQUEST[USER_INPUT_ID];
        $dt['un'] = (string)$_REQUEST[USER_INPUT_USERNAME];//用户名
        $dt['pd'] = (string)$_REQUEST[USER_INPUT_PASSWORD]; //密码
        $dt['rpd']= (string)$_REQUEST[USER_INPUT_RPASSWORD]; //重复密码
        $dt['ud'] = get_user_mod();//整理用户权限
        $dt['cl'] = (int)$_REQUEST[USER_INPUT_IS_DEL];//用户状态
        break;
    case 'console/guide':
        if ( CURR_ACT == 'step1' ) 
            $dt['pn'] = (string)$_REQUEST[PROJECT_INPUT_NAME];
            $dt['gn'] = (string)$_REQUEST[PGROUP_INPUT_NAME];
        if (  CURR_ACT == 'step2' || CURR_ACT == 'step3' )
            get_s_dt($dt);
        break;
    }
    return $dt;
}
/**
 * 获取创建server提交的post数据
 */
function get_s_dt(&$dt) {
    $dt['id']   = CONSOLE_ID;
    $dt['dc']   = (string)$_REQUEST[SERVER_INPUT_DESC];//描述
    $dt['un']   = (string)$_REQUEST[SERVER_INPUT_USER_NAME];//用户名
    $dt['pd']   = (string)$_REQUEST[SERVER_INPUT_PASSWORD];//密码
    $dt['st']   = (string)$_REQUEST[SERVER_INPUT_S_TYPE];//服务器类型
    $dt['si']   = (string)$_REQUEST[SERVER_INPUT_S_URI];//branch地址
    if(defined('SYNC_SVN_TRUNK') && SYNC_SVN_TRUNK)
		$dt['ti']   = (string)$_REQUEST[SERVER_INPUT_TRUNK_URI];//trunk地址
    $dt['ip']   = (string)$_REQUEST[SERVER_INPUT_IP_URL];//ip地址 
    $dt['sm']   = (string)$_REQUEST[SERVER_INPUT_SCHEME];//scheme
    $dt['pt']   = ( (int)$_REQUEST[SERVER_INPUT_PORT] > 0 ) ? 
        (int)$_REQUEST[SERVER_INPUT_PORT] : FILE_SERVER_DEFAULT_PORT;
    $dt['px']   = (string)$_REQUEST[SERVER_INPUT_PREFIX];//目录前缀
    $dt['cl']   = (int)$_REQUEST[SERVER_INPUT_IS_DEL];//服务器状态
}
/**
 * 检测后台数据
 */
function val_data(&$dt) {
    switch ( CURR_MOD ) {
    case 'console/server' : //添加服务器数据校验
        return _val_s_dt($dt);
        break;
    case 'console/pgroup' : //项目组创建校验数据
        return _val_pg_dt($dt);
        break;
    case 'console/project' : //创建项目数据校验
        return _val_p_dt($dt);
        break;
    case 'console/user' :
        return _val_u_dt($dt);
        break;
    case 'console/guide' :
        if ( CURR_ACT == 'step1')
            return val_gp_dt($dt);
        else if (  CURR_ACT == 'step2' || CURR_ACT == 'step3' )
            return _val_s_dt($dt);
        break;
    }
}
/**
 * 校验server数据
 */
function _val_s_dt(&$dt) {
    $r = array();
    if ( !_check_str_length($dt['dc']) ) {
        err_set(WARING_CODE);
        $r[SERVER_INPUT_DESC]   = SERVER_MESSAGE_DESC_ERR;
    } else if ( server_desc_exist($dt['dc'], $dt['id']) ) {
        err_set(WARING_CODE);
        $r[SERVER_INPUT_DESC]   = SERVER_MESSAGE_DESC;
    }
    #如果是svn服务器
    if  ( server_svn($dt['st']) ) {
        #检测branch地址
        $err = svn_server_info($dt['si'], $dt['un'], $dt['pd']);
        if ( $err != 0 ) { 
            err_set($err);
            if ( count($GLOBALS[SERVER_ERR_INPUT][SERVER_ERR_BRANCH][$err]) > 1 ) {
                foreach ( $GLOBALS[SERVER_ERR_INPUT][SERVER_ERR_BRANCH][$err] as $k => $v ) 
                    $r[$v] = svn_si_errmsg($err);
            } else {
                $r[$GLOBALS[SERVER_ERR_INPUT][SERVER_ERR_BRANCH][$err]]  = svn_si_errmsg($err);
            }
        } else
            $bf = sync_svn_infos($dt['si']);
        #检测trunk地址
		if(defined('SYNC_SVN_TRUNK') && SYNC_SVN_TRUNK){
        $err = svn_server_info($dt['ti'], $dt['un'], $dt['pd']);
        if ( $err != 0 ) { 
            err_set($err);
            if ( count($GLOBALS[SERVER_ERR_INPUT][SERVER_ERR_TRUNK][$err]) > 1 ) {
                foreach ( $GLOBALS[SERVER_ERR_INPUT][SERVER_ERR_TRUNK][$err] as $k => $v ) 
                    $r[$v] = svn_si_errmsg($err);
            } else
                $r[$GLOBALS[SERVER_ERR_INPUT][SERVER_ERR_TRUNK][$err]]  = svn_si_errmsg($err);
        } else {
            $tf = sync_svn_infos($dt['ti']);
        }
		}
        if ( err_get() == 0 ) {
            $dt['sm']    = $bf['scheme'];
            $dt['ip']    = $bf['host'];
            $dt['pt']    = $bf['port'];
            $dt['px']    = $bf['prefix'];
            $dt['si']    = $bf['uri'];
			if(defined('SYNC_SVN_TRUNK') && SYNC_SVN_TRUNK)
            	$dt['ti']    = $tf['uri'];
        }
    #如果是文件服务器
    } else if ( server_file($dt['st']) ) {
        if(!$dt['ip']) $r[SERVER_INPUT_IP_URL]      = '主机地址不能为空';    
        if(!$dt['un']) $r[SERVER_INPUT_USER_NAME]   = '用户名不能为空';    
        if(!$dt['pd']) $r[SERVER_INPUT_PASSWORD]    = '密码不能为空';    
        if(!$dt['px']) $r[SERVER_INPUT_PREFIX]      = '部署路径不能为空';
        if(!$dt['pt']) $r[SERVER_INPUT_PORT]        = '服务器端口不能为空';
        if(!$dt['ip'] || !$dt['un'] || !$dt['pd'] ||!$dt['px'] ||!$dt['pt'] ){
            err_set(1);return $r;
        }
        $err = ssh2_server_info($dt['ip'], $dt['un'], $dt['pd'], 
            $dt['px'], $dt['pt']);
        if ( $err != 0 ) { 
            err_set($err);
            switch($err) {
                case 1:
                    $r[SERVER_INPUT_PORT]    = ssh2_errmsg($err);
                    break;
                case 2:
                    $r[SERVER_INPUT_USER_NAME] = ssh2_errmsg($err);
                    break;
                case 3:
                case 7:
                    $r[SERVER_INPUT_PREFIX] = ssh2_errmsg($err);
                    break;
            }
        } else
            $ff = ssh2_server_struct($dt['ip'], $dt['pt'], $dt['un'], 
                $dt['pd'], $dt['px']);
        $dt['sm']   = $ff['scheme']; 
        $dt['ip']   = $ff['host']; 
        $dt['pt']   = $ff['port']; 
        $dt['px']   = $ff['prefix']; 
    }
    return $r;
}
/**
 * 校验项目组数据
 */
function _val_pg_dt($dt) {
    return val_gname($dt);
}
/**
 * 校验创建项目数据
 */
function _val_p_dt($dt) {
    $r = val_pname($dt);
    if ( !$dt['gid'] ) {
        err_set(WARING_CODE);
        $r[PROJECT_INPUT_GROUP_ID]   = PROJECT_MESS_GROUP_ID_EMPTY;
    }
    if ( !$dt['sn'] ) {
        err_set(WARING_CODE);
        $r[PROJECT_INPUT_SERVER_SVN] = PROJECT_MESS_SERVER_SVN_EMPTY;
    }
    if ( !$dt['sf'] ) {
        err_set(WARING_CODE);
        $r[PROJECT_INPUT_SERVER_FILE]   = PROJECT_MESS_SERVER_FILE_EMPTY;
    }

    return $r;
}
/**
 * 校验引导第三步用户填写的数据
 */
function val_gp_dt($dt) {
    $r = val_pname($dt);
    $r = val_gname($dt, $r, $force = false);
    return $r;
}
/**
 * 验证项目数据
 */
function val_pname($dt, $r = array()) {
    if ( !_check_str_length($dt['pn']) ) {
        err_set(WARING_CODE);
        $r[PROJECT_INPUT_NAME] = PROJECT_MESS_PROJECT_NAME_ERR;
    } else if ( project_name_exists($dt['pn'], $dt['id']) ) {
        err_set(WARING_CODE);
        $r[PROJECT_INPUT_NAME] = PROJECT_MESS_PROJECT_NAME_EXISTS;
    }
    return $r;
}
/**
 * 验证项目组数据
 */
function val_gname($dt, $r = array(), $force = true) {
    if ( !_check_str_length($dt['gn']) ) {
        err_set(WARING_CODE);
        $r[PGROUP_INPUT_NAME] = PGROUP_MESS_GROUP_NAME_ERR;
    } else if ( $force && project_group_name_exists($dt['gn'], $dt['id']) ) {
        err_set(WARING_CODE);
        $r[PGROUP_INPUT_NAME]   = PGROUP_MESS_GROUP_NAME_EXISTS;
    }
    return $r;
}
/**
 * 校验用户数据
 */
function _val_u_dt(&$dt) {
    $r = array();
    if ( !_check_str_length($dt['un']) ) {
        err_set(WARING_CODE);
        $r[USER_INPUT_USERNAME]   = USER_MESS_USERNAME_ERR;
    } else if (str_forbidden($dt['un']) ) { 
        err_set(WARING_CODE);
        $r[USER_INPUT_USERNAME]   = USER_MESS_USERNAME_FBSTR;
    } else if ( user_exists($dt['un'], $dt['id']) ) {
        err_set(WARING_CODE);
        $r[USER_INPUT_USERNAME]   = USER_MESS_USERNAME_EXISTS;
    }
    if ( $dt['pd'] != $dt['rpd'] ) {
        err_set(WARING_CODE);
        $r[USER_INPUT_PASSWORD]   = USER_RE_PASSWORD_ERR;
    }
    if ( !_check_pd_length($dt['pd']) ) {
        err_set(WARING_CODE);
        $r[USER_INPUT_PASSWORD]   = USER_MESS_PASSWORD_ERR;
    }

    return $r;
}
/**
 * 获得用户权限
 */
function get_user_mod() {
    $user_mod = $_REQUEST[USER_INPUT_USER_MOD];

    $ret_mod  = USER_MOD_DEFAULT_NULL;
    if ( sync_array($user_mod) )
        foreach ( $user_mod as $key => $value)
            $ret_mod = $ret_mod + $value;
    return $ret_mod;
}
/**
 * server创建
 */
function server_create($dt, &$err) {
    if ( $dt['id'] > 0 )
        $rt = server_update($dt['id'], $dt['dc'], $dt['sm'], 
        $dt['ip'], $dt['pt'], $dt['px'], $dt['si'], $dt['ti'], 
        $dt['un'], $dt['pd'], $dt['st'], $dt['cl']);
    else 
        $rt = server_create_new($dt['dc'], $dt['sm'], $dt['ip'], 
        $dt['pt'], $dt['px'], $dt['si'], $dt['ti'], $dt['un'], 
        $dt['pd'], $dt['st'], $dt['cl']);
    parse_rt($rt);
    return get_last_id();
}
/**
 * server删除
 */
function server_del($id) {
    $rt = server_delete($id);
    parse_rt($rt);
    return $rt;
}
/**
 * 项目组列表
 */
function pgroup_list($page = FIRST_PAGE, $rows = DEFAULT_PER_PAGE, $get_all = false) {
    return project_group_list($page, $rows, $get_all);
}
/**
 * 获取某个项目组信息
 */
function pgroup_get($pgroup_id) {
    return project_group_get($pgroup_id);
}
/**
 * 项目组数目
 */
function pgroup_list_count() {
    return project_group_list_count();
}
/**
 * 项目组是否是在使用状态
 */
function group_use($gid) {
    $ret = false;
    $projects = project_list_by_group($gid);
    if ( sync_array($projects) ) $ret = true;
    return $ret;
}
/**
 * 先根据项目组名字判断是否存在，若存在返回id，若不存在则创建之
 */
function pgroup_get_create($dt) {
    if ( !$dt['gn'] ) return 0;
    $pginfo = project_group_get_by_name($dt['gn']);
    if ( sync_array($pginfo) )
        return $pginfo[DB_PGROUP_ID];
    else
        return pgroup_create($dt);
}
/**
 * 项目组创建
 */
function pgroup_create($dt) {
    if ( $dt['id'] > 0 )
        $rt = project_group_update($dt['id'], $dt['gn'], $dt['gd'], $dt['cl']);
    else
        $rt = project_group_create_new($dt['gn'], $dt['gd'], $dt['cl']);
    parse_rt($rt);
    return get_last_id();
}
/**
 * 项目组删除
 */
function pgroup_delete($id) {
    $rt = project_group_delete($id);
    parse_rt($rt);
    return $rt;
}
/**
 * 获取所有svn服务器
 */
function server_svn_lists() {
    $lists = $ret = array();
    $lists = server_get_svn_list();
    if ( sync_array($lists) )
        foreach ( $lists as $k => $v ) 
            $ret[$k] = sync_format_server_info($v);
    return $ret;
}
/**
 * 获取所有文件服务器
 */
function server_file_lists() {
    $lists = $ret = array();
    $lists = server_get_file_list();
    if ( sync_array($lists) )
        foreach ( $lists as $k => $v ) 
            $ret[$k] = sync_format_server_info($v);
    return $ret;
}
/**
 * 获取在使用中的项目组信息
 */
function get_pgroup_lists() {
    $r  = array();
    $gl = pgroup_list(NULL);
    if ( sync_array($gl) ) {
        foreach( $gl  as $k => $g ) {
            $r[$k]['id']    = $g['pg_id'];
            $r[$k]['name']  = $g['pg_name'];
        }
    }
    return $r;
}
/**
 * 项目创建
 */
function project_create($dt) {
    if ( $dt['id'] > 0 ) {
        $rt = project_update($dt['id'], $dt['pn'], 
        $dt['gid'], $dt['sn'], $dt['sf'], $dt['cl']);
    } else
        $rt = project_create_new($dt['pn'], $dt['gid'], 
        $dt['sn'], $dt['sf'], $dt['cl']);
    parse_rt($rt);
    return $rt;
}
/**
 * 项目列表
 */
function project_lists($page = FIRST_PAGE, $rows = DEFAULT_PER_PAGE) {
    $r = array();
    $r = project_get_list($page, $rows);
    _tidy_pls_servers($r);
    _tidy_plf_servers($r);
    _tidy_pgroup_info($r);

    return $r;
}
/**
 * 项目删除
 */
function project_del($id) {
    $rt = project_delete($id);
    parse_rt($rt);
    return $rt;
}
/**
 * 整理项目列表中的svn服务器
 */
function _tidy_pls_servers(&$pl) {
    if ( sync_array($pl) )
        foreach ( $pl as $k => &$p ) 
            $p[PROJECT_KEY_SERVER_SVN_LIST] = server_get($p[DB_PROJECTS_SVN]);
}
/**
 * 整理项目列表中的file服务器
 */
function _tidy_plf_servers(&$pl) {
    if ( !sync_array($pl) ) return ; 
    foreach ( $pl as $k => &$p ) {
        $fl = server_gets($p[DB_PROJECTS_SERVERS]);
        if ( sync_array($fl) ) {
            $p[PROJECT_KEY_SERVER_COUNT]      = count($fl);
            $p[PROJECT_KEY_SERVER_FILE_LIST]  = $fl;
        }
    }
}
/**
 * 整理项目列表中的项目组信息
 */
function _tidy_pgroup_info(&$pl) {
    if ( sync_array($pl) )
        foreach ( $pl as $k => &$p )
            $p[PROJECT_KEY_GROUP_INFO] = project_group_get($p[DB_PROJECTS_PGID]);
}
/**
 * 根据用户id获取用户信息
 */
function sync_user_get($id) {
    $u = array();
    $u = user_get($id);
    if ( sync_array($u) ) 
        tidy_user_mod($u);

    return $u;
}
/**
 * 用户创建
 */
function user_create($dt) {
    if ( $dt['id'] > 0 )
        $rt = user_update($dt['id'], $dt['un'], $dt['pd'], $dt['ud'], $dt['cl']);
    else
        $rt = create_new_sync_user($dt['un'], $dt['ud'], $dt['pd'], $dt['cl']);
    parse_rt($rt);
    return $rt;
}
/**
 * 用户列表
 */
function user_lists($page = FIRST_PAGE, $per_page = LIST_PER_PAGE) {
    return user_get_list($page, $per_page);
}
/**
 * 用户删除
 */
function user_del($id) {
    $rt = user_delete($id);
    parse_rt($rt);
    return $rt;
}
/**
 * 解析db的返回
 */
function parse_rt($rt) {
    if ( !$rt ) {
        err_set(FAIL_CODE);
        msg_set(OP_MESS_FAIL);
     } else msg_set(OP_MESS_SUCC);
}
/**
 * 管理员是否满足进入引导流程 
 */
function sync_need_guide() {
    $r = project_get_list(1, 1);
    if ( sync_array($r) ) return false;
    else return true;
}
/**
 * 获取一条tips
 */
function get_one_tips() {
    $tips = get_random_tips();
    if ( sync_array($tips) )
        return $tips['t_content'];
}
/**
 * 检测字符串长度
 */
function _check_str_length($str = '', $min = DESC_MIN_LENGTH, $max = DESC_MAX_LENGTH) {
        preg_match_all(STANDERD_LETTERS, $str, $t_str);
        if ( (count($t_str[0]) < $min) || (count($t_str[0]) > $max) )
            return false;
        return true;
}
/**
 * 检查密码长度
 */
function _check_pd_length($passwd) {
    return _check_str_length($passwd, USER_PASSWD_MIN_LENGHT, USER_PASSWD_MAX_LENGHT);
}
/**
 * 校验给定字符串内是否含有非法字符
 */
function str_forbidden($str) {
    $has = false;
    $fb_chars = array ("\\", "&", " ", "'", "\"", "/", "*", ",", "<", ">", "\r", "\t", "\n", "#", "$", "(", ")", "%", "@", "+", "?", ";", "^", "{", "}", "[", "]", "=", "`", "·", "￥", "！", "“", "）", "（", "‘", "，", "。");
    foreach ( $fb_chars as $k => $v )
        if ( strpos($str, $v) )
            $has = true;
    return $has;
}
/**
 * 获取服务器列表 
 */
function console_server_lists($page = FIRST_PAGE, $row = DEFAULT_PER_PAGE) {
    $lists = $ret = array();
    $order = DB_SERVERS_DEL . " asc," . DB_SERVERS_ID . " desc";
    $lists = server_lists($page, $row, $order);
    if ( sync_array($lists) )
        foreach ( $lists as $k => $v ) 
            $ret[] = sync_format_server_info($v);
    return $ret;
}
/**
 * 判断一个文件是否需要解析 
 */
function need_syntax($item) {
    return is_php_file(ticket_fl_uri($item)) && defined('SYNC_CHECK_PHP') && SYNC_CHECK_PHP;
}
/**
 * 检查一个svn地址的文件是否有语法错误
 */
function sync_php_syntax($item) {
	if(!need_syntax($item)) return false;
    $result = sync_cp_files_to_path($item);
    if(!$result && err_get() === 2) return true;
    return false;
}
/**
 * 检查文件列表的php文件是否有语法错误
 */
function sync_php_syntax_flist($flist) {
    $r = array();
    if(!sync_array($flist)) return $r;
    foreach($flist as $v)
        if(sync_php_syntax($v)){
            $r[] = $v;
            err_set(0);
        }
    return $r;
}
/**
 * 获得同步成功的文件的信息
 * 那个文件同步到那台服务器上了
 */
function sync_file_list($slist) {
    if(!sync_array($slist)) return array();
    $r = array();
    foreach($slist as $k => $v){
        if(!sync_array($v['suc'])) continue;
        foreach($v['suc'] as $ik => $iv){
            $url = ticket_fl_u($iv['item']);    
            $hsh = md5($url);
            $r[$hsh] = array(
                        OP_LIST_KEY_ACTION => $iv['item'][OP_LIST_KEY_ACTION],
                        OP_LIST_KEY_V      => $iv['item'][OP_LIST_KEY_V],
                        OP_LIST_KEY_RV     => $iv['item'][OP_LIST_KEY_RV],
                        OP_LIST_KEY_T      => $iv['item'][OP_LIST_KEY_T],
                    );
        }
    }
    return $r;
}
# ==============================================文件部署===================================== #
function sync_list_appends($l) {
    if(!sync_array($l)) return array();
    foreach($l as $k => $v)
        sync_list_append($k, $v);
}
function sync_list_append($hash, $data) {
    $i = list_get($hash);
    if(!sync_array($i)){
        list_create($hash, array($data));
        return $data;
    }
    sync_list_merge($i, $data);
    list_update($hash, $i);
    return $i;
}
/**
 * 合并一个文件的同步的历史记录
 */
function sync_list_merge(&$a, $b) {
    if(!sync_array($b)) return;
    $a = sync_list_smerge($a, $b);
}
/**
 * 合并单个服务器的历史记录
 */
function sync_list_smerge($a, $b) {
    if(sync_array($a)) {
        $l = array_pop($a);
        $a[] = $l;
        #如果两次操作版本不一致
        if($l != $b) $a[] = $b;
        return $a;
    }
    return $b;
}
function sync_rollbackalbe($fl) {
	if(!sync_array($fl)) return false;
	foreach($fl as $item){
		if(sync_list_lv($item) === null) return false;
	}
	return true;
}
/**
 * 获得一个文件最后同步的版本
 * item 一个文件对象
 */
function sync_list_lv($item) {
    $url = ticket_fl_u($item);
    $hsh = md5($url);
    $i = list_get($hsh);
    if(!sync_array($i) || count($i) < 2) return null;
    array_pop($i);
    $l = array_pop($i);
    return $l;
}
/**
 * 修改文件对象的回滚属性 
 */
function sync_item_lv(&$item, &$t) {
    $l = sync_list_lv($item);
    if(!sync_array($l)) return;
    $item[OP_LIST_KEY_V]        = $l[OP_LIST_KEY_RV];
    $item[OP_LIST_KEY_T]        = $l[OP_LIST_KEY_T];
    $item[OP_LIST_KEY_RV]       = $l[OP_LIST_KEY_RV];
    $item[OP_LIST_KEY_ACTION]   = $l[OP_LIST_KEY_ACTION];
    $t = $l[OP_LIST_KEY_T] ? true : false;
    return true;
}
/**
 * 加密函数
 */
function sync_encrypt($str) {
	return base64_encode(encrypt($str));
}
function sync_decrypt($str) {
	return decrypt(base64_decode($str));
}
/**
 * 使用过的最大的ID
 */
function sync_max_id() {
	return ticket_max_id();
}
