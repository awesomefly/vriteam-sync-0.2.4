<?php
/*
 * SYNC 安装文件
 * auth @joker
 * create date 2013-06-10
 */
error_reporting(0);
session_start();
require_once('./install.config.php');
require_once(SYNC_INSTALL_DIR . 'sync_install_fun.php');
require_once(SYNC_INSTALL_DIR . 'sync_install_msg.php');
header('Content-Type: text/html; charset=utf-8');
if ( file_exists(SYNC_LOCKED_FILE) )
    sync_output_exit('install_locked');
//判断sql文件是否存在并且可读
if ( !is_readable(SYNC_SQL_FILE) )
    sync_output_exit('init_dbfile_err');
//处理post和get数据
sync_treate_pgdt();
@extract($_POST);
@extract($_GET);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php sync_output('install_title'); ?></title>
<link rel="shortcut icon" href="/static/core/img/favicon.ico"> 
<link rel="stylesheet" type="text/css" href="/static/core/css/common.css" />
<link rel="stylesheet" type="text/css" href="/static/installation/css/installation.css">
<link rel="stylesheet" type="text/css" href="../static/core/js/icard/css/jquery.icard.css" />
</head>

<body> 
<div class="wrap">
    <div class="inContent">
        <div class="round_top"></div>
        <div class="round_content">
            <h2><?php sync_output('SYNC' . SYNC_CURR_VERSION . ' ' . sync_retstr('install_wizard')); ?></h2>
            <?php 
            if ( !$step ) {//进入引导简介页?>
                <div class="notice"><?php sync_output('install_warning');?></div>
                <?php sync_output('install_intro');?>
			    <a href="<?php sync_output(SYNC_FORM_ACSTEP_ONE);?>" class="btn"><?php sync_output('install_start');?></a>
            <?php
            } else {
            ?>
            <div class="dottedLine"></div>
            <div class="steps">
                <span<?php if ( $step == SYNC_INSTALL_STEP_ONE ) { ?> class="Cur" <?php } ?>>1</span>
                <span<?php if ( $step == SYNC_INSTALL_STEP_TWO ) { ?> class="Cur" <?php } ?>>2</span>
                <span<?php if ( $step == SYNC_INSTALL_STEP_THREE ) { ?> class="Cur" <?php } ?>>3</span>
                <span<?php if ( $step == SYNC_INSTALL_STEP_FOUR ) { ?> class="Cur" <?php } ?>>4</span>
                <span<?php if ( $step == SYNC_INSTALL_STEP_FIVE ) { ?> class="Cur" <?php } ?>>5</span>
                <span<?php if ( $step == SYNC_INSTALL_STEP_SIX ) { ?> class="Cur" <?php } ?>>6</span>
            </div>
            <?php if ( $step == SYNC_INSTALL_STEP_ONE ) {//引导第一步
            ?>
            <h3><?php sync_output('license_title');?></h3>
            <div class="agreement">
                <textarea readonly="readonly" cols="50"><?php sync_output('install_license');?></textarea>
            </div>
            <form action="<?php sync_output(SYNC_FORM_ACSTEP_TWO);?>" method="post">
            <p><label><input type="checkbox" name="agree" value="1" onClick="if(this.checked==true){document.getElementById('nextStep').href='<?php sync_output(SYNC_FORM_ACSTEP_TWO);?>'}else{document.getElementById('nextStep').href='javascript:void(0);'}" checked="checked" /> <?php sync_output('install_agree');?></label></p>
			<p class="for clearfix"><a href="<?php sync_output(SYNC_FORM_ACSTEP_TWO);?>" id="nextStep" class="nextStep btn">下一步</a></p>
            </form>
            <?php
            } 
            ?>
            <?php if ($step == SYNC_INSTALL_STEP_TWO) {//引导第二步
                $write_dirs = array();
                if ( sync_array($check_write_dirs) ) {
                    foreach ($check_write_dirs as $key => $dir) {
                        if ( sync_is_writable($dir) ) $write_dirs[$key] = SYNC_ROOT . $dir . sync_succ_ret();
                        else $write_dirs[$key] = SYNC_ROOT . $dir . sync_fail_ret($quit);
                    }
                }
            ?>
            <div class="layered">
                <h4><?php sync_output('install_env');?></h4>
                <h5><?php sync_output('sync_pc_os');?></h5>
                <p><?php sync_succ_out(PHP_OS);?></p>
                <h5><?php sync_output('php_version');?></h5>
                <p>
                <?php
                sync_output(PHP_VERSION);
                if (PHP_VERSION < '5.3.0') 
                    sync_fail_out($quit);
                else 
                    sync_succ_out();
                ?>
                </p>
                <h5><?php sync_output('php_extention');?></h5>
                <p>
                <?php
                if (extension_loaded('mysql')) 
                    sync_succ_out('mysql:' . sync_retstr('sync_support'));
                else
                    sync_fail_out($quit, '<span class="red">' . sync_retstr('unload_mysql_ext') . '</span>');
                ?>
                </p>
                <p>
                <?php
                    if (extension_loaded('svn'))
                        sync_succ_out('svn:' . sync_retstr('sync_support'));
                    else
                        sync_fail_out($quit, '<span class="red">' . sync_retstr('unload_svn_ext') . '</span>');
                ?>
                </p>
                <p>
                <?php
                if (extension_loaded('ssh2'))
                    sync_succ_out('ssh2:' . sync_retstr('sync_support'));
                else
                    sync_fail_out($quit, '<span class="red">' . sync_retstr('unload_ssh2_ext') . '</span>');
                ?>
                </p>
                <h5><?php sync_output('sync_mysql');?></h5>
                <p>
                <?php
                if (function_exists('mysql_connect'))
                    sync_succ_out('sync_support');
                else
                    sync_fail_out($quit, '<span class="red">' . sync_retstr('mysql_unsupport') . '</span>');
                ?>
                </p>
            </div>
            <div class="layered">
                <h4 style="margin-bottom:5px;"><?php sync_output('sync_dirmod');?></h4>
                <?php
                foreach ($write_dirs as $out_msg)
                sync_output('<p>' . $out_msg . '</p>');
                if ( file_exists(SYNC_DB_CONF_FILE) ) {
                    if ( !is_writable(SYNC_DB_CONF_FILE) )
                        sync_output('<p>' . sync_fail_ret($quit, SYNC_ROOT . SYNC_DB_CONF_FILE_NAME) . '</p>');
                    else
                        sync_output('<p>' . sync_succ_ret(SYNC_ROOT . SYNC_DB_CONF_FILE_NAME) . '</p>');
                }
                sync_output('sync_refresh_page');
                ?>
			</div>
			<form method="post">
				<p class="for clearfix"><a href="<?php sync_output(SYNC_FORM_ACSTEP_THREE);?>" <?php if($quit) echo "onclick='return false'";?> class="nextStep btn">下一步</a></p>
			</form>
            <?php } ?>
            <?php if ($step == SYNC_INSTALL_STEP_THREE) {//引导第三步
            ?>
            <form method="post" action="<?php sync_output(SYNC_FORM_ACSTEP_FOUR);?>" id="step4_form">
            <div class="layered">
                <h4><?php sync_output('install_mysql');?></h4>
                <h5><?php sync_output('install_mysql_host');?></h5>
                <p><?php sync_output('mysql_host_intro');?></p>
                <p class="clearfix"><input type="text" name="db_host" class="span1" id="db_host" value="<?php sync_output($_SESSION['sync_db_info']['db_host'] ? $_SESSION['sync_db_info']['db_host'] : SYNC_DEFAULT_DBHOST);?>" size="40" /></p>
                <h5><?php sync_output('mysql_username');?></h5>
                <p class="clearfix"><input type="text" name="db_username" class="span1" id="db_username" value="<?php sync_output($_SESSION['sync_db_info']['db_username'] ? $_SESSION['sync_db_info']['db_username'] : SYNC_DEFAULT_DBUSER);?>" size="40" /></p>
                <h5><?php sync_output('mysql_password');?></h5>
                <p class="clearfix"><input type="password" name="db_password" class="span1" id="db_password" value="<?php sync_output($_SESSION['sync_db_info']['db_password'] ? $_SESSION['sync_db_info']['db_password'] : '');?>" size="40" /></p>

                <h5><?php  sync_output('sync_mysql_name');?></h5>
                <p class="clearfix"><input type="text" name="db_name" class="span1" id="db_name" value="<?php sync_output($_SESSION['sync_db_info']['db_name'] ? $_SESSION['sync_db_info']['db_name'] : SYNC_DEFAULT_DBNAME);?>" size="40" />
</p>
            </div>
            <div class="layered">
                <h4 style="margin-bottom:5px;"><?php sync_output('sync_admin');?></h4>
                <h5><?php sync_output('sync_username');?></h5>
                <p class="clearfix"><input type="text" name="username" class="span1" value="<?php sync_output(SYNC_ADMIN_UNAME);?>" disabled=\"disabled\" size="40" />　(不可改)</p>

                <h5><?php sync_output('sync_admin_pass');?></h5>
                <p class="clearfix"><input type="text" name="password" class="span1" id="password" value="<?php sync_output($_SESSION['sync_amdin_info']['password'] ? $_SESSION['sync_amdin_info']['password'] : '');?>" size="40" /></p>

                <h5><?php sync_output('sync_admin_repass');?></h5>
                <p class="clearfix"><input type="text" name="rpassword" class="span1" id="rpassword" value="<?php sync_output($_SESSION['sync_amdin_info']['password'] ? $_SESSION['sync_amdin_info']['password'] : '');?>"/></p>
			</div>
				<p class="for clearfix"><a href="<?php sync_output(SYNC_FORM_ACSTEP_TWO);?>" class="btn">上一步</a><a href="javascript:void();" onclick="return check()" class="btn">下一步</a></p>
			</form>
                <script type="text/javascript" language="javascript">
                function check() {
                    if ( !document.getElementById('db_host').value ) {
                        alert('<?php sync_output('mysql_host_empty');?>');
                        document.getElementById('db_host').focus();
                        return false;
                    } else if (!document.getElementById('db_username').value) {
                        alert('<?php sync_output('mysql_uname_empty');?>');
                        document.getElementById('db_username').focus();
                        return false;
                    } else if (!document.getElementById('db_name').value) {
                        alert('<?php sync_output('mysql_dbname_empty');?>');
                        document.getElementById('db_name').focus();
                        return false;
                    } else if (document.getElementById('password').value.length < <?php sync_output(SYNC_PASS_MIN_LENGTH) ?>) {
                        alert('<?php sync_output('admin_pass_length');?>');
                        document.getElementById('password').focus();
                        return false;
                    } else if (document.getElementById('password').value != document.getElementById('rpassword').value) {
                        alert('<?php sync_output('admin_repass_error');?>');
                        document.getElementById('rpassword').focus();
                        return false;
                    }
                    document.getElementById('step4_form').submit();
                    return true;
                }
                </script>
            <?php } ?>
            <?php if ($step == SYNC_INSTALL_STEP_FOUR) {//引导第四步
                $db_host        = $db_host ? $db_host : $_SESSION['sync_db_info']['db_host'];
                $db_username    = $db_username ? $db_username : $_SESSION['sync_db_info']['db_username'];
                $db_password    = $db_password ? $db_password : $_SESSION['sync_db_info']['db_password'];
                $db_name        = $db_name ? $db_name : $_SESSION['sync_db_info']['db_name'];
                $password       = $password ? $password : $_SESSION['sync_amdin_info']['password'];
                $rpassword      = $rpassword ? $rpassword : $_SESSION['sync_amdin_info']['password'];
                //将配置信息写入数据库，到后面页面使用
                $_SESSION['sync_db_info']['db_host']        =    $db_host;
                $_SESSION['sync_db_info']['db_name']        =    $db_name;
                $_SESSION['sync_db_info']['db_username']    =    $db_username;
                $_SESSION['sync_db_info']['db_password']    =    $db_password;
                $_SESSION['sync_db_info']['db_charset']     =    SYNC_DB_CHARSET;
                $_SESSION['sync_amdin_info']['password']    =    $password;
                if( empty($db_host) || empty($db_username) || empty($db_name) ) {
                    $msg .= '<p>'.$sync_msg['mysql_invalid'].'<p>';
                    $quit = TRUE;
                } else if ( !@mysql_connect($db_host, $db_username, $db_password) ) {
                    $msg .= '<p>'.mysql_error().'</p>';
                    $quit = TRUE;
                }
                $db_connect = db_connect($db_host, $db_username, $db_password);
                if ( $db_connect )
                    $db_create  = check_create_db($db_host, $db_username, $db_password, $db_name, SYNC_DB_CHARSET);
                if ( strlen($password) < SYNC_PASS_MIN_LENGTH ) {
                    $msg .= '<p>'.$sync_msg['admin_pass_length'].'</p>';
                    $quit = TRUE;
                } else if ($password != $rpassword) {
                    $msg .= '<p>'.$sync_msg['admin_repass_error'].'</p>';
                    $quit = TRUE;
                } else if ( !$db_connect ) {
                    $msg .= '<p>'.$sync_msg['dbconnect_failed'].'</p>';
                    $quit = TRUE;
                } else if ( !$db_create ) {//检查当前用户是否有创建数据库的权限
                    $msg .= '<p>'.$sync_msg['dbuser_noprivilege'].'</p>';
                    $quit = TRUE;
                }
                if ( $quit ) {
                    $allownext = "onclick = 'return false'";
                ?>
                    <div class="error"><?php sync_output('sync_error');?></div>
                <?php
                    sync_output($msg);
                }
            ?>
            <div class="info">
                <p><?php sync_output(sync_retstr('sync_admin_name') . ': ' . SYNC_ADMIN_UNAME);?></p>
                <p><?php sync_output(sync_retstr('sync_admin_pass') . ': ' . $password);?></p>
                <?php
                //写配置文件
                if ( $db_create ) {
                    $fp = fopen(SYNC_DB_CONF_FILE, 'w+');
                    $db_config_cont = <<<EOT
<?php
/**
 * sync上线系统数据库配置文件
 */\n
EOT;
                    $db_config_cont .= 
                        '$' . "_MYSQL_INFO = array(\n";
                    $db_config_cont .= <<<EOT
                    'host'      => '$db_host',
                    'username'  => '$db_username',
                    'password'  => '$db_password',
                    'db'        => '$db_name',
                    'charset'   =>'utf8'
                    );
EOT;
                    chmod(SYNC_DB_CONF_FILE, SYNC_RX_FILEMOD);
                    $write_ret    =    fwrite($fp, trim($db_config_cont));
                    @fclose($fp);
                if( $write_ret && file_exists(SYNC_DB_CONF_FILE) ) {
                ?>
                <p><?php sync_output('db_config_write'); ?></p>
                <?php
                } else {
                ?>
                <p class="wrong"><?php sync_output('config_read_failed'); $quit = TRUE;$allownext = "onclick = 'return false'";?></p>
                <?php
                    }
                }
                ?>
            </div>

            <form method="post">
            <p class="for clearfix"><a href="<?php sync_output(SYNC_FORM_ACSTEP_THREE);?>" class="btn">上一步</a><a class="btn" href="<?php sync_output(SYNC_FORM_ACSTEP_FIVE);?>" <?php sync_output($allownext);?>>下一步</a></p>
            </form>
            <?php } ?>
            <?php if ($step == SYNC_INSTALL_STEP_FIVE) {//引导第五步
                sync_check_mysql_info($quit, $alert, $sync_rebuild, $msg);
            if ( $quit ) {
                    $allownext = "onclick = 'return false'";
            ?>
            <div class="info">
                <p class="wrong"><?php sync_output('sync_error');?></p>
            </div>
            <?php
                sync_output($msg);
            } else {
            ?>
            <div class="info">
                <p class="wrong"><?php if ( $sync_rebuild ) { sync_output('sync_has_exist');}?><span><?php if ( !$sync_rebuild ) {sync_output('sync_db_nouse');} sync_output('import_db_data');?></span></p>
            </div>
            <?php } ?>

            <form method="post">
            <p class="for clearfix"><a href="<?php sync_output(SYNC_FORM_ACSTEP_FOUR);?>" class="btn">上一步</a><a class="btn" href="<?php sync_output(SYNC_FORM_ACSTEP_SIX);?>" <?php sync_output($allownext . $alert);?>>下一步</a></p>
            </form>
            <?php } ?>
            <?php if ($step == SYNC_INSTALL_STEP_SIX) {//引导第六步
                init_db($msg, $quit, $link);
                $fp     = fopen(SYNC_SQL_FILE, 'rb');
                $line   = fread($fp, filesize(SYNC_SQL_FILE));
                fclose($fp);
            ?>
            <div class="import">
                <h3><?php echo $sync_msg['import_processing'];?></h3>
                <div class="importinfo" style="overflow-y:scroll;height:152px;width:762;padding:5px;">
                <?php
                $table_count = 0;
                foreach(explode(";\n", trim($line)) as $sql) {
                    if( trim($sql) ) {
                        if( substr($sql, 0, 12) == 'CREATE TABLE' ) {
                            $name = preg_replace("/CREATE TABLE ([A-Z ]*)`([a-z0-9_]+)` .*/is", "\\2", $sql);
                            sync_output('<p>' . sync_succ_ret(sync_retstr('create_db_table') . ' ' . $name) . '</p>');
                            @mysql_query(sync_create_tb($sql, SYNC_DB_CHARSET));
                            $table_count ++;
                        } else 
                            @mysql_query($sql);
                    }
                }
                ?>
                </div>
            </div>
            <div class="create">
                <h3><?php sync_output('create_admin_user');?></h3>
                <?php
                //创建管理员账号
                $ret = sync_create_admin();
                if( $ret ) {
                    sync_output('<p>' . sync_succ_ret('create_admin_succ') . '</p>');
                    //初始化数据库信息
                    sync_insert_configs();
                    sync_init_tips();
                } else
                    sync_output('<p>' . sync_fail_ret($quit, 'create_admin_err') . '</p>');

                if( !$quit )
                    //锁定安装
                    fopen('install.lock', 'w');
                else
                    sync_output('install_retry');
                ?>
            </div>
            <div class="success">
				<h3><?php sync_output('install_success');?></h3>
				<p><?php sync_output('install_succ_intro');?></p>
			</div>
			<div class="forbutton clearfix">
			<a href="../index.php" class="sup btn btn-primary">请点击这里开始体验SYNC上线系统吧！</a>
			<a href="./" class="again btn btn-primary">重新安装SYNC上线系统</a>
			</div>
            <?php } ?>
            <?php } ?>
        </div>
        <div class="round_bottom"></div>
    </div>
	<!--底部-->
	<div class="foot">
		<div class="footMain">Copyright 2013-2014 © vriteam.com All rights reserved. 京ICP备13033502号</div>
	</div>
</div>
</body>
</html>
