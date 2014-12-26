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
 * 获得mysql连接
 */
function get_mysql_connection() {
    static $connection;
    if($connection) return $connection;

    $connection = mysql_connect($GLOBALS['_MYSQL_INFO']['host'],
            $GLOBALS['_MYSQL_INFO']['username'], $GLOBALS['_MYSQL_INFO']['password']);
    if($connection){
        mysql_select_db($GLOBALS['_MYSQL_INFO']['db']);
        mysql_query("set names " . $GLOBALS['_MYSQL_INFO']['charset']);
        return $connection;
    }
    sync_log('连接数据库失败');
    return false;
}
/**
 * 从db查询
 */
function get_row_from_db_by_sql($sql, $multi_rows = false) {
    $conn = get_mysql_connection();
    if( !$conn ) return false;
    
    $result = mysql_query($sql, $conn);
    if(!$result){
        sync_log("错误的sql:" . $sql);
        return false;
    }
    $ret = array();
    if($multi_rows)
        while($row = mysql_fetch_assoc($result))
            $ret[] = $row;
    else
        $ret = mysql_fetch_assoc($result);
    return $ret;
}
/**
 * 插入，更新数据
 */
function insert_update_db_by_sql($sql, $get_id = false) {
    $conn = get_mysql_connection();
    if(!$conn){ return false; }
    $return = mysql_query($sql, $conn);
    if ( $get_id ) return mysql_insert_id($conn);
    else return $return;
}
/**
 * 获取最新的id
 */
function get_last_id() {
    return mysql_insert_id();
}
