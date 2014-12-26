<form id="act-sync" action="/index.php?mod=web.ticket&act=sync_files&id={$smarty.const.TICKET_ID}" method="POST">
	<div class="wantTongList">
		{foreach from=$ticket.p_list key='k' item='item' name='p_list'}
		<div class="listFei">
			<h3>项目:{$k}</h3>
			<ul>
				{foreach from=$item item='server' name='server_list'}
				<li>
					<input type="checkbox" value="{$server.key}"
					{if $smarty.foreach.server_list.total == 1}checked="checked"{/if} name="servers[]" tabindex="1">
					<span>{$server.desc} (ip:{$server.ip})</span>
				</li>
				{/foreach}
			</ul>
		</div>
		{/foreach}
		<div class="clearfix"></div>
	</div>
	<div class="export">
		{if $smarty.const.SYNC_SVN_TRUNK}
		<em>从哪里导出文件：</em>
		<span>
			<input type="radio" name="from" checked="checked" value="branch" tabindex="1">branch</option>
			<input type="radio" name="from" value="trunk" tabindex="1">trunk</option>
		</span>
		{/if}
		<a href="javascript:;" class="btn" action-type="act-sync" tabindex="1">同步</a>
		{if $showrb}
		<a href="javascript:;" class="btn" action-type="act-rollback" tabindex="1">回滚</a>
		{/if}
	</div>
</form>
