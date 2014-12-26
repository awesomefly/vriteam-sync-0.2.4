<div class="leftNave">
    <span>
        <a href="{$smarty.const.SERVER_ACTION_SERVER}" 
        class="server{if $smarty.const.CURR_MOD == 'console/server'} Cur{/if}">
        服务器管理
        </a>
    </span>
    <span>
        <a href="{$smarty.const.PGROUP_ACTION_PGROUP}" 
        class="projectTeam{if $smarty.const.CURR_MOD == 'console/pgroup'} Cur{/if}">
        项目组管理
        </a>
    </span>
    <span>
        <a href="{$smarty.const.PROJECT_ACTION_PROJECT}"
        class="project{if $smarty.const.CURR_MOD == 'console/project'} Cur{/if}">
        项目管理
        </a>
    </span>
    <span>
        <a href="{$smarty.const.USER_ACTION_USER}"
        class="user{if $smarty.const.CURR_MOD == 'console/user'} Cur{/if}">
        用户管理
        </a>
    </span>
	<span class="last">
        <a href="{$smarty.const.GUIDE_REDIRECT_GUIDE}"
        class="fast{if $smarty.const.CURR_MOD == 'console/guide'} Cur last{/if}">
        快速引导
        </a>
    </span>
</div>
