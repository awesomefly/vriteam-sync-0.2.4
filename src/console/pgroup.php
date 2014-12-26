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
function console_pgroup_init() {
    check_admin_user();
    define('CONSOLE_ID', (int)$_REQUEST['id']);
}

/**
    创建项目引导页
 */
function console_pgroup_index() {
    $av = array();

    smt_append_tpl($av, PGROUP_TPL_CREATE);

    smt_append_title($av, PGROUP_TITLE_CREATE);
    return $av;
}
/**
 * 创建，更新项目组
 */
function console_pgroup_create() {
    $av     = array();
    $item   = pgroup_get(CONSOLE_ID);

    smt_append_item($av, $item);
    smt_append_title($av, PGROUP_TITLE_CREATE);
    return $av;
}

/**
 * 创建项目组，提交之后
 */
function console_pgroup_docreate() {
    $av = array();
    //获取数据
    $dt = get_post_dt();
    //验证数据
    $av = val_data($dt);

    if ( err_get() === 0 )
        pgroup_create($dt);

    smt_append_json($av, '');
    smt_append_href($av, PGROUP_ACTION_LIST);

    return $av;
}

/**
 * 项目组列表
 */
function console_pgroup_list() {
    $av = array();
    $page   = ((int)$_REQUEST[INPUT_KEY_PAPE] > 0) ? 
        (int)$_REQUEST[INPUT_KEY_PAPE] : FIRST_PAGE;

    $r = pgroup_list($page, LIST_PER_PAGE, true);
    smt_append_list($av, $r);
    smt_append_page($av, get_page(pgroup_list_count(true)));
    smt_append_title($av, PGROUP_TITLE_LIST);

    return $av;
}

/**
 * 删除项目组
 */
function console_pgroup_delete() {
    $av      = array();

    //判断当前项目组是否在使用中
    $group_used =  group_use(CONSOLE_ID);
    if ( $group_used ) {
        err_set(WARING_CODE);
        msg_set(PGROUP_MESSAGE_GROUP_USED);
    } else 
        pgroup_delete(CONSOLE_ID);

    smt_append_json($av, '');

    return $av;

}
