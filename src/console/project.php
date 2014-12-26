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
function console_project_init() {
    check_admin_user();
    define('CONSOLE_ID', (int)$_REQUEST['id']);
    _console_project_server_init($av);
}

/**
 * 项目引导页
 */
function console_project_index() {
    $av = array();

    smt_append_tpl($av, PROJECT_TPL_CREATE);

    //初始化服务器列表信息
    _console_project_server_init($av, $item);

    smt_append_title($av, PROJECT_TITLE_CREATE);
    return $av;
}

/**
 * 创建，更新项目
 */
function console_project_create() {
    $av     = array();
    $item   = sync_project_get(CONSOLE_ID);

    //初始化服务器列表信息
    _console_project_server_init($av, $item);
    
    smt_append_title($av, PROJECT_TITLE_CREATE);
    smt_append_item($av, $item);
    return $av;
}

/**
 * 创建，更新项目
 */
function console_project_docreate() {
    $av = array();
    //获取数据
    $dt = get_post_dt();
    //验证数据
    $av = val_data($dt);

    if ( err_get() === 0 ) 
        project_create($dt);

    smt_append_json($av, '');
    smt_append_href($av, PROJECT_ACTION_LIST);

    return $av;
}

/**
 * 项目列表
 */
function console_project_list() {
    $av = array();
    $page   = ((int)$_REQUEST[INPUT_KEY_PAPE] > 0) ? 
        (int)$_REQUEST[INPUT_KEY_PAPE] : FIRST_PAGE;

    $r = project_lists($page, LIST_PER_PAGE);

    smt_append_list($av, $r);
    smt_append_page($av, get_page(project_list_count()));
    smt_append_title($av, PROJECT_TITLE_LIST);

    return $av;
}

/**
 * 项目删除
 */
function console_project_delete() {
    $av = array();

    project_del(CONSOLE_ID);
    smt_append_json($av, '');

    return $av;
}

/**
 * 初始化服务器列表信息，内部函数
 */
function _console_project_server_init(&$av, $it = NULL) {
    $sn = server_svn_lists();//所有svn服务器
    $sf = server_file_lists();//所有文件服务器
    $gl = get_pgroup_lists();//所有项目组 

    if ( $it !== NULL && sync_array($it) && sync_array($sf))  {
        $pf_list = explode(",", $it[DB_PROJECTS_SERVERS]);
        foreach ( $sf as $k => &$v ) {
            if ( in_array($v['id'], $pf_list) ) 
                $v['checked'] = true;
        }
    }

    smt_append_value($av, $sn, PROJECT_KEY_SERVER_SVN_LIST);
    smt_append_value($av, $sf, PROJECT_KEY_SERVER_FILE_LIST);
    smt_append_value($av, $gl, PROJECT_KEY_PORJECT_GROUP_LIST);
}
