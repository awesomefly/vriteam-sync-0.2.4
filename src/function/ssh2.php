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
 * 将文件列表中需要同步导某台server的文件同步过去
 */
function ssh2_scp_files($server, $fl= array()){
    $ret = _ssh_ret_init();
    $nfl = sync_file_filter($fl, $server[SYNC_SERVER_INFO_KEY_ID]);
    if(!sync_array($nfl)) return $ret;
    #建立到服务器的连接
    $conn = ssh_connect($server);
    #遍历文件列表
    foreach($nfl as $k=> $item){
        #文件在远程服务器的绝对路径
        $rpath = sync_server_abs_path(ticket_fl_uri($item), $server[SYNC_SERVER_INFO_KEY_ID]);
        #根据文件的操作做处理(新增,修改,和删除)
        if(ticket_fl_c($item) != SVN_FILE_ACTION_TYPE_D){#新增或者是修改
            #real_path是文件在本机的物理真实的绝对路径, value是相对路径
            $abs_path = sync_file_abs_path(ticket_fl_uri($item), ticket_fl_p($item));
            $result = ssh_scp($conn, $abs_path, $rpath, ticket_fl_dir($item));
        }else
            $result = ssh_scp_rm_dir_file($conn, $rpath, ticket_fl_dir($item));

        if($result) _ssh_ret_add_s($ret, ticket_fmt_sync_fl($item, $rpath, 0, null));
        else{
            $errno = ssh_scp_err_hander($conn, $rpath, ticket_fl_dir($item), ticket_fl_c($item));
            $msg = ssh_errno2str($errno);
            _ssh_ret_add_f($ret, ticket_fmt_sync_fl($item, $rpath, $errno, $msg));
            sync_log($abs_path .  "\t" . $rpath . "($msg)");
        }
    }
    ssh_close($conn);
    return $ret;
}
/**
 * ssh 执行脚本
 */
function ssh2_run_files($server, $fl){
	error_log("ssh2_run_files",0);
    $ret = _ssh_ret_init();
	$ret['server_info'] = $server;
	$ret['file'] = $fl;
    #建立到服务器的连接
    $conn = ssh_connect($server);
    #遍历文件列表
	error_log("run_files :".$fl,0);
	$stream = ssh2_exec($conn, $fl);
	$errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);

	stream_set_blocking($stream, true);
	stream_set_blocking($errorStream, true);

	$errresult = stream_get_contents($errorStream);
	$result = stream_get_contents($stream);
	
	error_log("result:".$result,0);
	error_log("errresult:".$errresult,0);
	if($result){
		_ssh_ret_add_s($ret, ticket_fmt_sync_fl($item, $rpath, 0, null));
		error_log(" success:".$result,0);
		$ret['suc'] = $result;
	}else{
		error_log(" error:".$errresult,0);
		$ret['fal'] = $errresult;
	}
    ssh_close($conn);
	return $ret;
}
/**
 * 将文件列表中需要同步导某台server的文件同步过去
 */
function ssh2_scp_files_backup($t_id, $server, $fl= array(), $h_id){
    $ret = _ssh_ret_init();
    $nfl = sync_file_filter($fl, $server[SYNC_SERVER_INFO_KEY_ID]);
    if(!sync_array($nfl)) return $ret;
    #建立到服务器的连接
    $conn = ssh_connect($server);
    #遍历文件列表
    foreach($nfl as $k=> $item)
        #文件在远程服务器的绝对路径
        $rpath[] = sync_server_abs_path(ticket_fl_uri($item), $server[SYNC_SERVER_INFO_KEY_ID]);
    return ssh_tar_w($conn, ssh2_backup_name($h_id), $rpath);
}
/**
 * 打包文件列表
 */
function ssh_tar_w($conn, $name, $fl) {
    if(!sync_array($fl)) return false;
    $files = implode(' ', $fl);
    $r = ssh_tar($conn, $name, $files);
    $lfile = sync_file_path_backup($name);
    sync_mkdir($lfile, '', false, BACKUP_PATH_PREFIX);
    $rlfile = sync_file_abs_path_backup($name);
    $r = ssh_scp_recv($conn, $name, $rlfile);
    if($r) ssh_tar_rm($conn, $name);
    return $r;
}
/**
 * 将文件列表中需要同步导某台server的文件同步过去
 */
function ssh2_scp_files_rollback($server, $h_id) {
    $ret = _ssh_ret_init();
    #建立到服务器的连接
    $conn = ssh_connect($server);
    #找到备份的文件
    $zname = ssh2_backup_name($h_id);
    $zpath = sync_file_abs_path_backup($zname);
    if(!file_exists($zpath)) return false;
    #复制到远程服务器上
    $r = ssh_scp($conn, $zpath, $zname);
    #回滚
    ssh_untar($conn, $zname);
    #删除压缩包
    ssh_tar_rm($conn, $zname);
    return true;
}
/**
 * 获得打包文件的名字
 */
function ssh2_backup_name($h_id) {
    return $h_id . '.tgz';
}
/**
 * 连接到远程ssh2服务器
 */
function ssh_connect($server) {
    if(!sync_array($server)) return false;
    $conn = ssh_connect_to_server(
                $server[SYNC_SERVER_INFO_KEY_IP],             #ip
                $server[SYNC_SERVER_INFO_KEY_PORT],           #port
                $server[SYNC_SERVER_INFO_KEY_USERNAME],       #用户名
                $server[SYNC_SERVER_INFO_KEY_PASSWORD]        #密码
            );
    return $conn;
}
/**
 * 获得同步文件失败的原因
 * 1:先检查文件是否存在
 * 如果存在则文件没有写权限
 * 如果不存在就检查上层文件夹是否存在
 * 如果存在就检查是否可写
 */
function ssh_scp_err_hander($conn, $rfile, $isdir = false, $act = SVN_FILE_ACTION_TYPE_M) {
    if($act != SVN_FILE_ACTION_TYPE_D){
        #远程文件存在,可能是权限不够
        if(ssh_file_exists($conn, $rfile)) return 2;
    }else{
        #远程不文件存在
        if(!ssh_file_exists($conn, $rfile)) return 5;
    }
        #远程文件不存在,检查父目录是否存在
    $r = ssh_dir_is_writeable($conn, dirname($rfile));
    if($r === null) return 1;#父目录不存在
    if($r === false) return 3;#父目录不可写
    return 4;
}
/**
 * 根据同步失败的错误码获得错误信息
 */
function ssh_errno2str($errno) {
    $m = array('成功', '远程目标文件的父目录不存在', '远程目标文件不可写',
                '远程目标文件的父文件夹不可写', '未知错误(磁盘满了?)', '远程目标文件不存在');
    return $m[$errno];
}
/**
 * 获得同步结果的空的数据结构
 */
function _ssh_ret_init() {
    return  array('suc'=> array(), 'fal' => array());
}
function _ssh_ret_add(&$ret, $value, $type = 'suc') {
    $ret[$type][] = $value;
}
function _ssh_ret_add_s(&$ret, $value) {
    _ssh_ret_add($ret, $value);
}
function _ssh_ret_add_f(&$ret, $value) {
    _ssh_ret_add($ret, $value, 'fal');
}
