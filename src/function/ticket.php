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
 * 创建一个新的上线单
 */
function ticket_create_new($t_id) {
    $op_list[] = ticket_op_struct(OP_TYPE_CREATE_TIME);
    $fl = array();

    $sql = sprintf("insert into %s set %s = %d, %s = '%s', %s = '%s', s_md5_sum = '%s', %s = '%s'",
            SYNC_TICKETS_TABLE, DB_SECTION_TRAC_ID, $t_id, DB_SECTION_OP_LIST, serialize($op_list),
            DB_SECTION_FILE_LIST,  ticket_fmt_l($fl), ticket_l_md5($fl), DB_SECTION_OWNER, current_username());
    $conn = get_mysql_connection();
    if($conn){
        $result = mysql_query($sql, $conn);
        if($result) return mysql_insert_id($conn);
        sync_log("创建上线单失败 sql:" . $sql);
    }
    return false;
}
/**
 * 格式化上线单的文件列表
 */
function ticket_tidy($pname, $fl) {
    $r = array();
    if(!sync_array($fl)) return $r;
    $oerrno = err_get();
    foreach($fl as $v){
        #获得svn的绝对地址，需要替换掉多余的路径信息
        $px = sync_svn_prefix($pname);
        $up = sync_svn_uri($pname);
        $uri = $v[OP_LIST_KEY_URI];
        $uri = str_replace($up, '', $uri);

        $tv = $v[OP_LIST_KEY_V];
        $ta = $v[OP_LIST_KEY_ACTION];
        $tu = $v[OP_LIST_KEY_AUTHOR];
        $td = $v[OP_LIST_KEY_DATE];
        $fk = ticket_fmt_fl_key($pname . $px . $up . $uri);
        #判断是否是目录
        $dv = $ta != SVN_FILE_ACTION_TYPE_D ? $tv : $tv - 1;
        $ti = sync_svn_url_is_dir(ticket_fmt_uri($px, $up, $uri), $dv);
        $r[$fk] = ticket_fmt_fl($uri, $tv , $pname, $tu, $td, $ta, $ti, $px, $up);
    }
    err_set($oerrno);
    return $r;
}
/**
 * 修改ticket的文件列表
 */
function ticket_modify($t_id, $pname, $fl = array(), $h_id = null){
    $ti = ticket_info($t_id);
    if(!$ti) return false;
    #旧的文件列表
    $flist = $ti[DB_SECTION_FILE_LIST];
    #要添加的文件列表
    $fl = ticket_tidy($pname, $fl);

    #修改文件列表
    foreach($fl as $k => $v)
        $flist[$k] = $v;

    if(!$flist) return false;

    array_unshift($ti[DB_SECTION_OP_LIST], ticket_op_struct(OP_TYPE_MODIFY_TIME, $h_id));

    $result = ticket_db_m($t_id, $flist, $ti[DB_SECTION_OP_LIST]);

    return $result;
}

/**
 * 删除文件列表
 */
function ticket_del_flist($t_id, $dflist, $hid, &$dlist) {
    $ti = ticket_info($t_id);
    if(!$ti) return false;
    #获得删除后的文件列表

    $flist = ticket_delete_flist_ex($dflist, ticket_flist($t_id), $dlist);
    array_unshift($ti[DB_SECTION_OP_LIST], ticket_op_struct(OP_TYPE_DEL_TIME, $hid));

    return ticket_db_m($t_id, $flist, $ti[DB_SECTION_OP_LIST]);
}
/**
 * 修改文件列表
 */
function ticket_db_m($t_id, $file_list = array(), $op_list = array(),
                        $action = '', $time = ''){
    if(!$time) $time = time();
    if(sync_array($op_list)) $op_list = array_reverse($op_list);
    $field = $action == OP_TYPE_SYNC_TIME ? 's_sync_time' : 's_list_mtime';
    $sql = sprintf("update %s set %s = '%s', %s = '%s', %s = '%s', %s = %d  where %s = %d",
                        SYNC_TICKETS_TABLE, DB_SECTION_OP_LIST, ticket_fmt_l($op_list),
                        DB_SECTION_FILE_LIST, ticket_fmt_l($file_list), 's_md5_sum', ticket_l_md5($file_list),
                        $field, $time, DB_SECTION_TRAC_ID, $t_id);
    if($conn = get_mysql_connection()){
        $result = mysql_query($sql, $conn);
        if($result){
            #更新ticket缓存
            ticket_info($t_id, false);
            return true;
        }
    }
    return false;
}
/**
 * 删除上线单中的文件
 */
