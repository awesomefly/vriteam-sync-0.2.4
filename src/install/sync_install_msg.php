<?php
if ( !defined('SYNC_INSTALLED') ) exit ('Access Denied');

$sync_msg = array();
$sync_msg['install_locked']     = '您已安装过SYNC上线系统' . SYNC_CURR_VERSION . '，如果需要重新安装，请先删除install目录下的install.lock文件';
$sync_msg['init_dbfile_err']    = '数据库文件无法读取，请检查/install/sync.sql是否存在。';
$sync_msg['install_title']      = 'SYNC上线系统 ' . SYNC_CURR_VERSION . ' 安装向导';
$sync_msg['install_wizard']     = '安装向导';
$sync_msg['install_start']      = '开始安装SYNC上线系统';
$sync_msg['license_title']      = '安装许可协议';
$sync_msg['install_agree']      = '我已看过并同意安装许可协议';
$sync_msg['install_disagree']   = '不同意';
$sync_msg['disagree_license']   = '您必须在同意授权协议的全部条件后，方可继续SYNC的安装';
$sync_msg['install_prev']       = '上一步';
$sync_msg['install_next']       = '下一步';
$sync_msg['sync_dirmod']        = '目录和文件的写权限';
$sync_msg['sync_refresh_page']  = '<p>若以上几个目录是非可写模式，修改之后请按F5刷新页面之后再点下一步</p>';
$sync_msg['install_env']        = '服务器配置';
$sync_msg['sync_pc_os']         = '操作系统';
$sync_msg['php_version']        = 'PHP版本';
$sync_msg['sync_support']       = '支持';
$sync_msg['php_extention']      = 'PHP扩展';
$sync_msg['unload_mysql_ext']   = '您的服务器没有安装这个PHP扩展：mysql';
$sync_msg['unload_svn_ext']     = '您的服务器没有安装这个PHP扩展：svn';
$sync_msg['unload_ssh2_ext']    = '您的服务器没有安装这个PHP扩展：ssh2';
$sync_msg['sync_mysql']         = 'MySQL数据库';
$sync_msg['mysql_unsupport']    = '您的服务器不支持MYSQL数据库，无法安装SYNC上线系统。';
$sync_msg['install_setting']    = '数据库与管理员帐号设置';
$sync_msg['install_mysql']      = '数据库配置';
$sync_msg['install_mysql_host'] = '数据库服务器';
$sync_msg['mysql_host_intro']   = '格式：地址(:端口)，一般为 localhost';
$sync_msg['mysql_username']     = '数据库用户名';
$sync_msg['mysql_password']     = '数据库密码';
$sync_msg['sync_mysql_name']    = '数据库名';
$sync_msg['sync_admin']         = '管理员资料';
$sync_msg['sync_admin_name']    = '管理员帐号';
$sync_msg['sync_admin_pass']    = '管理员密码';
$sync_msg['sync_admin_repass']  = '重复密码';
$sync_msg['sync_username']      = '用户名';
$sync_msg['mysql_host_empty']   = '数据库服务器不能为空';
$sync_msg['mysql_uname_empty']  = '数据库用户名不能为空';
$sync_msg['mysql_dbname_empty'] = '数据库名不能为空';
$sync_msg['dbconnect_failed']   = '连接数据库失败，无法进入下一步，请检查所填信息的正确性';
$sync_msg['dbuser_noprivilege'] = '您所用的账号无法创建数据，请检查权限是否正确！';
$sync_msg['admin_pass_length']  = '管理员密码必须大于6位';
$sync_msg['admin_repass_error'] = '两次输入管理员密码不同';
$sync_msg['mysql_invalid']      = '数据库配置信息不完整';
$sync_msg['db_config_write']    = '数据库配置信息写入完成';
$sync_msg['config_read_failed'] = '数据库配置文件写入失败，请修改根目录下的' . SYNC_DB_CONF_FILE_NAME . '可写';
$sync_msg['sync_error']         = '错误信息：';
$sync_msg['database_errno']     = '程序在执行数据库操作时发生了一个错误，安装过程无法继续进行。';
$sync_msg['db_config_failed']   = '数据库配置失败';
$sync_msg['sync_rebuild']       = '数据库中已经安装过 SYNC上线系统，继续安装会清空原有数据！';
$sync_msg['sync_has_exist']     = '系统检测到名为：' . $_SESSION['sync_db_info']['db_name'] . ' 的数据库上线系统已经存在，请返回<a class="reset_setup" href="' . SYNC_FORM_ACSTEP_THREE . '">第三步</a>修改数据库名，若不需修改请点击下一步';
$sync_msg['sync_db_nouse']      = '数据库：' . $_SESSION['sync_db_info']['db_name'] .' 可用<br />' ;
$sync_msg['import_db_data']     = '点击下一步开始导入数据';
$sync_msg['import_processing']  = '导入数据库';
$sync_msg['create_db_table']    = '创建表';
$sync_msg['create_admin_user']  = '创建管理员帐户';
$sync_msg['create_admin_succ']  = '管理员帐户创建成功';
$sync_msg['create_admin_err']    = '超级管理员帐户创建失败';
$sync_msg['install_success']    = '安装成功';
$sync_msg['install_retry']      = '<a href="./" class="btn Mar0 btnWid">请重新安装</a>';
$sync_msg['install_succ_intro'] = '安装程序执行完毕，请尽快删除整个 install 目录，以免被他人恶意利用。如要重新安装，请删除本目录的 install.lock 文件！';
$sync_msg['install_warning']    = '<strong>注意 </strong>这个安装程序会帮助你初始化SYNC上线系统，如果你已经在使用 SYNC上线系统 或者要更新到一个新版本，请谨慎填写第三步中的数据库名称，以免覆盖原有数据！';
$sync_msg['install_intro']      = '<h3>安装须知</h3><p>一、运行环境需求：PHP(5.3+)+MYSQL(任意版本)+非win系统</p><p>二、安装步骤：<br />1、使用ftp工具以二进制模式，将该软件包里的 src 目录及其文件上传到您的空间，假设目录是sync。<br />2、先确认以下目录或文件属性为 (777) 可写模式。<br />目录: ' . SYNC_ROOT . 'tmp<br />目录: ' . SYNC_ROOT . 'data<br />目录: ' . SYNC_ROOT . 'install<br />文件: ' . SYNC_ROOT . 'db.cfg.php<br />3、运行 http://yourwebsite/install/ 安装程序，填入安装相关信息与资料，完成安装！<br />4、运行 http://yourwebsite/index.php 开始体验SYNC上线系统！</p>';
$sync_msg['install_license']    = '版权所有 (C) 2013，vriteam.com 保留所有权利。

