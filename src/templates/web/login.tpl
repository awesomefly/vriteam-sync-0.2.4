{include file="login-header.tpl"}
<link rel="stylesheet" type="text/css" href="./static/login/css/login.css">
	<!--中间-->
	<div class="login_content">
		<div class="content_main">
			<div class="main_panel">
				<form id="form" action="./index.php?mod=web.login&act=ex" method="POST">
					<div class="username">
						 <input type="text" name="user_name" value="" tabindex="1"/>
					</div>
					<div class="pass">
						<input type="password" name="password" value="" tabindex="1"/>
					</div>
					 <div class="info-operating"><input type="submit" value="登　录" action-type="act-login"></div>
					 <div class="automatic"><label><input type="checkbox" name="remember_me" value="on"> 自动登录</label></div>
				</form>
			</div>
		</div>
	</div>
	<div class="tips">
        {$show_tip}
    </div>
{include file="static.core.js.tpl"}
<script type="text/javascript" src="./static/web/login.js"></script>
{include file="page.end.tpl"}
