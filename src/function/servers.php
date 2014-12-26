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
 * 新建一个服务器信息
 */
function server_create_new($desc, $scheme, $ip, $port, $prefix, $s_uri,
        $trunk_uri, $username, $password, $type, $is_del) {

    $sql = sprintf("insert into %s (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s) values ('%s', '%s', '%s', 
        %d, '%s', '%s', '%s', '%s', '%s', %d, %d)", SYNC_SERVERS_TABLE, DB_SERVERS_DESC, DB_SERVERS_SCHEME,
        DB_SERVERS_IP, DB_SERVERS_PORT, DB_SERVERS_PREFIX, DB_SERVERS_SURI, DB_SERVERS_TURI, DB_SERVERS_USERNAME,
        DB_SERVERS_PASSWORD, DB_SERVERS_TYPE, DB_SERVERS_DEL, $desc, $scheme, $ip, intval($port), $prefix, $s_uri, 
        $trunk_uri, $username, mysql_real_escape_string(sync_encrypt($password)), $type, $is_del);

    return insert_update_db_by_sql($sql, true);
}
/**
 * 删除一个服务器信息
 */
function server_delete($s_id) {
    $sql = sprintf("update %s set %s = %d where %s = %d", 
        SYNC_SERVERS_TABLE, DB_SERVERS_DEL, SERVER_CLOSE_TRUE, DB_SERVERS_ID, $s_id);
    return insert_update_db_by_sql($sql);
}
/**
 * 获取所有服务器列表
 */
function server_lists($page = FIRST_PAGE, $perpage = DEFAULT_PER_PAGE, $order = 's_id DESC') {
    static $cache   =  array();
    $lists          = array();
    $cache_key  = SERVER_CACHE_LIST . "_" . $page . "_" . $perpage;
    if ( isset($cache[$cache_key]) && $cache[$cache_key] )
        return $cache[$cache_key];
    $limit_str = get_limit_str($page, $perpage);
    $sql = "SELECT * FROM " . SYNC_SERVERS_TABLE . " ORDER BY " .
        $order . $limit_str;
    $lists = get_row_from_db_by_sql($sql ,true);

    if ( sync_array($lists) ) 
        $cache[$cache_key] = $lists;
    return $lists;
}
/**
 * 获得一个服务器信息
 */
function server_get($s_id) {
    static $cache = array();
    if(isset($cache[$s_id]) && $cache[$s_id])
        return $cache[$s_id];
    $sql = sprintf("select * from %s where %s = %d", SYNC_SERVERS_TABLE, DB_SERVERS_ID, $s_id);
    $row = get_row_from_db_by_sql($sql);
    if( sync_array($row) ){
		$row[DB_SERVERS_PASSWORD] = sync_decrypt($row[DB_SERVERS_PASSWORD]);
        $cache[$s_id] = $row;
        return $row;
    }
    return array();
}
/**
 * 获取服务器总数
 */
function server_list_count() {
    $sql = sprintf("select count(%s) as num from %s", DB_SERVERS_ID, SYNC_SERVERS_TABLE);
    $count  = get_row_from_db_by_sql($sql);
    if ( sync_array($count) )
        return $count['num'];
    else
        return 0;
}
/**
 * 获得一批服务器信息
 */
function server_gets($s_ids) {
    static $cache = array();
    if ( sync_array($s_ids) )
        $s_ids = implode(",", $s_ids);
    if( isset($cache[$s_ids]) && $cache[$s_ids])
        return $cache[$s_ids];
    $sql = sprintf("select * from %s where %s in (%s) ", SYNC_SERVERS_TABLE, DB_SERVERS_ID, $s_ids);
    $ret = get_row_from_db_by_sql($sql, true);
    if( sync_array($ret) ){
		foreach($ret as $k => &$v){
			$v[DB_SERVERS_PASSWORD] = sync_decrypt($v[DB_SERVERS_PASSWORD]);
			$cache[$v[DB_SERVERS_ID]] = $v;
		}
        return $ret;
    }
    return array();
}
/**
 * 修改一个服务器信息
 */