Sync是由vriteam项目组独立开发的一套专门用于php项目的上线系统，基于PHP脚本和MySQL数据库以及php的svn和ssh2扩展。本程序源码是开放的，任何人都可以从互联网上免费下载，并可以在不违反本协议规定的前提下进行使用而无需缴纳程序使用费。

官方网址： www.vriteam.com

为了使你正确并合法的使用本软件，请你在使用前务必阅读清楚下面的协议条款：

-------------------------------------------------------------------- 
                  上线系统 0.2.4 授权协议
版权所有 (c) 2013 VRITEAM团队. 保留所有权利
-------------------------------------------------------------------- 

本协议是你与VRITEAM团队之间关于使用上线系统的法律协议。
无论你是个人或组织、盈利与否、用途如何（包括以学习和研究为目的），
均需仔细阅读本协议，包括免除或者限制责任的免责条款及对你的权利限制。
请你审阅并接受或不接受本服务条款。如你不同意本服务条款，
你不应使用上线系统。否则，我们认为你默认了本协议条款。
本服务条款一旦发生变更, 我们将在网页上公布修改内容。
修改后的服务条款一旦在网站管理后台上公布即有效代替原来的服务条款。
你可随时登陆VRITEAM官方网站查阅最新版服务条款。
如果你选择接受本条款，即表示你同意接受协议各项条件的约束。
如果你不同意本服务条款，则不能获得使用本服务的权利。
你若有违反本条款规定，VRITEAM团队则有权随时中止或终止
你对上线系统的使用资格并保留追究相关法律责任的权利。
在理解、同意、并遵守本协议的全部条款后，方可开始使用上线系统。

VRITEAM团队拥有本软件的全部知识产权。本软件只供许可协议，并非出售。
VRITEAM团队只允许你在遵守本协议各项条款的情况下复制、下载、安装、
使用或者以其他方式受益于本软件的功能或者知识产权。

