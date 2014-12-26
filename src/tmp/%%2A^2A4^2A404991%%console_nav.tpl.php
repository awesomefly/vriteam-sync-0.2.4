<?php /* Smarty version 2.6.26, created on 2014-12-11 14:44:28
         compiled from console/console_nav.tpl */ ?>
<?php if (@CURR_MOD == 'console/project'): ?> 
    	<h2>项目管理 
		<a href="<?php echo @PROJECT_ACTION_PROJECT; ?>
" style="margin-right:4px;" <?php if (@CURR_ACT == 'index' || @CURR_ACT == 'create'): ?> class="Cur"<?php endif; ?>>新增</a>/
		<a href="<?php echo @PROJECT_ACTION_LIST; ?>
" style="margin-left:4px;" <?php if (@CURR_ACT == 'list'): ?> class="Cur"<?php endif; ?>>列表</a>
	</h2>
<?php elseif (@CURR_MOD == 'console/pgroup'): ?>
	<h2>项目组管理
		<a href="<?php echo @PGROUP_ACTION_PGROUP; ?>
" style="margin-right:4px;" <?php if (@CURR_ACT == 'index' || @CURR_ACT == 'create'): ?> class="Cur"<?php endif; ?>>新增</a>/
		<a href="<?php echo @PGROUP_ACTION_LIST; ?>
" style="margin-left:4px;" <?php if (@CURR_ACT == 'list'): ?> class="Cur"<?php endif; ?>>列表</a>
	</h2>
<?php elseif (@CURR_MOD == 'console/server'): ?>
	<h2>服务器管理
		<a href="<?php echo @SERVER_ACTION_SERVER; ?>
" style="margin-right:4px;" <?php if (@CURR_ACT == 'index' || @CURR_ACT == 'create'): ?> class="Cur"<?php endif; ?>>新增</a>/
		<a href="<?php echo @SERVER_ACTION_LIST; ?>
" style="margin-left:4px;" <?php if (@CURR_ACT == 'list'): ?> class="Cur"<?php endif; ?>>列表</a>
	</h2>
<?php elseif (@CURR_MOD == 'console/user'): ?>
	<h2>用户管理    
		<a href="<?php echo @USER_ACTION_USER; ?>
" style="margin-right:4px;" <?php if (@CURR_ACT == 'index' || @CURR_ACT == 'create'): ?> class="Cur"<?php endif; ?>>新增</a>/
		<a href="<?php echo @USER_ACTION_LIST; ?>
" style="margin-left:4px;" <?php if (@CURR_ACT == 'list'): ?> class="Cur"<?php endif; ?>>列表</a>
	</h2>
<?php endif; ?>