function server_update($s_id, $desc = null, $scheme = null, $ip = null, $port = null,
    $prefix = null, $s_uri = null, $trunk_uri = null, $username = null, $password = null, 
    $type = null, $is_del = SERVER_CLOSE_FALSE) {

    $update      = true; //是否有更新的标示
    #先获得服务器信息
    $server_info = server_get($s_id);
    if( !sync_array($server_info) )
        return false;
    $sql = sprintf("update %s set ", SYNC_SERVERS_TABLE);
    if ( isset($desc) && $desc != $server_info[DB_SERVERS_DESC] )
        $sql .= sprintf("%s = '%s', ", DB_SERVERS_DESC, $desc);
    if ( isset($scheme) && $scheme != $server_info[DB_SERVERS_SCHEME] )
        $sql .= sprintf("%s = '%s' ,", DB_SERVERS_SCHEME, $scheme);
    if ( isset($ip) && $ip != $server_info[DB_SERVERS_IP] )
        $sql .= sprintf("%s = '%s', ", DB_SERVERS_IP, $ip);
    if ( isset($port) && $port != $server_info[DB_SERVERS_PORT] )
        $sql .= sprintf("%s = %d, ", DB_SERVERS_PORT, (int)$port);
    if ( isset($prefix) && $prefix != $server_info[DB_SERVERS_PREFIX] )
        $sql .= sprintf("%s = '%s', ", DB_SERVERS_PREFIX, $prefix);
    if ( isset($s_uri) && $s_uri != $server_info[DB_SERVERS_SURI] )
        $sql .= sprintf("%s = '%s', ", DB_SERVERS_SURI, $s_uri);
    if ( isset($trunk_uri) && $trunk_uri != $server_info[DB_SERVERS_TURI] )
        $sql .= sprintf("%s = '%s', ", DB_SERVERS_TURI, $trunk_uri);
    if ( isset($username) && $username != $server_info[DB_SERVERS_USERNAME] )
        $sql .= sprintf("%s = '%s', ", DB_SERVERS_USERNAME, $username);
    if ( isset($password) && $password != $server_info[DB_SERVERS_PASSWORD] )
        $sql .= sprintf("%s = '%s', ", DB_SERVERS_PASSWORD, mysql_real_escape_string(sync_encrypt($password)));
    if ( isset($type) && $type != $server_info[DB_SERVERS_TYPE] )
        $sql .= sprintf("%s = %d, ", DB_SERVERS_TYPE, (int)$type);
    if ( isset($is_del) && (int)$is_del != $server_info[DB_SERVERS_DEL] )
        $sql .= sprintf("%s = %d, ", DB_SERVERS_DEL, (int)$is_del);
    if ( substr($sql, -4) == 'set ' )
        $update = false;
    if ( $update ) {
        $sql  = substr($sql, 0, -2);
        $sql .= sprintf(" where %s = %d", DB_SERVERS_ID, $s_id); 
        return insert_update_db_by_sql($sql);
    }
    return true;
}
/**
 * 获取所有的svn服务器
 */
function server_get_svn_list() {
    return server_get_by_type(SERVER_TYPE_SVN);
}
/**
 *  获取所有的文件服务器
 */
function server_get_file_list() {
    return server_get_by_type(SERVER_TYPE_FILE);
}
/**
 * 根据类型获取服务器列表
 */
function server_get_by_type($type = NULL) {
    static $cache   =  array();
    $lists          = array();
    $cache_key  = SERVER_CACHE_LIST . "_" . $type;
    if ( isset($cache[$cache_key]) && $cache[$cache_key] )
        return $cache[$cache_key];

    $sql = sprintf("select * from %s where %s = %d and %s = %d", SYNC_SERVERS_TABLE, 
        DB_SERVERS_DEL, SERVER_CLOSE_FALSE, DB_SERVERS_TYPE, $type);
    $lists = get_row_from_db_by_sql($sql ,true);

    if ( sync_array($lists) ) {
		foreach($lists as $k => &$v){
			$v[DB_SERVERS_PASSWORD] = sync_decrypt($v[DB_SERVERS_PASSWORD]);
			$cache[$v[DB_SERVERS_ID]] = $v;
		}
        $cache[$cache_key] = $lists;
	}
    return $lists;
}
/**
 * 获得svn服务器的上线分支地址
 */
function server_get_svn_uri($s_id) {
    $si = server_get($s_id);
    return $si[DB_SERVERS_SURI];
}
/**
 * 获得svn服务器的trunk地址
 */
function server_trunk_uri($s_id) {
    $si = server_get($s_id);
    return $si[DB_SERVERS_TURI];
}
/**
 * 获得svn服务器的trunk地址
 */
function server_prefix($s_id) {
    $si = server_get($s_id);
    return $si[DB_SERVERS_PREFIX];
}
/**
 * 获得svn服务器的trunk地址
 */
function server_ip($s_id) {
    $si = server_get($s_id);
    return $si[DB_SERVERS_IP];
}
/**
 * 获得svn服务器的描述
 */
function server_desc($s_id) {
    $si = server_get($s_id);
    return $si[DB_SERVERS_DESC];
}
/**
 * 获得文件服务器的绝对路径
 */
function server_abs_path($uri, $s_id) {
    return sync_trim_path(server_prefix($s_id)  . FS_DELIMITER . $uri);
}
/**
 * 判断一个server的类型
 */
function server_svn($s_type, $s_id = null) {
    if ( $s_id ) {
        $si = server_get($s_id);
        $s_type = intval($si[DB_SERVERS_TYPE]);
    }
    return $s_type == SERVER_TYPE_SVN ? true : false;
}
/**
 * 判断一个server的类型
 */
function server_file($s_type, $s_id = null) {
    if ( $s_id ) {
        $si = server_get($s_id);
        $s_type = intval($si[DB_SERVERS_TYPE]);
    }
    return $s_type == SERVER_TYPE_FILE ? true : false;
}
/**
 * 判断同描述服务器是否已经存在
 */
function server_desc_exist($desc, $id = NULL) {
    $si = server_get_by_desc($desc);
    if ( sync_array($si) && $si[DB_SERVERS_ID] > 0  && $si[DB_SERVERS_ID] != $id) 
        return true;
    else return false;
}
/**
 * 根据描述获取服务器信息
 */
function server_get_by_desc($desc) {
    $server = array();
    if ( !$desc )  return $server;
    $sql = sprintf("select * from %s where %s = '%s'", SYNC_SERVERS_TABLE, DB_SERVERS_DESC, $desc);
    $row = get_row_from_db_by_sql($sql);
	$row[DB_SERVERS_PASSWORD] = sync_decrypt($row[DB_SERVERS_PASSWORD]);
	return $row;
}
