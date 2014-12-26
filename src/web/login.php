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
 * 用户登陆
 */
function web_login_index() {
    $av[LOGIN_KEY_SHOW_TIP]   = get_one_tips();
    smt_append_title($av, '登录');
    return $av;
}

/**
 * 用户登陆动作
 */
function web_login_ex() {
    $av = array();
    $username = (string)$_REQUEST[USER_INPUT_USERNAME];
    $password = (string)$_REQUEST[USER_INPUT_PASSWORD];
    if(!$username || !$password){
        error_json('empty', $av);
        return $av;
    }
    $expire = web_login_expire();
    //用户不存在
    if ( !user_exists($username) ) {
        error_json('nouser', $av);
        return $av;
    }

    //判断用户登陆信息是否正确
    $ret = check_usermod($username, $password);
    if (!$ret) {
        error_json('wrongpwd', $av);
        return $av;
    }
    $ui = user_info($username);
    //设置用户登录信息
    sign_logined($ui, $expire);
    smt_append_href($av, '/index.php');
    if ( $username == USER_ADMIN_NAME ) {//如果是管理员判断是否走引导流程
        if ( sync_need_guide() )
            smt_append_href($av, GUIDE_REDIRECT_GUIDE);
    }
    smt_append_json($av, '');
    return $av;
}

/**
 * 用户退出
 */
function web_login_out() {
    logout();
    redirect(SYNC_OS_URL_NAME);
    exit;
}
function web_login_expire() {
    //记录登录状态有效期
    $remember_me = $_REQUEST[LOGIN_INPUT_REMEMBER_ME];
    if ( $remember_me == LOGIN_REMEMBER_ME_TRUE ) {
        $remember_days = $_REQUEST[LOGIN_INPUT_REMEMBER_DAYS];
        $expire = $remember_days * 24 * 3600;
    } else {
        $expire = NULL;
    }
    return $expire;
}
