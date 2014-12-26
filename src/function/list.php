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
 * 新增加一条服务器配置
 */
function list_create($k, $v) {
    $conn = get_mysql_connection();
    if(!$conn) return false;
    
    $sql = sprintf("insert into %s (l_hash, l_data) values('%s', '%s')", SYNC_LIST_TABLE,
            $k, mysql_real_escape_string(_list_fmt($v)));
    $result = mysql_query($sql, $conn);
    if(!$result || mysql_affected_rows($conn)) return false;
    return true;
}
/**
 * 修改一条服务器配置
 */
function list_update($k, $v) {
    $conn = get_mysql_connection();
    if(!$conn) return false;
    
    $sql = sprintf("update %s set l_data = '%s' where l_hash =  '%s'",
                    SYNC_LIST_TABLE, mysql_real_escape_string(_list_fmt($v)), $k);
    mysql_query($sql, $conn);
    if(!mysql_affected_rows($conn)) return false;
    return true;
}
/**
 * 获得一条服务器配置
 */
function list_get($k) {
    $r = array();
    $conn = get_mysql_connection();
    if(!$conn) return false;
    
    $sql = sprintf("select * from %s where l_hash = '%s'", SYNC_LIST_TABLE, mysql_real_escape_string($k));
    $result = mysql_query($sql, $conn);
    $row = mysql_fetch_assoc($result);
    if($row) return _list_unfmt($row['l_data']);
    return $r;
}
function _list_fmt($data) {
    return sync_array($data) ? serialize($data) : serialize(array());
}
function _list_unfmt($data) {
    $a = unserialize($data);
    return sync_array($a) ? $a : array();
}
