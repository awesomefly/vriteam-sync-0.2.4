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
function console_user_init() {
    check_admin_user();
    define('CONSOLE_ID', (int)$_REQUEST['id']);
}

/**
 * 用户引导页
 */
function console_user_index() {
    $av = array();

    smt_append_tpl($av, USER_TPL_CREATE);

    smt_append_title($av, USER_TITLE_CREATE);
    return $av;
}

/**
 * 创建，修改用户信息
 */
function console_user_create() {
    $av = array();

    $item   = sync_user_get(CONSOLE_ID);
    smt_append_item($av, $item);
    smt_append_title($av, USER_TITLE_CREATE);

    return $av;
}

/**
 * 创建用户，提交之后
 */
function console_user_docreate() {
    $av = array();

    //获取数据
    $dt = get_post_dt();
    //验证数据
    $av = val_data($dt);

    if ( err_get() === 0 ) 
        user_create($dt);

    smt_append_json($av, '');//不渲染模板，json格式返回数据
    smt_append_href($av, USER_ACTION_LIST);

    return $av;
}

/**
 * 用户列表
 */
function console_user_list() {
    $page = ((int)$_REQUEST[INPUT_KEY_PAPE] > 0) ? 
        (int)$_REQUEST[INPUT_KEY_PAPE] : FIRST_PAGE;

    $r = user_lists($page, LIST_PER_PAGE);
    tidy_users_mod($r);
    smt_append_list($av, $r);
    smt_append_page($av, get_page(user_list_count()));
    smt_append_title($av, USER_TITLE_LIST);

    return $av;
}

/**
 * 用户删除
 */
function console_user_delete() {
    $av = array();
    user_del(CONSOLE_ID);

    smt_append_json($av, '');

    return $av;
}
