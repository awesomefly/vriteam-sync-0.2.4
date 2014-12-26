<!--选择文件-->
	<div class="fileMain">
        	<form id="select-file" method="post" action="index.php?mod=web.ticket&act=browser&id={$smarty.const.TICKET_ID}">
		<div class="projecName">
			<em>项目组名字：</em>
			<span>
				<select name="" class="projec" action-type="act-pro-select" tabindex="1">
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
			<em>svn版本：</em>
			<input type="text" name="version" value="1" title="10以内为查看最新N次的修改" style="width:100px" tabindex="1">
			<a href="##" class="btn browse" action-type="act-browse-file" tabindex="1">浏览</a>
			<em>({$smarty.const.SYNC_SVN_LOG_MAX}以内为查看最新N次的修改)</em>
			<input type="checkbox" name="sort" value="1" tabindex="1" style="margin:5px 4px 0 4px;"/><em>是否按版本排序</em>
		</div>
        	</form>
	</div>
        <div class="ajax-callback-list">
        </div>
	<!--文件列表需要放到这里-->
