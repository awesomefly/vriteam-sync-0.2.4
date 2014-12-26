{if $smarty.const.CURR_MOD == 'console/project'} 
    	<h2>项目管理 
		<a href="{$smarty.const.PROJECT_ACTION_PROJECT}" style="margin-right:4px;" {if $smarty.const.CURR_ACT == 'index' || $smarty.const.CURR_ACT == 'create'} class="Cur"{/if}>新增</a>/
		<a href="{$smarty.const.PROJECT_ACTION_LIST}" style="margin-left:4px;" {if $smarty.const.CURR_ACT == 'list'} class="Cur"{/if}>列表</a>
	</h2>
{elseif $smarty.const.CURR_MOD == 'console/pgroup'}
	<h2>项目组管理
		<a href="{$smarty.const.PGROUP_ACTION_PGROUP}" style="margin-right:4px;" {if $smarty.const.CURR_ACT == 'index' || $smarty.const.CURR_ACT == 'create'} class="Cur"{/if}>新增</a>/
		<a href="{$smarty.const.PGROUP_ACTION_LIST}" style="margin-left:4px;" {if $smarty.const.CURR_ACT == 'list'} class="Cur"{/if}>列表</a>
	</h2>
{elseif $smarty.const.CURR_MOD == 'console/server'}
	<h2>服务器管理
		<a href="{$smarty.const.SERVER_ACTION_SERVER}" style="margin-right:4px;" {if $smarty.const.CURR_ACT == 'index' || $smarty.const.CURR_ACT == 'create'} class="Cur"{/if}>新增</a>/
		<a href="{$smarty.const.SERVER_ACTION_LIST}" style="margin-left:4px;" {if $smarty.const.CURR_ACT == 'list'} class="Cur"{/if}>列表</a>
	</h2>
{elseif $smarty.const.CURR_MOD == 'console/user'}
	<h2>用户管理    
		<a href="{$smarty.const.USER_ACTION_USER}" style="margin-right:4px;" {if $smarty.const.CURR_ACT == 'index' || $smarty.const.CURR_ACT == 'create'} class="Cur"{/if}>新增</a>/
		<a href="{$smarty.const.USER_ACTION_LIST}" style="margin-left:4px;" {if $smarty.const.CURR_ACT == 'list'} class="Cur"{/if}>列表</a>
	</h2>
{/if}
