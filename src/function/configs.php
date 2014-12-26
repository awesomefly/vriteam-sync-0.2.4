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
function configs_creat($k, $v) {
    $conn = get_mysql_connection();
    if(!$conn) return false;
    
    $sql = sprintf("insert into %s (c_k, c_v) values('%s', '%s')", SYNC_CONFIGS_TABLE,
            mysql_real_escape_string($k), mysql_real_escape_string($v));
    $result = mysql_query($sql, $conn);
    if(!$result){
        sync_log("创建失败" . $sql);
        return false;
    }
    return true;
}
/**
 * 修改一条服务器配置
 */
function configs_update($k, $v) {
    $conn = get_mysql_connection();
    if(!$conn) return false;
    
    $sql = sprintf("update %s set c_v = '%s' where c_k =  '%s')", SYNC_CONFIGS_TABLE,
            mysql_real_escape_string($k), mysql_real_escape_string($v));
    mysql_query($sql, $conn);
    if(!mysql_affected_rows($conn)){
        return false;
    }
    return true;
}
/**
 * 获得一条服务器配置
 */
function configs_get($k) {
    $r = array();
    $conn = get_mysql_connection();
    if(!$conn) return false;
    
    $sql = sprintf("select * from %s where c_k = '%s'", SYNC_CONFIGS_TABLE, mysql_real_escape_string($k));
    $result = mysql_query($sql, $conn);
    $row = mysql_fetch_assoc($result);
    if($row){
        $k = $row['c_k'];
        $v = $row['c_v'];
        $r[$k] = $v;
    }
    return $r;
}
/**
 * 获得所有服务器配置
 */
function configs_gets() {
    $r = array();
    $conn = get_mysql_connection();
    if(!$conn) return false;

    $sql = sprintf("select * from %s", SYNC_CONFIGS_TABLE);
    $result = mysql_query($sql, $conn);
    while($row = mysql_fetch_assoc($result)){
        $k = $row['c_k'];
        $v = $row['c_v'];
        $t = $row['c_t'];
        $r[$k] = $t == 1 ? intval($v) : strval($v);
    }
    return $r;
}
