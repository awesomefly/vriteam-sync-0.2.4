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
/*
 * 引导页面配置
 */
#步骤定义
define('GUIDE_ACT_STEP1',                   'step1');
define('GUIDE_ACT_STEP2',                   'step2');
define('GUIDE_ACT_STEP3',                   'step3');
define('GUIDE_ACT_STEP4',                   'step4');
define('GUIDE_ACT_DEFAULT',                 GUIDE_ACT_STEP1);
define('GUIDE_KEY_GUIDE_STEP',              'guide_step');
define('GUIDE_KEY_JUMP',                    'jump');
define('GUIDE_TPL_STEP1',                   'console/guide_step1.tpl');

#跳转地址定义
define('GUIDE_REDIRECT_GUIDE',              './index.php?mod=console.guide');
define('GUIDE_REDIRECT_URL',                GUIDE_REDIRECT_GUIDE . '&act=');
define('GUIDE_REDIRECT_STEP1',              GUIDE_REDIRECT_URL . GUIDE_ACT_STEP1);
define('GUIDE_REDIRECT_STEP2',              GUIDE_REDIRECT_URL . GUIDE_ACT_STEP2);
define('GUIDE_REDIRECT_STEP3',              GUIDE_REDIRECT_URL . GUIDE_ACT_STEP3);
define('GUIDE_REDIRECT_STEP4',              GUIDE_REDIRECT_URL . GUIDE_ACT_STEP4);
