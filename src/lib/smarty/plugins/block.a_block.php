<?php
/* 
    +----------------------------------------------------------------------+ 
    | SYNC_PLATFORM (上线系统)                                             | 
    +----------------------------------------------------------------------+ 
    | Copyright (c) 2013-2015   卓越团队 (http://www.sync.com)             | 
    +----------------------------------------------------------------------+ 
    | a_block                                                              | 
    | 简要说明文件的结构和功能,作者等信息.                                 | 
    +----------------------------------------------------------------------+ 
    | Author: mr.joker<sync@gmail.com>                                     | 
    +----------------------------------------------------------------------+ 
 */ 
function smarty_block_a_block($params, $content, &$smarty, &$repeat){

    $contents   = $params['contents'] ? $params['contents'] : ''; 
    $smarty->assign('href',     $params['href']);
    $smarty->assign('contents', $contents);
    $smarty->assign('class', $params['class']);
    $smarty->assign('name', $params['name']);
    return $content;

}
