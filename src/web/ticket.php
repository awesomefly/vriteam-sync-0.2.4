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
 * 模块的初始化函数
 */
function web_ticket_init() {
    $id = 0;
    if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
        $id = $_REQUEST['id'];
    if(!$id) $id = ticket_mine_latest_id();
    define('TICKET_ID', intval($id));
	$max = sync_max_id();
    define('TICKET_NEXT_ID', $max + 1);
}
/**
 * 拼接模板文件
 */
function _web_tpl($tplname) {
    return 'web/' . $tplname . '.tpl';
}

/**
 * 首页
 * ticket_index();
 */
function web_ticket_index() {
    return web_ticket_mine();
}

/**
 * 我的上线单
 * ticket_list_mine
 */
function web_ticket_mine() {
    $page = page();

    $r = ticket_list_mine($page);
    smt_append_list($av, $r);
    smt_append_page($av, get_page(ticket_list_mine_count()));
    smt_append_title($av, '我的上线单');
    smt_append_tpl($av, _web_tpl('ticket_mine'));
    return $av;
}

/**
 * 最新上线单
 * ticket_list_latest
 */
function web_ticket_latest() {
    $page = page();
    $r = ticket_list($page);
    smt_append_list($av, $r);
    smt_append_page($av, get_page(ticket_list_latest_count()));
    smt_append_title($av, '最新上线单');
    return $av;
}

/**
 * 搜索
 * ticket_search
 */
function web_ticket_search() {
    $av = array();
    $page = page();
    if($_REQUEST['stype'] == 'username'){
        $username = $_REQUEST['key'];
        if(!user_exists($username)) $r = array();
        else{
            $r = ticket_list_u($username, $page);
            smt_append_page($av, get_page(ticket_list_count($username)));
        }
    }elseif($_REQUEST['stype'] == 'update' || $_REQUEST['stype'] == 'sync'){
        $bt = $_REQUEST['bt'];
        $et = $_REQUEST['et'];
        $type = $_REQUEST['stype'];
        list($y, $m, $d) = explode('-', $bt);
        $bt = mktime(0, 0, 0, $m, $d, $y);
        list($y, $m, $d) = explode('-', $et);
        $et = mktime(23, 59, 59, $m, $d, $y);

        $r = ticket_list_t($bt, $et, $type, $page);
        smt_append_page($av, get_page(ticket_list_t_count($bt, $et, $type)));
    }else{
        $r = ticket_list($page);
        smt_append_page($av, get_page(ticket_list_latest_count()));
    }
    smt_append_value($av, 'search', 'search');
    smt_append_list($av, $r);
    smt_append_title($av, '搜索');
    return $av;
}
/**
 * 查看上线单
 * ticket_detail
 */
function web_ticket_detail() {
    $av = array();
    #如果没有指定上线单就查看当前用户的最新上线单
    $id = TICKET_ID;
    if($id) $r = ticket_detail($id);
    else smt_append_value($av, '没有找到上线单!', 'msg');
    smt_append_ticket($av, $r);
    smt_append_title($av, '上线单详情');
    return $av;
}

/**
 * 创建上线单
 * ticket_create
 */
function web_ticket_create() {
    $av = array();
    if(!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id'])){
        error_json('etid', $av); return $av;
    }
    $r = ticket_create(TICKET_ID);
    if(!$r) error('exist');
    smt_append_value($av, '/index.php?mod=web.ticket&act=detail&id=' . TICKET_ID, 'href');
    smt_append_json($av, '');
    return $av;
}
/**
 * 判断上线单是否存在上线单
 * ticket_exist
 */
function web_ticket_exist() {
    if(!TICKET_ID) error('etid');
    elseif(!ticket_exist(TICKET_ID)) error('idnoexist');
    smt_append_value($av, '/index.php?mod=web.ticket&act=detail&id=' . TICKET_ID, 'href');
    smt_append_json($av, '');
    return $av;
}

/**
 * 选择脚本文件,首屏
 * ticket_addshell
 */
function web_ticket_addshell() {
    $r = array();
    $r = ticket_select();
    $av = array();
    if(!$r) { error_json('empty_pjgrp', $av); return $av; }
    smt_append_list($av, $r);
    if($gid = _web_ticket_storedpgid()){
        $r = ticket_select_project($gid);
        if($r) smt_append_value($av, $r, 'listse');
    }
    smt_append_json($av);
    return $av;
}

/**
 * 选择文件,首屏
 * ticket_select
 */
function web_ticket_select() {
    $r = array();
    $r = ticket_select();
    $av = array();
    if(!$r) { error_json('empty_pjgrp', $av); return $av; }
    smt_append_list($av, $r);
    if($gid = _web_ticket_storedpgid()){
        $r = ticket_select_project($gid);
        if($r) smt_append_value($av, $r, 'listse');
    }
    smt_append_json($av);
    return $av;
}

