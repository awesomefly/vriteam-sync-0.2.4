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
 * 新建用户和修改密码
 */
function create_new_sync_user($username, $mod, $default_password = USER_DEFAULT_PASSWORD, $s_del) {
    $sql = "insert into " . SYNC_USERS_TABLE ." set " . DB_USERS_USERNAME ." = '".
        $username."', " . DB_USERS_PASSWORD ." = '" .
        md5($default_password) . "', " . DB_USERS_CREATETIME .
        " = unix_timestamp(), " . DB_USERS_MOD . " = " . $mod . "," . DB_USERS_DEL . "=" . $s_del;
    return insert_update_db_by_sql($sql);
}
/**
 * 修改用户信息
 */
function user_update($id, $username, $password, $user_mod, $s_del = NULL) {
    $ret         = array();
    $update      = true; //是否有更新的标示

    if(!$username && !$password)
        return $ret;
    $user_info = user_get($id);
    if( !sync_array($user_info) )
        return array();
    $sql = sprintf("update %s set ", SYNC_USERS_TABLE);
    if ( $username && $username != $user_info[DB_USERS_USERNAME] )
        $sql .= sprintf("%s = '%s', ", DB_USERS_USERNAME, $username);
    if ( $password && md5($password) != $user_info[DB_USERS_PASSWORD] )
        $sql .= sprintf("%s = '%s', ", DB_USERS_PASSWORD, md5($password));
    if ( $user_mod != $user_info[DB_USERS_MOD] )
        $sql .= sprintf("%s = %d, ", DB_USERS_MOD, $user_mod);
    if ( isset($s_del) && (int)$s_del != $user_info[DB_USERS_DEL] )
        $sql .= sprintf("%s = %d, ", DB_USERS_DEL, $s_del);
    if ( substr($sql, -4) == 'set ')
        $update = false;
    if ( $update ) {
        $sql  = substr($sql, 0, -2);
        $sql .= sprintf(" where %s = %d", DB_USERS_ID, $id); 
        return insert_update_db_by_sql($sql);
    } else 
        return true;
}
/**
 * 根据用户名获得用户信息
 */
function user_info($un = null) {
    return user_info_raw($un, true);
}
/**
 * 根据用户名获得用户信息
 */
function user_info_raw($un = null, $del = false) {
    if($un === null) $un = current_username();
    $sql = sprintf("select * from %s where %s = '%s'", SYNC_USERS_TABLE, DB_USERS_USERNAME, $un);
    if($del) $sql = sprintf("%s and %s = %d", $sql, DB_USERS_DEL, USER_DEL_NOT);
    return get_row_from_db_by_sql($sql);
}
/**
 * 获得用户权限
 */
function user_mod($un) {
    $ui = user_info($un);
    return sync_array($ui) ? intval($ui[DB_USERS_MOD]) : USER_MOD_DEFAULT_NULL;
}
/**
 * 全部用户列表
 */
function user_get_list($page = FIRST_PAGE, $per_page = LIST_PER_PAGE) {
    $sql = sprintf("select * from %s order by %s asc,%s desc", SYNC_USERS_TABLE, 
        DB_USERS_DEL, DB_USERS_ID) . get_limit_str($page, $per_page);
    return get_row_from_db_by_sql($sql, true);
}
/**
 * 用户总数
 */
function user_list_count() {
    $sql    = sprintf("select count(%s) as num from %s", DB_USERS_ID, SYNC_USERS_TABLE);
    $count  = get_row_from_db_by_sql($sql);
    if ( sync_array($count) )
        return $count['num'];
    return 0;
}
/**
 * 根据用户id获取用户信息
 */
function user_get($user_id) {
    $user_info = array();
    if ( (int)$user_id <= 0 ) return $usr_info;
    $sql = sprintf("select * from %s where %s = %d", SYNC_USERS_TABLE, DB_USERS_ID, $user_id);
    return get_row_from_db_by_sql($sql);
}
/**
 * 删除用户
 */
function user_delete($user_id) {
    if ( (int)$user_id <= 0 ) return false;
    $sql = sprintf("update %s set %s = %d where %s = %d", SYNC_USERS_TABLE, DB_USERS_DEL, USER_DEL_YES, DB_USERS_ID, $user_id);
    return insert_update_db_by_sql($sql);
}
/**
 * 判断用户名是否已经存在
 */
function user_exists($username, $id = NULL) {
    $user = user_info($username);
    if ( sync_array($user) && $user[DB_USERS_ID] > 0 && $user[DB_USERS_ID] != $id) return true;
    return false;
}