function ticket_delete_flist_ex($keys = array(), $fl, &$d){
    if(sync_array($keys)){
        foreach($keys as $key => $value){
            if( @array_key_exists($value, $fl) ){
                $d[$value] = $fl[$value];
                unset($fl[$value]);
            }
        }
    }
    return $fl;
}
/**
 * 记录同步操作日志
 */
function ticket_sync_action($t_id, $hid = null, $action = OP_TYPE_SYNC_TIME) {
    $info = ticket_info($t_id);
    $ol = $info[DB_SECTION_OP_LIST];
    $fl    = $info[DB_SECTION_FILE_LIST];
    $array = ticket_op_struct($action, $hid);
    array_unshift($ol, $array);
    $time = $array[OP_LIST_KEY_OPTIME];
    return ticket_db_m($t_id, $fl, $ol, $action, $time);
}
/**
 * 根据id获得某个ticket的信息
 */
function ticket_info($id, $c = true) {
    static $cache = array();
    if($c && isset($cache[$id])) return $cache[$id];
    $ti = ticket_info_db($id);
    if($ti){
        $ti[DB_SECTION_FILE_LIST] = ticket_unfmt_l($ti[DB_SECTION_FILE_LIST]);
        $ti[DB_SECTION_OP_LIST] = array_reverse(ticket_unfmt_l($ti[DB_SECTION_OP_LIST]));
    }
    if($ti) $cache[$id] = $ti;
    
    return $ti;
}
/**
 * 根据id获得某个ticket的信息
 */
function ticket_flist($t_id) {
    $fl = array();
    $ti = ticket_info($t_id);
    if(sync_array($ti))
        $fl = $ti[DB_SECTION_FILE_LIST];
    return $fl;
}
/**
 * 根据id获得某个ticket的信息操作
 */
function ticket_ops($t_id) {
    $ops = array();
    $ti = ticket_info($t_id);
    if(sync_array($ti))
        $ops= $ti[DB_SECTION_OP_LIST];

    if(sync_array($ops))
        foreach($ops as &$v)
            $v[OP_LIST_KEY_OPTYPER] = sync_op2str($v[OP_LIST_KEY_OPTYPE]);
    return $ops;
}
/**
 * 从数据库获取上线单信息
 */
function ticket_info_db($id) {
    $sql = sprintf("select * from %s where %s = %d",
            SYNC_TICKETS_TABLE, DB_SECTION_TRAC_ID, intval($id));
    $ti = get_row_from_db_by_sql($sql);
    return $ti;
}
/**
 * 将操作信息格式化成自有格式
 */
function ticket_op_struct($optype, $hid = NULL) {
    if( version_compare(phpversion(), '5.1', '>=') &&
            isset($_SERVER['REQUEST_TIME'])){
        $time = $_SERVER['REQUEST_TIME'];
        if(!$time){
            $time = time();
        }
    }
    $result = array(
            OP_LIST_KEY_OPTIME =>$time,
            OP_LIST_KEY_OPTYPE =>$optype,
            OP_LIST_KEY_OPER => current_username()
        );
    if($hid) $result[OP_LIST_KEY_HID] = $hid;
    return $result;
}
/**
 *    得到最近上线表单的信息
 */
function ticket_get_latest($page = 1, $rows = 10) {
    $sql = "select * from " . SYNC_TICKETS_TABLE . " order by s_id desc" . get_limit_str($page, $rows);
    $l = get_row_from_db_by_sql($sql, true);
    ticket_unpack_list($l);
    return $l;
}
/**
 * 获取最新上线单数目
 */
