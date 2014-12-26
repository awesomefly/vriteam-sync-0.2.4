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
 * 新建一个项目
 */
function project_create_new($name, $group_id, $svn_server_id, $server_ids, $status) {
    if ( sync_array($server_ids ) ) 
        $server_ids = implode(",", $server_ids);
    $sql = sprintf("insert into %s (%s, %s, %s, %s, %s) values ('%s', %d, %d, '%s', %d)", 
        SYNC_PROJECTS_TABLE, DB_PROJECTS_NAME, DB_PROJECTS_PGID, DB_PROJECTS_SVN, DB_PROJECTS_SERVERS, 
        DB_PROJECTS_STATUS, $name, $group_id, $svn_server_id, $server_ids, $status);
    return insert_update_db_by_sql($sql);
}
/**
 * 删除一个项目
 */
function project_delete($p_id) {
    $sql = sprintf("update %s set %s = %d where %s = %d", 
        SYNC_PROJECTS_TABLE, DB_PROJECTS_STATUS, PROJECT_STATUS_STOP, DB_PROJECTS_ID, $p_id);
    return insert_update_db_by_sql($sql);
}
/**
 * 根据id获得一个项目信息
 */
function project_get($p_id) {
    static $cache = array();
    if( isset($cache[$p_id]) && $cache[$p_id])
        return $cache[$p_id];
    else {
        $sql = sprintf("select * from %s where %s = %d ", SYNC_PROJECTS_TABLE, DB_PROJECTS_ID, $p_id);
        $row = get_row_from_db_by_sql($sql);
        if( sync_array($row) ) {
            $cache[$p_id] = $row;
            return $row;
        }
    }
    return array();
}
/**
 * 根据名字获取项目信息
 */
function project_get_by_name($p_name) {
    static $cache = array();
    if( isset($cache[$p_name]) && $cache[$p_name]) 
        return $cache[$p_name];
    else {
        $sql = sprintf("select * from %s where %s = '%s' ", SYNC_PROJECTS_TABLE, DB_PROJECTS_NAME, $p_name);
        $row = get_row_from_db_by_sql($sql);
        if( sync_array($row) ){
            $cache[$p_name] = $row;
            return $row;
        }
    }
    return array();
}
/**
 * 修改一个项目
 */
function project_update($p_id, $name, $group_id, $svn_server_id, $server_ids, $status = NULL) {
    $ret         = array();
    $update      = true; //是否有更新的标示

    if ( sync_array($server_ids ) ) 
        $server_ids = implode(",", $server_ids);
    if(!$name && !$svn_server_id && !$server_ids && !$group_id && !isset($status))
        return $ret;
    #先获得项目信息
    $project_info = project_get($p_id);
    if( !sync_array($project_info) )
        return $ret;

    $sql = sprintf("update %s set ", SYNC_PROJECTS_TABLE);
    if ( $name && $name != $project_info[DB_PROJECTS_NAME] )
        $sql .= sprintf("%s = '%s', ", DB_PROJECTS_NAME, $name);
    if ( $group_id && $group_id != $project_info[DB_PROJECTS_PGID] )
        $sql .= sprintf("%s = %d, ", DB_PROJECTS_PGID, $group_id);
    if ( $svn_server_id && $svn_server_id != $project_info[DB_PROJECTS_SVN] )
        $sql .= sprintf("%s = '%s', ", DB_PROJECTS_SVN, $svn_server_id);
    if ( $server_ids && $server_ids != $project_info[DB_PROJECTS_SERVERS] )
        $sql .= sprintf("%s = '%s', ", DB_PROJECTS_SERVERS, $server_ids);
    if ( isset($status) && $status != $project_info[DB_PROJECTS_STATUS] )
        $sql .= sprintf("%s = %d, ", DB_PROJECTS_STATUS, $status);
    if ( substr($sql, -4) == 'set ' )
        $update = false;
    if ( $update ) {
        $sql  = substr($sql, 0, -2);
        $sql .= sprintf(" where %s = %d", DB_PROJECTS_ID, $p_id); 
        return insert_update_db_by_sql($sql);
    } else 
        return true;
}
/**
 * 获得项目的svn服务器id
 */
