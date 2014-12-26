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
 * 获得svn信息的内部函数
 */
function _sync_svn_info($url, $v = -1, $recurse = false) {
    if(svn_server_alive($url)) return false;
    $url = svn_url_port_filter($url);
    return svn_info($url, $recurse, $v);
}
/**
 * 判断一个uri是否是目录
 */
function sync_svn_url_is_dir($url, $v = -1) {
    $url = _svn_url($url, $v);
    $r = _sync_svn_info($url, $v);
    return is_array($r) && $r && isset($r[0]['kind']) && $r[0]['kind'] === 2 ? true : false;
}
/**
 * 根据一个svn地址获得版本库相关信息
 */
function sync_svn_infos($url) {
    $i = _sync_svn_info($url);
    return sync_array($i) ? sync_svn_fmt($i) : array();
}
/**
 * 格式化返回版本库信息
 */
function sync_svn_fmt($i) {
    $ret = array();
    $repos = $i[0]['repos'];
    $ret = parse_url($repos);
    if(sync_array($ret) && !isset($ret['port']))
        $ret['port'] = sync_scheme_dport($ret['scheme']);
    $ret['uri'] = str_replace($repos, '', $i[0]['url']);
    $ret['prefix'] = $ret['path'];
    unset($ret['path']);
    return $ret;
}
function sync_scheme_dport($scheme) {
    return scheme2port($scheme);
}

/**
 * 对svn函数做了封装
 */
function sync_svn_log($url, $s_version = SVN_REVISION_HEAD,
        $e_version = SVN_REVISION_INITIAL, $limit = 0) {
    if(svn_server_alive($url)) return false;
    $ret = null;
    $url = svn_url_port_filter($url);
    $ret = svn_log($url, $s_version, $e_version, $limit);
    return $ret;
}
/**
 * 对svn库的封装
 */
function sync_svn_cat($url, $s_version = null) {
    if(svn_server_alive($url)) return false;
    $url = svn_url_port_filter($url);
    $url = _svn_url($url, $s_version);
    if($s_version) return svn_cat($url, $s_version);
    return svn_cat($url);
}
/**
 * 获得当前分支最新的版本
 */
function svn_get_version_info($uri) {
    $array = sync_svn_log($uri, SVN_REVISION_HEAD, SVN_REVISION_INITIAL, 1);
    $version=$array[0]['rev'];
    return $version;
}

/**
 * 设置svn登录信息
 */
function svn_auth($username = '', $password = '') {
    static $authed = false;
    if(!$authed || $authed != crc32($username . $password)){
        svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_USERNAME, $username);
        svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_PASSWORD, $password);
        $authed = crc32($username . $password);
    }
    return $authed;
}

/**
 * 获得当前url的trunk最新的版本好
 */
function svn_file_lv($url) {
    $v = 0;
    $array = sync_svn_log($url, SVN_REVISION_HEAD, SVN_REVISION_INITIAL, 1);
    if( $array && array_key_exists('rev', $array[0]) )
        $v = intval($array[0]['rev']);
    return $v;
}

/**
 * 将svn_log返回的以版本为数组的格式,格式化成我想要的以文件路径为键的数组
 */
function svn_log_info_to_array($array, $rows = 1, $multi = false, $pname = '') {
    $ret = array();
    if($multi){
        $total_rows = count($array);
        #如果总行数<需要的行数
        $row = min($total_rows, $rows);
        for($i = $rows; $i > 0; --$i ){
            $tmp_key = $i - 1;
            if( isset($array[$tmp_key]['paths']) && $array[$tmp_key]['paths'] ){#有文件
                foreach($array[$tmp_key]['paths'] as $value){
                    $key = $value['path'];
                    #检查是否是跨目录提交
                    if( !comp_svn_url_and_path($key, $pname) ) continue;
                    if(isset($ret[$key]) && $ret[$key][OP_LIST_KEY_V] > $array[$tmp_key]['rev']) continue;
                    $ret[$key] = ticket_fmt_fl($value['path'], $array[$tmp_key]['rev'], $pname,
                    $array[$tmp_key]['author'], convert_svn_time($array[$tmp_key]['date']),
                    $value['action'], null, $array[$tmp_key]['msg'], null);
                }
            }
        }
    }else{
        if( isset($array[0]['paths']) && $array[0]['paths'] ){#有文件
            foreach($array[0]['paths'] as $value){
                $key = $value['path'];
                if( !comp_svn_url_and_path($key, $pname) ) continue;
                $ret[] = ticket_fmt_fl($value['path'],  $array[0]['rev'], $pname,
                                    $array[0]['author'], convert_svn_time($array[0]['date']),
                                    $value['action'], null, $array[0]['msg'], null);
            }
        }
    }
    return $ret;
}
/**
 * 比较函数,用于排序
 */
function sort_svn($a, $b) {
    if( $a['version'] == $b['version'] ) return 0;
    return $a['version'] > $b['version'] ? -1 : 1;
}
/**
 * 转换svn输出的时间到指定的格式
 */
function convert_svn_time($date) {
    if( preg_match(REG_FORMAT_SVN_DATE, $date, $array) ){
        $time = $array['ymd'] . ' ' . $array['his'];
        $date = new DateTime($time);
        $new_date = date_add($date, new DateInterval("PT8H"));
        return $new_date->format("Y-m-d H:i:s");
    }    
    return $date;
}
/**
 * 检查svnserver信息
 */
function svn_server_info($url, $u, $p) {
    $r = svn_server_alive($url);
    if($r) return $r;
    if (!$u) return 4;
    if (!$p) return 2;
    svn_auth($u, $p);
    if(!sync_svn_infos($url)){
        if(err_get()) return err_get();
        return 7;
    }
    return 0;
}
/**
 * 检查svnserver是否可用
 */
function svn_server_alive($url) {
    if (!$url) return 3;
    $si = parseurl($url);
    if(!sockalive($si['host'], $si['port']))
        return 1;
    return 0;
}
/**
 * 返回svn错误信息的可读错误信息
 */
function svn_si_errmsg($int) {
    $e = array(
        0 => '服务器可用',
        1 => '服务器端口不可用',
        2 => '用户和密码不对应',
        3 => '版本库不存在',
        4 => '用户名不能为空',
        5 => '文件路径不正确',
        6 => '未知错误',
        7 => '目录不支持该cat操作',
        8 => '对象不可读,请检查svn用户权限',
        9 => 'svn服务的auth文件配置错误',
    );
    return isset($e[$int]) ? $e[$int] : '未知错误';
}
/**
 * svn地址过滤器
 */
function svn_url_port_filter($url) {
    return preg_replace(array('/^(svn:\/\/[^:]+)(:3690)/',
                '/^(https:\/\/[^:]+)(:443)/',
                '/^(http:\/\/[^:]+)(:80)/'), '\1', $url);
}

/**
 * 捕捉svn库错误的函数
 * 其真正错误原因在warning中
 */
function svn_warning_handler($errmsg) {
    if(preg_match('/svn +error\(s\)[^(]*\(([^)]+)\)/', $errmsg, $a))
        return $a[1];
    return '';
}
/**
 * 修改url路径
 */
function _svn_url($url, $v) {
    return $v > 0 ? $url . "@$v" : $url;
}
