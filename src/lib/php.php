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
 * 检查一个文件是否有php的语法错误
 */
function php_check_syntax($file) {
    $php = php_bin_path();    
    if(!$php || !@file_exists($file)) return null;
    exec($php . ' -l ' . $file, $ret);
    foreach($ret as $v)
        if(preg_match('/Parse\s+error/i', $v))
            return true;
    return false;
}
/**
 * 查找php的文件位置
 */
function php_bin_path() {
    if(!getenv('PATH')) return false;
    $parray = explode(':', getenv('PATH'));
    $parray[] = '/usr/local/php';
    $parray[] = '/usr/local/php5';
    foreach($parray as $v)
        if(@file_exists($v . '/bin/php'))
            return $v . '/bin/php';
    return false;
}
