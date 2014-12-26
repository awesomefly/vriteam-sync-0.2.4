<?php /* Smarty version 2.6.26, created on 2014-12-11 14:40:22
         compiled from console/guide_step2.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'console/guide_step2.tpl', 37, false),)), $this); ?>
<!--配置svn服务器开始-->
<form id="server_form" action="<?php echo @GUIDE_REDIRECT_STEP2; ?>
" method="post">
	<div class="info-list clearfix">
		<em>服务器名称  ：</em>
		<div class="InputInner">
            <input type="text" name="<?php echo @SERVER_INPUT_DESC; ?>
" value="<?php echo $_SESSION['gd_st2']['dc']; ?>
" class="span2">
			<div class="error"></div>
        </div>
	</div>
	<div class="info-list clearfix">
		<em>svn地址  ：</em>
		<div class="InputInner">
            <input type="text" name="<?php echo @SERVER_INPUT_S_URI; ?>
" value="<?php echo $_SESSION['gd_st2']['si']; ?>
" class="span2">
			<div class="error"></div>
        </div>
	</div>
	
	<?php if (@SYNC_SVN_TRUNK): ?>
    <div class="info-list clearfix">
        <em>trunk地址   ：</em>
        <div class="InputInner">
            <input type="text" name="<?php echo @SERVER_INPUT_TRUNK_URI; ?>
" value="<?php echo $_SESSION['gd_st2']['ti']; ?>
" class="span2">
			<div class="error"></div>
        </div>
    </div>
	<?php endif; ?>
    <div class="info-list clearfix">
        <em>用  户   名  ：</em>
        <div class="InputInner">
            <input type="text" name="<?php echo @SERVER_INPUT_USER_NAME; ?>
" value="<?php echo $_SESSION['gd_st2']['un']; ?>
" class="span2">
			<div class="error"></div>
        </div>
    </div>
    <div class="info-list clearfix">
        <em>密       码 ：</em>
        <div class="InputInner">
            <input type="password" name="<?php echo @SERVER_INPUT_PASSWORD; ?>
" value="<?php echo ((is_array($_tmp=$_SESSION['gd_st2']['pd'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="span2">
			<div class="error"></div>
        </div>
    </div>
    <div class="info-operating">
    <input type="hidden" name="<?php echo @SERVER_INPUT_S_TYPE; ?>
" value="<?php echo @SERVER_TYPE_SVN; ?>
" />
        <input type="hidden" name="<?php echo @GUIDE_KEY_JUMP; ?>
" value="<?php echo $this->_tpl_vars['jump']; ?>
" />
        <a href="<?php echo @GUIDE_REDIRECT_STEP1; ?>
" class="btn">上一步</a>
        <input type="submit" value="下一步" class="btn">
    </div>
</form>
<!--配置svn服务器结束-->