I. 协议许可权利
1. 你可以在完全遵守本许可协议的基础上，将本软件应用于非商业用途，而不必支付软件版权许可费用。
2. 你可以在协议规定的约束和限制范围内修改上线系统源代码(如果被提供的话)或界面风格以适应你的需要。
3. 若你需将上线系统用于商业用途，必须另行获得VRITEAM团队的书面许可，
你在获得商业授权之后，才可以将本软件应用于商业用途。

II. 协议规定的约束和限制

1. 未获得VRITEAM团队书面商业授权之前，不得将本软件用于商业用途。
购买商业授权请登陆http://www.vriteam.com。
2. 不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。
3. 你可以修改本软件使之更适合你的系统，但是禁制修改系统的LOGO和软件著作权的声明等。
4. 禁止在上线系统的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。
5. 如果你未能遵守本协议的条款，你的授权将被终止，所许可的权利将被收回，同时你应承担相应法律责任。

III. 免责声明

1. 本软件是免费软件，VRITEAM团队对程序没有担保。
除非另有书面说明，否则VRITEAM团队不提供任何类型的担保。不论是明确的，还是隐含的。
若由于使用该软件带来的全部风险，如程序的质量和性能问题等都由你来承担。
如果程序出现缺陷，你承担所有必要的服务，修复和改正的费用。

本许可协议条款的解释，效力及纠纷的解决，适用于中华人民共和国法律。

VRITEAM团队
';
$tips_arr = array(
    '用svn log b.php | more命令可以查看b.php这个文件的svn修改历史',
    '用svn log b.php --limit 1可以查看b.php这个文件的svn最新版本',
    '用svn merge -c xxx,其中xxx为版本号，等同于svn merge -r xxx-1:xxxx',
    '用svn merge -r xxx:xxxx-1,可以将某版本的修改回滚',
    '一件事当别人做不到的时候，他就会告诉你这件事很难，可能你也做不到',
    '一个成熟的团队，缺了谁都不行，缺了谁都行',
    '当你做一件事的时候，一开始的态度已经决定了最后的结果',
    '当你选错了一个人的时候，他可能给你带来一群人，这个人的位置越高，伤害就越大',
    '坦诚对一个团队来说特别重要，你不会的东西要勇于告诉别人，并且探寻答案',
    '没有永远的敌人，做什么事都要站在对方的角度上去考虑一下，给别人留一些余地',
    '强者适应环境，更强者改变环境',
    '工作中我们要减少抱怨，学会在逆境中去想办法改变环境，不能把别人的不给力当做自己松懈的理由',
    '知行合一，在工作中我们要不断的去调节自己的方法和思路，不能认为自己一直是正确的',
    '面对同样的困难，你的态度会让你有不同的感受，你高兴的去面对它，你会发现它很容易解决，关键是你首先得有这个勇气',
    '如果你是一个团队的领袖，请把大家紧紧的团结在你的周围',
    '如果你选择了卓越，那么就坚持日行20英里吧',
    '水滴石穿，蚁溃蚁穴，一个小问题如果你不解决，它会越滚越大，正如你的代码',
    '你做一件事之前的态度，已经决定了最终的质量',
    '有些事不是你做不到，而只是你没有足够的勇气认为自己能做到',
    '有些事你能想到，但是你未必能做到',
    '团队内部定期review代码，对每个人都会有不同程度的提升',
    '分享是一个团队很好的文化，学会分享，首先得有颗包容的心',
    '一个好的团队，每个成员既是战友又是朋友，彼此之间是有感情的',
    '做什么事都要以人为本，要照顾别人的感受，这样事情会更顺利',
    '学会在重复的工作中创新',
    'stay hungry stay foolish. --- Steve Jobs',
    'Unlike in the life out of school after a semester of the same school hours, nor that the summer. No boss to help you find some self-and you must rely on its own to complete. --- Bill Gates',
    '如果你是个正在打造漂亮衣柜的木匠，你不会在背面使用胶合板，即使它冲着墙壁，没有人会看见。但你自己心知肚明，所以你依然会在背面使用一块漂亮的木料。为了能在晚上睡个安稳觉，美观和质量必须贯穿始终。--- Steve Jobs',
	'你可能会忘记和你一起笑过的人，但是却永远不会忘记和你一起哭过的。',
);
