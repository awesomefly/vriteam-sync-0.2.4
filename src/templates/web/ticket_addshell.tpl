<div class="fileMain">
<form id="add-shell" method="post" action="index.php?mod=web.ticket&act=saveshell&id={$smarty.const.TICKET_ID}">
	<div class="projecName">
	<em>项目组名字：</em>
	<span>
		<select name="grp" class="projec" action-type="act-pro-select" tabindex="1">
		{include file="web/ticket_select_options.tpl" cache_lifetime=0 options=$list}
		</select>
		{if $listse}
		<select name="pname" class="branch" tabindex="1">
		{include file="web/ticket_select_options.tpl" options=$listse cache_lifetime=0}
		</select>
		{/if}
	<!--项目下拉菜单放到这里-->
	</span>
	</div>
	<div class="version">
	<em>路径：</em>
	<input type="text" name="path" style="width:400px" tabindex="1">
	<a href="##" class="delete btn" action-type="act-save-shell" tabindex="1">保存</a>
	</div>
</form>
</div>