function ticket_count($username = null) {
    $count = 0;
    $sql = "select count(*) as num from " . SYNC_TICKETS_TABLE;
    if($username) $sql .= " where s_owner = '$username'";
    $is = get_row_from_db_by_sql($sql);
    if ( is_array($is) ) $count = (int)$is['num'];
    return $count;
}
function ticket_unpack(&$item) {
    $item[DB_SECTION_OP_LIST] = array_reverse(unserialize($item[DB_SECTION_OP_LIST]));
    $item[DB_SECTION_FILE_LIST] = unserialize($item[DB_SECTION_FILE_LIST]);
}
function ticket_unpack_list(&$list) {
    if(sync_array($list))
        foreach($list as &$v)
            ticket_unpack($v);
}
/**
 * 获得某个用户的上线单
 * 默认是所有用户
 */
function ticket_get_mine($u = NULL, $page = 1, $rows = 10) {
    $sql = "select * from " . SYNC_TICKETS_TABLE;
    if($u) $sql .= " where " . DB_SECTION_OWNER . " = '$u' ";
    $sql .= " order by s_id desc ";
    $sql .= get_limit_str($page, $rows);
    $is = get_row_from_db_by_sql($sql, true);
    ticket_unpack_list($is);
    return $is;
}
/**
 * 获得某个时间范围内的上线单
 * 默认是所有用户
 */
function ticket_get_bytime($bt, $et, $page = 1, $rows = 10, $type = 'sync') {
    $bt = intval($bt);
    $et = intval($et);
    $min = min($bt, $et);
    $max = max($bt, $et);

    $cond = " between $min and $max ";
    $field = $type === 'sync' ? 's_sync_time' : 's_list_mtime';    

    $sql = "select * from " . SYNC_TICKETS_TABLE;
    $sql .= " where " . $field . $cond ;
    $sql .= " order by $field desc";
    $sql .= get_limit_str($page, $rows);
    $is = get_row_from_db_by_sql($sql, true);
    ticket_unpack_list($is);
    return $is;
}
/**
 * 所得时间搜索时候的数量
 */
function ticket_get_bytime_count($bt, $et, $type = 'sync') {
    $count = 0;
    $bt = intval($bt);
    $et = intval($et);
    $min = min($bt, $et);
    $max = max($bt, $et);

    $cond = " between $min and $max ";
    $field = $type === 'sync' ? 's_sync_time' : 's_list_mtime';    

    $sql = "select count(*) as num from " . SYNC_TICKETS_TABLE;
    $sql .= " where " . $field . $cond ;

    $is = get_row_from_db_by_sql($sql);
    if ( is_array($is) ) $count = (int)$is['num'];
    return $count;
}
/**
 * 合并两个上线单的文件列表
 */
function sync_ticket_merge_fl($fl, $t2) {
    $ti2 = ticket_info($t2);
    $fl2 = ticket_flist($t2);
    if(sync_array($fl2)) {
        return array_merge($fl, $fl2);
    }
    return $fl;
}
/**
 * 根据上线单id获得单中项目列表
 */
function ticket_get_project_names($tid) {
    $pns = array();
    $fl = ticket_flist($tid);
    if(sync_array($fl)){
        foreach($fl as $v){
            $pn = $v[OP_LIST_KEY_PN];
            $pns[$pn] = 1;
        }
    }
    return $pns;
}
/**
 * 格式化文件列表字段
 */
function ticket_fmt_l($l) {
    return serialize($l);
}
/**
 * 计算文件列表的md5校验值
 */
function ticket_l_md5($l) {
    if(!sync_array($l))
        return '';
    $s = '';
    foreach($l as $k => $v){
        $s .= implode('', $v);
    }
    return md5($s);
}
function ticket_unfmt_l($fl_str) {
    $fl = unserialize($fl_str);
    return sync_array($fl) ? $fl : array();
}
/**
 * 作者
 */
function ticket_fl_a($item) {
    return $item[OP_LIST_KEY_AUTHOR];
}
/**
 * 修改类型
 */
function ticket_fl_c($item) {
    return $item[OP_LIST_KEY_ACTION];
}
/**
 * 最后时间
 */
function ticket_fl_d($item) {
    return $item[OP_LIST_KEY_DATE];
}
/**
 * 所属项目
 */
function ticket_fl_p($item) {
    return $item[OP_LIST_KEY_PN];
}
/**
 * 是否是目录
 */
