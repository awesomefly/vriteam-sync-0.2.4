<?php 
/**
 * 初始化方法
 */
function console_server_init() {
    check_admin_user();
    define('CONSOLE_ID', (int)$_REQUEST['id']);
}

/**
 * 后台引导页
 */
function console_server_index() {
    $av = array();
    smt_append_tpl($av, SERVER_TPL_CREATE);

    smt_append_title($av, SERVER_TITLE_CREATE);
    return $av;
}

/**
 * 创建，更新服务器
 */
function console_server_create() {
    $av = array();
    $item = sync_format_server_info(CONSOLE_ID);
    smt_append_item($av, $item);

    smt_append_title($av, SERVER_TITLE_CREATE);
    return $av;
}

/**
 * 创建服务器，提交之后
 */
function console_server_docreate() {
    $av = array();

    //获取数据
    $dt = get_post_dt();
    //验证数据
    $av = val_data($dt);

    if ( err_get() === 0 ) server_create($dt);

    smt_append_json($av, '');//不渲染模板，json格式返回数据
    smt_append_href($av, SERVER_ACTION_LIST);

    return $av;

}

/**
 * 服务器列表
 */
function console_server_list() {
    $av = array();

    $page = ((int)$_REQUEST[INPUT_KEY_PAPE] > 0) ? 
        (int)$_REQUEST[INPUT_KEY_PAPE] : FIRST_PAGE;

    $r = console_server_lists($page, LIST_PER_PAGE);
    smt_append_list($av, $r);
    smt_append_page($av, get_page(server_list_count()));

    smt_append_title($av, SERVER_TITLE_LIST);
    return $av;
}

/**
 * 删除服务器
 */
function console_server_delete() {
    $av     = array();

    //如果有关联项目那么不允许删除
    $server_used = server_use(CONSOLE_ID); 
    if ( $server_used ) {
        err_set(WARING_CODE);
        msg_set(SERVER_MESSAGE_SERVER_USED);
    } else 
        server_del(CONSOLE_ID);

    smt_append_json($av, '');

    return $av;
}
