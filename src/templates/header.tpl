<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$sync_title}</title>
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
				<span class="Name">欢迎:{$smarty.const.CURRENT_USERNAME}</span>
				{if $smarty.const.CURRENT_USERNAME == $smarty.const.USER_ADMIN_NAME}
				{if $smarty.const.CURR_MOD|truncate:7:'':TRUE == 'console'}
				<a href="/index.php" class="Cur">前台管理</a>
				{else}
				<a href="{$smarty.const.SERVER_ACTION_SERVER}" class="Cur">后台管理</a>
				{/if}
				{/if}
				<a href="{$smarty.const.LOGIN_OUT_URL}">
				退出登陆
				</a>
			</div>
		</div>
	</div>
