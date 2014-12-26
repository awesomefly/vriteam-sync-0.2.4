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
 * 创建本次上线单的文件
 */
function sync_create_file($uri, $contents, $pname= 'app', $dir, $base_path = LOCAL_PATH_PREFIX) {
    #先创建文件所以在目录    
    if( sync_mkdir($uri, $pname, $dir, $base_path) ){
        #获得文件真是的物理路径
        $abs_path = file_abs_path($uri, $pname);
        sync_log('local file path is : ' . $abs_path);
        #将文件写入磁盘
        $result = file_put_contents($abs_path, $contents);
        #如果要写的文件就是0那也认为成功
        if(strlen($contents) == 0) $result = 1;
        return $result;
    }else{
        err_set(1);
        return false;
    }
}
/**
 * 根据svn路径在指定的目录前缀里边创建所有目录
 */
function sync_mkdir($uri, $pn, $dir = false, $base_path = LOCAL_PATH_PREFIX) {
    #去掉svn前缀,获得真实文件的相对路径
    $real_path = file_local_path($uri, $pn, $base_path);
    if(!$dir){#如果是文件
        $path_array = pathinfo($real_path);
        $dir = trim($path_array['dirname'], FS_DELIMITER);
    }else{
        $dir = trim($real_path, FS_DELIMITER);
    }

    if( @is_dir( realpath($real_path)) ){
        return true;
    }

    $dir_array = explode(FS_DELIMITER, $dir);
    $prefix = '';
    foreach($dir_array as $value){
        if(!is_dir($base_path . FS_DELIMITER . $prefix. FS_DELIMITER .$value)){
            $result = mkdir($base_path. FS_DELIMITER .$prefix. FS_DELIMITER .$value, 0755);
            if(!$result)
                return false;
        }
        $prefix .= FS_DELIMITER . $value;
    }
    return true;
}
/**
 * 对css和js文件进行压缩
 */
function file_compress_static($path) {
    return ;
    if( file_is_css($path) ){
        $type = 'css';
    }elseif( file_is_js($path) ){
        $type = 'js';
    }else{
        return;
    }
    $cmd = COMPRESS_CMD . $type . ' -o '. $path . ' '.$path;
    if( $ret = exec($cmd) ) sync_log("压缩文件出错了!");
}
/**
 * 判断文件是否是css
 */
function file_is_css($path) {
    $result = preg_match(REG_REPLACE_CSS, $path);
    return $result;
}
/**
 * 判断文件是否是js
 */
function file_is_js($path) {
    $result = preg_match(REG_REPLACE_JS, $path);
    return $result;
}
/**
 * 判断文件是否是图片和flash
 */
function file_is_pic_swf($path) {
    $result = preg_match(REG_REPLACE_PIC_WS, $path);
    return $result;
}
/**
 * 判断文件是否是css和js
 */
function is_css_or_js($path) {
    return file_is_css($path) || file_is_js($path);
}
/**
 * 判断文件是否是静态文件
 */
function file_is_asset($path) {
    return file_is_css($path) || file_is_js($path) || file_is_pic_swf($path);
}
/**
 * 获得文件的物理位置
 */
function file_local_path($path, $pname) {
    return sync_trim_path($pname . FS_DELIMITER . $path);
}
/**
 * 获得文件的绝对地址
 */
function file_abs_path($path, $pname, $bpath = LOCAL_PATH_PREFIX) {
    return sync_trim_path($bpath . FS_DELIMITER . file_local_path($path, $pname));
}
/**
 * 获得备份文件的绝对地址
 */
function file_abs_path_backup($name, $bpath = BACKUP_PATH_PREFIX) {
    $p = file_hash($name);
    return sync_trim_path($bpath . FS_DELIMITER . $p . FS_DELIMITER . $name);
}
function file_path_backup($name) {
    $p = file_hash($name);
    return sync_trim_path($p . FS_DELIMITER . $name);
}
/**
 * 备份文件到本地的散列函数
 */
function file_hash($name) {
    return strtoupper(substr(md5($name),0, 2));
}
