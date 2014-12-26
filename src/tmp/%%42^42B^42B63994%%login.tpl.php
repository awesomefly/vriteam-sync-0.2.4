<?php /* Smarty version 2.6.26, created on 2014-12-11 14:23:06
         compiled from web/login.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "login-header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
        <?php echo $this->_tpl_vars['show_tip']; ?>

    </div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "static.core.js.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="./static/web/login.js"></script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "page.end.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>