/**
 * 选择文件，项目组和项目联动
 * ticket_select_project
 */
function web_ticket_select_project() {
    $r = array();
    $r = ticket_select_project(TICKET_ID);
    $av = array();
    if(!$r) { error_json('empty_pj', $av);return $av;}
    #放到session中,下次直接浏览
    _web_ticket_storegid(TICKET_ID);

    smt_append_list($av, $r);
    smt_append_json($av);
    return $av;
}
function _web_ticket_storegid($pgid) {
    setcookie('pgid', strval($pgid), time() + 60*60*24*365, '/');
}
function _web_ticket_storepn($pname) {
    setcookie('pname', $pname, time() + 60*60*24*365, '/');
}
function _web_ticket_storedpgid() {
    return isset($_COOKIE['pgid']) ? $_COOKIE['pgid'] : null;
}

/**
 * 选择文件，点击浏览按钮之后
 * ticket_browser
 */
function web_ticket_browser() {
    $r = array();
    $av = array();
    $v = isset($_REQUEST['version']) ? $_REQUEST['version'] : 1;
    $pn = isset($_REQUEST['pname']) ? $_REQUEST['pname'] : '';
    $st = isset($_REQUEST['sort']) && $_REQUEST['sort'] === '1' ? true : false;
    if(!is_numeric($v)) { error_json('browser_verson', $av);return $av;}
    if(!sync_project_exists($pn)) { error_json('pname', $av);return $av; }
    _web_ticket_storepn($pn);
    $r = ticket_browser($pn, $v, $st);
    if(!$r) { error_json('no_svn_log', $av); return $av; }
    $r = array(WT_FL => $r, 'browser' => true);
    smt_append_ticket($av, $r);
    smt_append_json($av);
    return $av;
}
/**
 * 选择文件，点击浏览按钮之后单击保存按钮
 * ticket_save
 */
function web_ticket_save() {
    $r = array();
    $fl = $_POST['files'];
    $pn = $_REQUEST['pname'];
    $av = array();
    if(!check_mod_f()){ error_json('nopri', $av); return $av; }
    if(!sync_project_exists($pn)) { error_json('pname', $av); return $av;}
    if(!sync_array($fl)) { error_json('no_fl', $av); return $av;}
    #保存的错误处理放到service里边了
    $r = ticket_save_flist(TICKET_ID, $pn, $fl);
    smt_append_ticket($av, $r);
    smt_append_json($av, _web_tpl('ticket_detail_fls'));
    return $av;
}
/**
 * 单击删除按钮,修改文件列表
 * ticket_delete
 */
function web_ticket_delete() {
    $r = array();
    $keys= $_POST['key'];
    $av = array();
    if(!check_mod_f()){ error_json('nopri', $av); return $av; }
    if(!sync_array($keys)) { error_json('no_fl', $av); return $av;}
    $r = ticket_delete_flist(TICKET_ID, $keys);
    smt_append_ticket($av, $r);
    smt_append_json($av, _web_tpl('ticket_detail_fls'));
    return $av;
}
/**
 * 查看上线单的文件列表
 * ticket_flist
 */
function web_ticket_flist() {
    $r = array();
    $r = ticket_get_flist(TICKET_ID);
    smt_append_ticket($av, $r);
    smt_append_json($av, _web_tpl('ticket_detail_fls'));
    return $av;
}
/**
 * 查看上线单的所有历史记录
 * ticket_history
 */
function web_ticket_history() {
    $r = array();
    $r = ticket_get_history(TICKET_ID);
    smt_append_ticket($av, $r);
    smt_append_json($av, _web_tpl('ticket_detail_his'));
    return $av;
}
/**
 * 查看上线单的所有历史记录
 * ticket_history
 */
function web_ticket_sumary() {
    $r = array();
    $r = ticket_detail(TICKET_ID, false);
    smt_append_ticket($av, $r);
    smt_append_json($av, _web_tpl('ticket_detail_sum'));
    return $av;
}
/**
 * 单击某条历史的时候展示的详情
 * ticket_history_detail
 */
function web_ticket_history_detail() {
    $r = array();
    $hid = $_GET['hid'];
    $ht = sync_history_type($hid);
    $r = ticket_history_detail($hid);
    if($ht == 1){
        smt_append_value($av, $r, 'history');
        smt_append_json($av, _web_tpl('ticket_detail_his_detail'));
    }elseif($ht == 2){#同步或者回滚的展示
        smt_append_ticket($av, array('sync_result' => $r));
        smt_append_json($av, _web_tpl('ticket_detail_sync_his'));
    }else{#导出文件失败的展示
        smt_append_ticket($av, array('sync_result_e' => $r));
        smt_append_json($av, _web_tpl('ticket_detail_sync_his_e'));
    }
    return $av;
}
/**
 * 点击执行脚步之后的弹出层
 * ticket_run
 */
