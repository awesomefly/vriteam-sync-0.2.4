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
 * 记录同步历史
CREATE TABLE `sync_history` (
        `h_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '上线历史单自增id',
        `h_t_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上线单id',
        `h_s_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '服务器id',
        `h_svn_from` varchar(20) NOT NULL DEFAULT '' COMMENT '从那个分支取的文件',
        `h_userid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '同步的用户id',
        `h_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '同步的时间',
        PRIMARY KEY (`h_id`),
        UNIQUE KEY `u_id` (`h_t_id`, `h_s_id`, `h_version`, `h_svn_from`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

 */
function history_create($t_id, $s_id, $svn, $un, $sum, $time, $type) {
    $conn = get_mysql_connection();
    if(!$conn){
        sync_log(SYNC_E_CONNECT);
        return false;
    }
    $sql = sprintf("insert into %s (h_t_id, h_s_id, h_svn_from, h_username, h_time, h_sum, h_type)
            values(%d, %d, '%s', '%s', %d, '%s', %d)",
            SYNC_HISTORY_TABLE, $t_id, $s_id, $svn, $un, $time, $sum, $type);
    $result = mysql_query($sql, $conn);
    if(!$result){
        sync_log("创建服务器失败" . $sql);
        return false;
    }
    $id = mysql_insert_id($conn);
    return $id;
}
function history_create_sync($t_id, $s_id, $svn, $un, $sum, $time) {
    return history_create($t_id, $s_id, $svn, $un, $sum, $time, 2);
}
function history_create_rollback($t_id, $s_id, $svn, $un, $sum, $time) {
    return history_create($t_id, $s_id, $svn, $un, $sum, $time, 3);
}
function history_create_flist($t_id, $s_id, $svn, $un, $sum, $time) {
    return history_create($t_id, $s_id, $svn, $un, $sum, $time, 1);
}
/**
 * 获得最新同步某台服务器的最新列表
 */
function history_info($h_id) {
    $conn = get_mysql_connection();
    if(!$conn){
        sync_log(SYNC_E_CONNECT);
        return false;
    }
    $sql = sprintf("select * from %s where h_id = %d",
            SYNC_HISTORY_TABLE, $h_id);
    $r = get_row_from_db_by_sql($sql);
    if(sync_array($r))
        return $r;
    return array();    
}
/**
 * 获得最新同步某台服务器的最新列表
 */
function history_get($t_id, $s_id) {
    $conn = get_mysql_connection();
    if(!$conn){
        sync_log(SYNC_E_CONNECT);
        return false;
    }
    $sql = sprintf("select * from %s where h_t_id = %d and h_s_id = %d and h_type = 0 order by h_time desc limit 1",
            SYNC_HISTORY_TABLE, $t_id, $s_id);
    $r = get_row_from_db_by_sql($sql);
    if(sync_array($r))
        return $r;
    return array();
}
function history_get_byid($h_id) {
    $conn = get_mysql_connection();
    if(!$conn){
        sync_log(SYNC_E_CONNECT);
        return false;
    }
    $sql = sprintf("select * from %s where h_id = %d", SYNC_HISTORY_TABLE, $h_id);
    $r = get_row_from_db_by_sql($sql);
    if(sync_array($r))
        return $r;
    return array();
}
/**
 * 获得最新同步某台服务器的最新列表
 */
function history_gets($t_id, $s_id) {
    $conn = get_mysql_connection();
    if(!$conn){
        sync_log(SYNC_E_CONNECT);
        return false;
    }
    $sql = sprintf("select * from %s where h_t_id = %d and h_s_id = %d and h_type = 0 order by h_time desc",
            $t_id, $s_id);
    $r = get_row_from_db_by_sql($sql, true);
    if(sync_array($r))
        return $r;
    return array();
}
/**
 *
 */
function history_server_id($h_info, $h_id = null) {
    if($h_id)
        $h_info = history_get_byid($h_id);
    return $h_info['h_s_id']; 
}
/**
 * 获得所有同步的时间点
 */
function history_get_stime($t_id) {
    $conn = get_mysql_connection();
    if(!$conn){
        sync_log(SYNC_E_CONNECT);
        return false;
    }
    $sql = sprintf("select distinct h_time from %s where h_t_id = %d and h_type = 0 order by h_time desc",
            SYNC_HISTORY_TABLE, $t_id);
    $r = get_row_from_db_by_sql($sql, true);
    if(sync_array($r)){
        foreach($r as $v)
            $ret[] = $v['h_time'];
        return $ret;
    }
    return array();
    
}
/**
 * 更新sum字段
 * 用于同步结果更新
 */
function history_update($hid, $sum, $h_type = 2) {
    $sum = serialize($sum);
    $conn = get_mysql_connection();
    if(!$conn) return false;
    $sql = sprintf("update %s set h_sum = '%s', h_type = %d where h_id = %d", 
            SYNC_HISTORY_TABLE, $sum, $h_type, $hid);
    $r = insert_update_db_by_sql($sql);
    return $r;
}
function history_type($hid) {
    $hi = history_info($hid);
    return $hi['h_type'];
}
