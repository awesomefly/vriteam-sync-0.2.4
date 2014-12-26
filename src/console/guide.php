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
 * 初始化方法
 */
function console_guide_init() {
    check_admin_user();
    define('CONSOLE_ID', (int)$_REQUEST['id']);
}

/**
 * index
 */
function console_guide_index() {
    $av = array();

    smt_append_value($av, GUIDE_ACT_STEP1, GUIDE_KEY_GUIDE_STEP);
    smt_append_title($av, SERVER_TITLE_CREATE);
    if ( !sync_need_guide() )
        smt_append_tpl($av, GUIDE_TPL_STEP1);

    return $av;
}

/**
 * 引导第一步
 */
function console_guide_step1() {
    $av = array();
    $jump = $_REQUEST[GUIDE_KEY_JUMP] ? (string)$_REQUEST[GUIDE_KEY_JUMP] : GUIDE_ACT_STEP2;
    if ( $_POST ) {
        //获取数据 
        $dt = get_post_dt();
        $_SESSION['gd_st1'] = $dt;
        //校验数据
        $av = val_data($dt);
        $_SESSION['gd_st1_i'] = $dt;

        if ( err_get() !== 0 )//数据校验失败
            smt_append_json($av, '');//不渲染模板，json格式返回数据
        else {
            smt_append_href($av, GUIDE_REDIRECT_URL . $jump);
            smt_append_json($av, '');
        }
    }
    smt_append_value($av, GUIDE_ACT_STEP1, GUIDE_KEY_GUIDE_STEP);
    smt_append_title($av, PROJECT_TITLE_CREATE);
    smt_append_value($av, $jump, GUIDE_KEY_JUMP);
    return $av;
}

/**
 * 引导第二步
 */
function console_guide_step2() {
    $av = array();

    $jump = $_REQUEST[GUIDE_KEY_JUMP] ? (string)$_REQUEST[GUIDE_KEY_JUMP] : GUIDE_ACT_STEP3;
    if ( sync_array($_SESSION['gd_st1']) && isset($_SESSION['gd_st1']['pn']) 
        && !(sync_array($_SESSION['gd_st2']) && $_SESSION['gd_st2']['dc']) )
        $_SESSION['gd_st2']['dc'] = $_SESSION['gd_st1']['pn'] . '_svn';
    if ( $_POST ) {
        //获取数据 
        $dt = get_post_dt();
        $_SESSION['gd_st2'] = $dt;
        //校验数据
        $av = val_data($dt);
        $_SESSION['gd_st2_i'] = $dt;
        
        if ( err_get() !== 0 )//数据校验失败
            smt_append_json($av, '');//不渲染模板，json格式返回数据
        else {
            smt_append_href($av, GUIDE_REDIRECT_URL . $jump);
            smt_append_json($av, '');
        }
    }
    smt_append_title($av, SERVER_TITLE_CREATE);
    smt_append_value($av, GUIDE_ACT_STEP2, GUIDE_KEY_GUIDE_STEP);
    smt_append_value($av, $jump, GUIDE_KEY_JUMP);
    return $av;
}

/***
 * 引导第三步
 */
function console_guide_step3() {
    $av = array();

    $jump = $_POST[GUIDE_KEY_JUMP] ? (string)$_POST[GUIDE_KEY_JUMP] : GUIDE_ACT_STEP4;
    if ( sync_array($_SESSION['gd_st1']) && isset($_SESSION['gd_st1']['pn']) 
        && !(sync_array($_SESSION['gd_st3']) && $_SESSION['gd_st3']['dc']) )
        $_SESSION['gd_st3']['dc'] = $_SESSION['gd_st1']['pn'] . '_file';
    if ( $_POST ) {
        //获取数据 
        $dt = get_post_dt();
        $_SESSION['gd_st3'] = $dt;
        //校验数据
        $av = val_data($dt);
        $_SESSION['gd_st3_i'] = $dt;

        if ( err_get() !== 0 )//数据校验失败
            smt_append_json($av, '');//不渲染模板，json格式返回数据
        else {
            smt_append_href($av, GUIDE_REDIRECT_URL . $jump);
            smt_append_json($av, '');
        }
    }
    smt_append_title($av, SERVER_TITLE_CREATE);
    smt_append_value($av, GUIDE_ACT_STEP3, GUIDE_KEY_GUIDE_STEP);
    smt_append_value($av, $jump, GUIDE_KEY_JUMP);
    return $av;
}

/**
 * 引导第四步
 */
function console_guide_step4() {
    if ( $_POST ) {
        $av = array();
        //创建svn服务器
        if ( sync_array($_SESSION['gd_st2_i']) )
            $svn_sid  = server_create($_SESSION['gd_st2_i']);
        //创建文件服务器
        if ( sync_array($_SESSION['gd_st3_i']) )
            $file_sid = server_create($_SESSION['gd_st3_i']);
        //创建项目组
        if ( sync_array($_SESSION['gd_st1_i']) )
            //先根据名字判断是否存在，如果不存在则创建
            $gid     = pgroup_get_create($_SESSION['gd_st1_i']);
        //创建项目
        if  ( $svn_sid  && $file_sid && $gid ) {
            $pdt        = $_SESSION['gd_st1_i'];
            $pdt['gid'] = $gid;
            $pdt['sn']  = $svn_sid;
            $pdt['sf']  = $file_sid;

            project_create($pdt);
        }

        smt_append_href($av, PROJECT_ACTION_LIST);
        smt_append_json($av, '');
    }
    smt_append_value($av, GUIDE_ACT_STEP4, GUIDE_KEY_GUIDE_STEP);
    return $av;
}