function web_ticket_run() {
	$r = array();
    if(!($ti = ticket_detail(TICKET_ID, false))) { error_json('idnoexist', $av); return $av; }
	$r = ticket_run(TICKET_ID);
    $av = array();
    if(!$r) { error_json('noservers', $av); return $av; }
	smt_append_ticket($av, array('p_list' => $r));
    smt_append_value($av, $ti[WT_ST] ? true : false, 'showrb');
    smt_append_json($av);
    return $av;

}
/**
 * 点击执行按钮之后
 * ticket_run_shell
 */
function web_ticket_run_shell() {
    $r = array();
	$av = array();

    #检查上线单是否存在
    if(!ticket_exist(TICKET_ID)) { error_json('idnoexist', $av); return $av; }

	//$f = isset($_POST['from']) && $_POST['from'] == 'trunk' ? 'trunk' : 'branch' ;
	$f = $_POST['shellpath'];
    $servers = $_POST['servers'];
    $r = ticket_run_shell(TICKET_ID, $servers, $f);
    if($r) smt_append_ticket($av, array('run_shell_result' => $r));
    else{
        #如果出错了
        $sync_result_e = msg_get();
        msg_set('');
        //smt_append_ticket($av, array('sync_result_e' => $sync_result_e));
        //smt_append_tpl($av, _web_tpl('ticket_sync_files_exp_e'));
    }
    smt_append_json($av);
	return $av;
}

/**
 * 点击同步之后的弹出层
 * ticket_sync
 */
function web_ticket_sync() {
    $r = array();
    if(!($ti = ticket_detail(TICKET_ID, false))) { error_json('idnoexist', $av); return $av; }
    $r = ticket_sync(TICKET_ID);
    $av = array();
    if(!$r) { error_json('noservers', $av); return $av; }
    smt_append_ticket($av, array('p_list' => $r));
    smt_append_value($av, $ti[WT_ST] ? true : false, 'showrb');
    smt_append_json($av);
    return $av;
}
/**
 * 点击同步按钮之后
 * ticket_sync_files
 */
function web_ticket_sync_files() {
    $r = array();
    $av = array();
    #检查权限
    if(!check_mod_o()){ error_json('nopri', $av); return $av; }
    elseif(!sync_expdir_e()){ error_json('dirnoe', $av); return $av; }
    elseif(!sync_expdir_w()){ error_json('dirnow', $av); return $av; }
    #检查是否有要同步的服务器
    $servers = $_POST['servers'];
    if(!sync_array($servers)){ error_json('nosrvsltd', $av); return $av; }
    
    #检查上线单是否存在
    if(!ticket_exist(TICKET_ID)) { error_json('idnoexist', $av); return $av; }

    $f = isset($_POST['from']) && $_POST['from'] == 'trunk' ? 'trunk' : 'branch' ;
    $r = ticket_sync_files(TICKET_ID, $servers, $f);
    if($r) smt_append_ticket($av, array('sync_result' => $r));
    else{
        #如果导出文件的时候就出错了
        $sync_result_e = msg_get();
        msg_set('');
        smt_append_ticket($av, array('sync_result_e' => $sync_result_e));
        smt_append_tpl($av, _web_tpl('ticket_sync_files_exp_e'));
    }
    smt_append_json($av);
    return $av;
}
/**
 * 点击回滚之后
 */
function web_ticket_rollback() {
    $r = array();
    $av = array();
    #检查权限
    if(!check_mod_o()){ error_json('nopri', $av); return $av; }
    elseif(!sync_expdir_e()){ error_json('dirnoe', $av); return $av; }
    elseif(!sync_expdir_w()){ error_json('dirnow', $av); return $av; }
    #检查是否有要同步的服务器
    $servers = $_POST['servers'];
    if(!sync_array($servers)){ error_json('nosrvsltd', $av); return $av; }
    #检查上线单是否存在且有同步记录
    if(!($ti = ticket_detail(TICKET_ID, false))) { error_json('idnoexist', $av); return $av; }
    elseif(!$ti[WT_ST]) { error_json('nosync', $av); return $av; }

    $r = ticket_rolback_files(TICKET_ID, $servers);
    if($r) smt_append_ticket($av, array('sync_result' => $r));
    else{
        #如果导出文件的时候就出错了
        $sync_result_e = msg_get();
        msg_set('');
        smt_append_ticket($av, array('sync_result_e' => $sync_result_e));
        smt_append_json($av, _web_tpl('ticket_sync_files_exp_e'));
        return $av;
    }
    smt_append_json($av, _web_tpl('ticket_sync_files'));
    return $av;
}
/**
 * 单击帮助的弹出层
 */
function web_ticket_help() {
    $av = array();
    smt_append_json($av, _web_tpl('ticket_help'));
    return $av;
}
/**
 * 常见问题页面
 */
function web_ticket_faq() {
    $av = array();
    smt_append_tpl($av, _web_tpl('ticket_faq'));
    return $av;
}
