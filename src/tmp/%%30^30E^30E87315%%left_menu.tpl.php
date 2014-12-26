<?php /* Smarty version 2.6.26, created on 2014-12-11 14:44:28
         compiled from console/left_menu.tpl */ ?>
<div class="leftNave">
    <span>
        <a href="<?php echo @SERVER_ACTION_SERVER; ?>
" 
        class="server<?php if (@CURR_MOD == 'console/server'): ?> Cur<?php endif; ?>">
        服务器管理
        </a>
    </span>
    <span>
        <a href="<?php echo @PGROUP_ACTION_PGROUP; ?>
" 
        class="projectTeam<?php if (@CURR_MOD == 'console/pgroup'): ?> Cur<?php endif; ?>">
        项目组管理
        </a>
    </span>
    <span>
        <a href="<?php echo @PROJECT_ACTION_PROJECT; ?>
"
        class="project<?php if (@CURR_MOD == 'console/project'): ?> Cur<?php endif; ?>">
        项目管理
        </a>
    </span>
    <span>
        <a href="<?php echo @USER_ACTION_USER; ?>
"
        class="user<?php if (@CURR_MOD == 'console/user'): ?> Cur<?php endif; ?>">
        用户管理
        </a>
    </span>
	<span class="last">
        <a href="<?php echo @GUIDE_REDIRECT_GUIDE; ?>
"
        class="fast<?php if (@CURR_MOD == 'console/guide'): ?> Cur last<?php endif; ?>">
        快速引导
        </a>
    </span>
</div>