function ticket_fl_dir($item) {
    return $item[OP_LIST_KEY_DIR];
}
/**
 * 标记一个文件的唯一绝对地址
 */
function ticket_fl_u($item) {
    return ticket_fmt_uri($item[OP_LIST_KEY_PREFIX],
            $item[OP_LIST_KEY_UPREFIX], $item[OP_LIST_KEY_URI]);
}
/**
 * 文件的相对路径
 */
function ticket_fl_uri($item) {
    return $item[OP_LIST_KEY_URI];
}
/**
 * 文件的相对路径的前缀
 */
function ticket_fl_puri($item) {
    return $item[OP_LIST_KEY_UPREFIX];
}
/**
 * 版本库的根地址
 */
function ticket_fl_px($item) {
    return $item[OP_LIST_KEY_PREFIX];
}
/**
 * 文件的版本
 */
function ticket_fl_v($item) {
    return $item[OP_LIST_KEY_V];
}
/**
 * 文件的版本
 */
function ticket_fl_rv($item) {
    return $item[OP_LIST_KEY_RV];
}
/**
 * 内部函数
 * px    服务的前缀 svn://ip:port
 * up    版本库前缀 /uprifex
 * uri    文件的版本库地址  /test.php
 */
function ticket_fmt_uri($px, $up, $uri) {
    return  sync_trim_path($px . $up . $uri);
}
function ticket_fmt_fl_key($pn, $px, $up, $uri) {
    return md5($pn . $px . $up . $uri);
}
/**
 * 获得上线单的校验值
 */
function ticket_sum($t_id) {
    $i = ticket_info($t_id);
    return sync_array($i) ? $i['s_md5_sum'] : 0;
}
/**
 * 获得上线单某字段的数量
 */
function ticket_sum_s($slzd) {
    if(is_array($slzd)) return count($slzd);
    if(unserialize($slzd))
        return count(unserialize($slzd));
    return 0;
}
/**
 * 获得上线单文件数量
 */
function ticket_sum_fl_ex($fl) {
    return ticket_sum_s($fl);
}
function ticket_sum_fl($i) {
    return ticket_sum_fl_ex($i[DB_SECTION_FILE_LIST]);
}
function ticket_sum_op_ex($ops) {
    return ticket_sum_s($ops);
}
function ticket_sum_op($i) {
    return ticket_sum_op_ex($i[DB_SECTION_OP_LIST]);
}
function ticket_owner($i) {
    return $i[DB_SECTION_OWNER];
}
function ticket_id($i) {
    return $i[DB_SECTION_TRAC_ID];
}
function ticket_last_op_time($i) {
    if(sync_array($oa = unserialize($i[DB_SECTION_OP_LIST]))){
        $item = $oa[0];
        return $item[OP_LIST_KEY_OPTIME];
    }
    $item = $i[DB_SECTION_OP_LIST][0];
    return $item[OP_LIST_KEY_OPTIME];
}
/**
 * 获得上线单的创建时间
 */
function ticket_first_op_time($i) {
    if(sync_array($oa = $i[DB_SECTION_OP_LIST])){
        return $oa[0][OP_LIST_KEY_OPTIME];
    }
    return 0;
}
/**
 * 获得上线单最后操作
 */
function ticket_last_op($i) {
    if(sync_array($oa = $i[DB_SECTION_OP_LIST])){
        $item = $oa[0];
        return $item[OP_LIST_KEY_OPTYPE];
    }
    return OP_TYPE_CREATE_TIME;
}
/**
 * 是否有同步操作
 */
function ticket_sync_op($i) {
    if(sync_array($oa = $i[DB_SECTION_OP_LIST]))
        foreach($oa as $v)
            if($v[OP_LIST_KEY_OPTYPE] == OP_TYPE_SYNC_TIME) return $v;
    return null;

}
/**
 * 获取当前最大的上线单ID
 */
function ticket_max_id() {
	$sql = sprintf("select max(%s) as max from %s", DB_SECTION_TRAC_ID, SYNC_TICKETS_TABLE);
    $max = get_row_from_db_by_sql($sql);
	if($max) return intval($max['max']);
	return 0;
}
