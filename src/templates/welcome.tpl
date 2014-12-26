<div class="welcome">
	<div class="welcomeMain">
		<span class="Name">hi:{$smarty.const.CURRENT_USERNAME}</span>
		<span class="operat">
			{if $smarty.const.CURRENT_USERNAME == $smarty.const.USER_ADMIN_NAME}
			{if $smarty.const.CURR_MOD|truncate:7:'':TRUE == 'console'}
			<a href="/index.php">去前台</a>
			{else}
			<a href="{$smarty.const.SERVER_ACTION_SERVER}">管理后台</a>
			{/if}
			{/if}
			<a href="{$smarty.const.LOGIN_OUT_URL}">
				退出登录
			</a>
		</span>
	</div>
</div>
