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
 * 新建一个项目组
 */
function project_group_create_new($group_name, $group_desc, $pg_del) {
    $now = time();
    $sql = sprintf("insert into %s (%s, %s, %s, %s) values ('%s', '%s', %d, %d)", 
        SYNC_PROJECT_GROUP_TABLE, DB_PGROUP_NAME, DB_PGROUP_DESC, DB_PGROUP_DEL, 
        DB_PGROUP_CTIME, $group_name, $group_desc, $pg_del, $now);
    return insert_update_db_by_sql($sql);
}
/**
 * 项目组列表
 */
function project_group_list($page = FIRST_PAGE, $per_page = LIST_PER_PAGE, $get_all = false) {
    $sql    = sprintf("select * from %s", SYNC_PROJECT_GROUP_TABLE);
    if ( !$get_all ) 
        $sql .= " where " . DB_PGROUP_DEL . " = " . PGROUP_DEL_NOT;
    $sql .= " order by " . DB_PGROUP_DEL . " asc," . DB_PGROUP_ID . " desc";
    $sql .=  get_limit_str($page, $per_page);

    return get_row_from_db_by_sql($sql, true);
}
/**
 * 项目总数
 */
function project_group_list_count($get_all = false) {
    $sql    = sprintf("select count(%s) as num from %s", 
        DB_PGROUP_ID, SYNC_PROJECT_GROUP_TABLE);
    if ( !$get_all )
        $sql .= " where " . DB_PGROUP_DEL . " = " . PGROUP_DEL_NOT;
    $count  = get_row_from_db_by_sql($sql);
    if ( sync_array($count) )
        return $count['num'];
    else
        return 0;
}
/**
 * 项目组名称列表
 */
function project_group_list_all() {
    $nl = array();
    $l = project_group_list(0);
    if($l && is_array($l)){
        foreach($l as $v){
            $k      = $v[DB_PGROUP_NAME];
            $nl[$k] = $v[DB_PGROUP_ID];
        }
    }
    return $nl;
}
/**
 * 获取单条记录
 */
function project_group_get($id) {
    $ret = array();
    if ( (int)$id <= 0 ) return $ret;
    $sql = sprintf("select * from %s where %s = %d", SYNC_PROJECT_GROUP_TABLE, DB_PGROUP_ID, $id);
    return get_row_from_db_by_sql($sql);
}
/**
 * 获取单条记录,根据项目组名字
 */
function project_group_get_by_name($group_name) {
    $ret = array();
    if ( !$group_name ) return $ret;
    $sql = sprintf("select * from %s where %s = '%s'", SYNC_PROJECT_GROUP_TABLE, DB_PGROUP_NAME, $group_name);
    return get_row_from_db_by_sql($sql);
}
/**
 * 更新记录
 */
function project_group_update($id, $group_name, $group_desc, $pg_del = NULL) {
    $update = true;
    if ( (int)$id <= 0 ) return false;
    $pgroup_info = pgroup_get($id);
    if ( !sync_array($pgroup_info) ) return false;
    $sql = sprintf("update %s set ", SYNC_PROJECT_GROUP_TABLE);
    if ( $group_name && $group_name != $pgroup_info[DB_PGROUP_NAME] )
        $sql .= sprintf("%s = '%s', ", DB_PGROUP_NAME, $group_name);
    if ( $group_desc && $group_desc != $pgroup_info[DB_PGROUP_DESC])
        $sql .= sprintf("%s = '%s', ", DB_PGROUP_DESC, $group_desc);
    if ( isset($pg_del) && (int)$pg_del != $pgroup_info[DB_PGROUP_DEL])
        $sql .= sprintf("%s = %d, ", DB_PGROUP_DEL, $pg_del);
    if ( substr($sql, -4) == 'set ')
        $update = false;
    if ( $update ) {
        $sql  = substr($sql, 0, -2);
        $sql .= sprintf(" where %s = %d", DB_PGROUP_ID, $id); 
        return insert_update_db_by_sql($sql);
    } else 
        return true;
} 
/**
 * 删除记录
 */
function project_group_delete($id) {
    if ( (int)$id <= 0 ) return false;
    $sql = sprintf("update %s set %s = %d where %s = %d", SYNC_PROJECT_GROUP_TABLE, 
        DB_PGROUP_DEL, PGROUP_DEL_YES, DB_PGROUP_ID, $id);
    return insert_update_db_by_sql($sql);
}
/**
 * 判断项目组名字是否已经存在
 */
function project_group_name_exists($group_name, $id = NULL) {
    $group = project_group_get_by_name($group_name);
    if ( sync_array($group) && $group[DB_PGROUP_ID] > 0 && $group[DB_PGROUP_ID] != $id )
        return true;
    else
        return false;
}
