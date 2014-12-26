<?php /* Smarty version 2.6.26, created on 2014-12-11 14:39:49
         compiled from header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'header.tpl', 19, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['sync_title']; ?>
</title>
<link id="change-theme" rel="stylesheet" type="text/css" href="/static/core/css/common.css" />
<link rel="stylesheet" type="text/css" href="/static/core/js/icard/css/jquery.icard.css" />
<link rel="shortcut icon" href="/static/core/img/favicon.ico"> 
</head>
<body> 
<div class="wrap">
	<!--头部 -->
	<div class="header">
		<div class="head-main">
			<h1><a href="/index.php"><img src="../static/core/img/small_logo.png"></a></h1>
			<div class="operat">
				<span class="Name">欢迎:<?php echo @CURRENT_USERNAME; ?>
</span>
				<?php if (@CURRENT_USERNAME == @USER_ADMIN_NAME): ?>
				<?php if (((is_array($_tmp=@CURR_MOD)) ? $this->_run_mod_handler('truncate', true, $_tmp, 7, '', 'TRUE') : smarty_modifier_truncate($_tmp, 7, '', 'TRUE')) == 'console'): ?>
				<a href="/index.php" class="Cur">前台管理</a>
				<?php else: ?>
				<a href="<?php echo @SERVER_ACTION_SERVER; ?>
" class="Cur">后台管理</a>
				<?php endif; ?>
				<?php endif; ?>
				<a href="<?php echo @LOGIN_OUT_URL; ?>
">
				退出登陆
				</a>
			</div>
		</div>
	</div>