function project_get_svn_id_by_name($p_name) {
    $i = project_get_by_name($p_name);
    return is_array($i) && isset($i[DB_PROJECTS_SVN]) ? intval($i[DB_PROJECTS_SVN]) : 0;
}
/**
 * 获得文件服务器的ids
 */
function project_get_server_ids_by_name($pn) {
    $i = project_get_by_name($pn);
    return is_array($i) && isset($i[DB_PROJECTS_SERVERS]) ? $i[DB_PROJECTS_SERVERS] : '';
}
/**
 * 项目列表
 */
function project_get_list($page = FIRST_PAGE, $per_page = LIST_PER_PAGE) {
    $sql = sprintf("select * from %s order by %s asc,%s desc", SYNC_PROJECTS_TABLE, 
        DB_PROJECTS_STATUS, DB_PROJECTS_ID) . get_limit_str($page, $per_page);
    return get_row_from_db_by_sql($sql, true);
}
/**
 * 获取项目总数
 */
function project_list_count() {
    $sql = sprintf("select count(%s) as num from %s", DB_PROJECTS_ID, SYNC_PROJECTS_TABLE);
    $count  = get_row_from_db_by_sql($sql);
    if ( sync_array($count) )
        return $count['num'];
    else
        return 0;
}
/**
 * 根据项目组id获得属于该项目组的项目名称
 */
function project_get_group_list($pg_id) {
    $sql = sprintf("select distinct %s from %s where %s = %d and %s = %d 
        order by %s asc", DB_PROJECTS_NAME, SYNC_PROJECTS_TABLE, DB_PROJECTS_PGID, 
        $pg_id, DB_PROJECTS_STATUS, PROJECT_STATUS_USE, DB_PROJECTS_NAME);
    return get_row_from_db_by_sql($sql, true);
}
/**
 * 整理项目表中的p_servers字段，由字符串整理成数组
 */
function project_tidy_p_servers_array($p_servers) {
    if ( $p_servers ) 
        return explode(",", $p_servers);
    else 
        return array();
}
/**
 * 获得项目的服务器
 */
function project_get_servers($pname) {
    if($ss = project_get_server_ids_by_name($pname)){
        return project_tidy_p_servers_array($ss);
    }
    return array();
}
/**
 * 项目名称是否已经存在
 */
function project_name_exists($project_name, $id = NULL) {
    $project = project_get_by_name($project_name);
    if ( sync_array($project) && $project[DB_PROJECTS_ID] > 0 && $project[DB_PROJECTS_ID] != $id ) 
        return true;
    else 
        return false;
}
/**
 * 通过服务器id和类型获取与其关联的项目
 */
function project_list_by_server($sid, $stype = PROJECT_TYPE_SVN) {
    $list = array();
    if ( (int)$sid <= 0 ) return $list; 
    if ( $stype == PROJECT_TYPE_SVN ) {
        $sql = sprintf("select * from %s where %s = %d and %s = %d", SYNC_PROJECTS_TABLE, 
            DB_PROJECTS_SVN, $sid, DB_PROJECTS_STATUS, PROJECT_STATUS_USE);
        $list = get_row_from_db_by_sql($sql, true);
    } else {
        $sql = sprintf("select * from %s where %s = %d", SYNC_PROJECTS_TABLE, 
            DB_PROJECTS_STATUS, PROJECT_STATUS_USE);
        $servers = get_row_from_db_by_sql($sql, true);
        if ( !sync_array($servers) ) return $list;
        foreach($servers as $key => $se) {
            $se_arr = explode(",", $se[DB_PROJECTS_SERVERS]);
            if ( in_array($sid, $se_arr) )
                $list[] = $se;
        }
    }
    return $list;
}
/**
 * 通过项目组获取
 */
function project_list_by_group($gid) {
    $list = array();
    if ( (int)$gid <= 0 ) return $list;
    $sql = sprintf("select * from %s where %s = %d and %s = %d", SYNC_PROJECTS_TABLE, 
        DB_PROJECTS_PGID, $gid, DB_PROJECTS_STATUS, PROJECT_STATUS_USE); 
    $list = get_row_from_db_by_sql($sql, true);
    return $list;
}
