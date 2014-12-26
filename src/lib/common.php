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
 *    发送http请求的函数(1.0)协议
 */
function httpRequest($url, $type = "GET", $post_data = NULL, $fsock_timeout = 1) {
    $http_info = array();
    $url2 = parse_url($url);
    $url2["path"] = ($url2["path"] == "" ? "/" : $url2["path"]);
    $url2["port"] = !$url2["port"] ? 80 : $url2["port"];
    $host_ip = @gethostbyname($url2["host"]);
    $request =  $url2["path"] . ($url2["query"] != "" ? "?" . $url2["query"] : "") . ($url2["fragment"] != "" ? "#" . $url2["fragment"] : "");
    $fsock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if(!$fsock){
        //trigger_error(socket_strerror(socket_last_error()));
        return false;
    }
    /* connect host with timeout */
    socket_set_nonblock($fsock);
    @socket_connect($fsock, $host_ip, $url2["port"]);
    $ret = socket_select($fd_read = array($fsock), $fd_write = array($fsock), $except = NULL, $fsock_timeout, 0);
    if($ret === false){
        #trigger_error(socket_strerror(socket_last_error()));
        return false;
    }elseif ($ret != 1){
        #trigger_error("connect error or timeout");
        return false;
    }
    if($type == "GET"){//GET method
        $in = "GET " . $request . " HTTP/1.0\r\n";
        $in .= "Accept: */*\r\n";
        $in .= "User-Agent: http-Agent\r\n";
        $in .= "Host: " . $url2["host"] . "\r\n";
        $in .= "Connection: Keep-Alive\r\n\r\n";
    }else if($type == "POST"){//POST method
        //build post data
        $needChar = false;
        foreach($post_data as $key => $val)    {
            $post_data2 .= ($needChar ? "&" : "") . urlencode($key) . "=" . urlencode($val);
            $needChar = true;
        }
        $in  = "POST " . $request . " HTTP/1.0\r\n";
        $in .= "Accept: */*\r\n";
        $in .= "Host: " . $url2["host"] . "\r\n";
        $in .= "User-Agent: http-Agent\r\n";
        $in .= "Content-type: application/x-www-form-urlencoded\r\n";
        $in .= "Content-Length: " . strlen($post_data2) . "\r\n";
        $in .= "Connection: Close\r\n\r\n";
        $in .= $post_data2 . "\r\n\r\n";
        unset($post_data2);
    }else{//unknowd method
        exit;
    }
    if(!@socket_write($fsock, $in, strlen($in))){
        socket_close($fsock);
        return false;
    }
    unset($in);
    socket_set_block($fsock);
    #@socket_set_option($fsock, SOL_SOCKET, SO_RCVTIMEO, array("sec" => $fsock_timeout, "usec" => 0));
    //process response
    $out = "";
    while($buff = socket_read($fsock, 2048)){
        $out .= $buff;
    }
    //finish socket
    @socket_close($fsock);
    if(!$out){
        return '';
    }
    $pos = strpos($out, "\r\n\r\n");
    $head = substr($out, 0, $pos);        //http head
    $status = substr($head, 0, strpos($head, "\r\n"));        //http status line
    $body = substr($out, $pos + 4);        //page body
    if(preg_match("/^HTTP\/\d\.\d\s(\d{3,4})\s/", $status, $matches)){
        if(intval($matches[1]) / 100 == 2){
            return $body;
        }else{
            return NULL;
        }
    }else{
        return false;
    }
}

/**
 * 端口是否存在
 */
function sockalive($ip, $port, $c= true) {
    static $cache = array();
    $ck = $ip. ':' . $port;
    if($c && array_key_exists($ck, $cache)) return $cache[$ck];
    $a = fsockopen($ip, $port, $errno, $errstr, 1.0) ? true : false;    
    if($c) $cache[$ck] = $a;
    return $a;
}
/**
 * 解析一个svn地址，并返回相关信息
 */
function parseurl($uri) {
    $r = array();
    $i = parse_url($uri);
    $r['scheme'] = $i['scheme'];
    $r['host'] = $i['host'];
    $r['port'] = isset($i['port']) ? $i['port'] : scheme2port($r['scheme']);
    return $r;
}
function scheme2port($s) {
    $p = 80;
    switch($s){
        case 'https':
            $p = 443;
            break;
        case 'http':
            $p = 80;
            break;
        case 'svn':
            $p = 3690;
            break;
    }
    return $p;
}
/**
 * 需要去掉多余//
 * 需要改成正则方式
 */
function sync_trim_path($path) {
    return preg_replace('/(?<!:)\/((\.|\s)?\/)+/', '/', $path);
}
