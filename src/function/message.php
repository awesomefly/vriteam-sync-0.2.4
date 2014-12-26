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
 * 发布新消息
 */
function message_add($content, $user_id = NULL, $to_user_id = NULL) {
    if ( (int)$to_user_id <= 0 )
        $to_user_id = get_admin_uid();
    $now = time();
    $sql = sprintf("insert into %s (%s, %s, %s, %s) values (%d, %d, %s, %d)", SYNC_MESSAGE_TABLE, MESSAGE_FIELD_USER_ID, MESSAGE_FIELD_TO_USER_ID, MESSAGE_FILED_CONTENT, MESSAGE_FIELD_CREATE_TIME, $user_id, $to_user_id, $content, $now);
    return insert_update_db_by_sql($sql);
}
