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
 * 连接到服务器
 */
function ssh_connect_to_server($ip, $port, $user, $pwd, $pkfile = null, $prikfile = null) {
    $conn = ssh2_connect($ip, $port);
    if($pkfile && $prikfile && file_exists($pkfile) && $file_exists($prikfile))
        return ssh2_auth_pubkey_file($conn, $user, $pkfile, $prikfile, $pwd) ? $conn : false;
    return ssh2_auth_password($conn, $user, $pwd) ? $conn : false;
}
/**
 * 将文件或者目录复制到远程服务器
 */
function ssh_scp_dir_file($conn, $lfile, $rfile, $isdir = null, $mode = 0755) {
    if($isdir === null) $isdir = isdir_by_local($lfile);
    if($isdir) $result = ssh_scp_mkdir($conn, $rfile, $mode);
    else $result = ssh_scp_send_file($conn, $lfile, $rfile, $mode);
    return $result;
}
function ssh_scp($conn, $lfile, $rfile, $isdir = null, $mode = 0755) {
    return ssh_scp_dir_file($conn, $lfile, $rfile, $isdir, $mode);
}
/**
 * 复制一个文件
 */
function ssh_scp_send_file($conn, $lfile, $rfile, $mode) {
    $result = ssh2_scp_send($conn, $lfile, $rfile, $mode);
    return $result;
}
/**
 * 创建一个目录
 */
function ssh_scp_mkdir($conn, $rfile, $mode) {
    if(ssh_file_exists($conn, $rfile)) return true;
    $sftp = ssh2_sftp($conn);
    return ssh2_sftp_mkdir($sftp, $rfile, $mode, true);
}
/**
 * 将文件或者目录删除
 */
function ssh_scp_rm_dir_file($conn, $rfile, $isdir = null) {
    if($isdir === null) $isdir = isdir_by_local($lfile);
    if($isdir) $result = ssh_scp_rmdir($conn, $rfile);
    else $result = ssh_scp_rm($conn, $rfile);
    return $result;
}
/**
 * 删除一个目录
 */
function ssh_scp_rmdir($conn, $rfile) {
    $result = ssh2_exec($conn, sprintf("/bin/rm -rf %s", $rfile));
    return $result;
}
/**
 * 删除一个文件
 */
function ssh_scp_rm($conn, $rfile) {
    $sftp = ssh2_sftp($conn);
    $result = ssh2_sftp_unlink($sftp, $rfile);
    return $result;
}
/**
 * 使用tar gzip打包文件和目录
 */
function ssh_tar($conn, $name, $files) {
    $c = sprintf("/bin/tar -Pzcf %s --ignore-failed-read %s", $name, $files);
    $result = ssh2_exec($conn, $c);
    return $result;
}
/**
 */
function ssh_untar($conn, $name, $files) {
    $c = sprintf("/bin/tar -zxf %s -C /", $name);
    $result = ssh2_exec($conn, $c);
    return $result;
}
function ssh_tar_rm($conn, $name) {
    $c = sprintf("/bin/rm -f %s", $name);
    $result = ssh2_exec($conn, $c);
    return $result;
}
/**
 * 从远程服务器复制一个文件到本地
 */
function ssh_scp_recv($conn, $rfile, $lfile, $isdir = false) {
    $result = ssh2_scp_recv($conn, $rfile, $lfile);
    if(!$result) $result = ssh2_scp_recv($conn, $rfile, $lfile);
    return $result;
}
/**
 * 关闭一个连接
 */
function ssh_close($conn) {
    ssh2_exec($conn, 'exit');
}
/**
 * 检查一个目录是否存在
 */
function ssh_file_exists($conn, $file) {
    $sftp = ssh2_sftp($conn);
    $difo = ssh2_sftp_stat($sftp, $file);
    return $difo ? true : false;
}
/**
 * 判断一个远程服务器目录是否可写
 */
function ssh_dir_is_writeable($conn, $dir) {
    if(!ssh_file_exists($conn, $dir)) return null;
    if(ssh2_scp_send($conn, __FILE__, $dir . '/' . md5(__FILE__))){
        ssh_scp_rm($conn,  $dir . '/' . md5(__FILE__));
        return true;
    }
    return false;
}
/**
 * 检查fileserver信息
 */
function ssh2_server_info($host, $u, $p, $dir, $port = 22) {
    if(!$host) return 6;
    if(!$p) return 4;
    if(!$dir) return 5;
    if(!sockalive($host, $port)) return 1;
    if( !($conn = ssh_connect_to_server($host, $port, $u, $p) ) ) return 2;

    $r = ssh_dir_is_writeable($conn, $dir);
    if($r === null) return 3;
    elseif($r === false) return 7;
    return 0;
}
/**
 * 返回ssh2错误信息的可读错误信息
 */
function ssh2_errmsg($int) {
    $e = array(
        0 => '服务器可用',
        1 => '服务器端口不可用',
        2 => '用户名和密码不对应',
        3 => '目录不存在',
        4 => '密码不能为空',
        5 => '目录前缀不能为空',
        6 => 'host不能为空',
        7 => '目录没有写权限',
    );
    return isset($e[$int]) ? $e[$int] : '未知错误';
}
/**
 * 返回一个ssh2服务器信息的数据结构
 */
function ssh2_server_struct($host, $port, $u, $p, $dir) {
    return array(
        'host' => $host,
        'port' => $port,
        'username' => $u,
        'password' => $p,
        'prefix' => $dir,
        'scheme' => 'ssh2',
    );
}
