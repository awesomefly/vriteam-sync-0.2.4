<form id="act-run" action="/index.php?mod=web.ticket&act=run_shell&id={$smarty.const.TICKET_ID}" method="POST">
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
	<div style="margin-left: 10px; margin-top:15px;">
		<p>路 径:</p> <input type="text" id="sh_path" name="shellpath" style="width:400px;"/>
	</div>
	<div class="export">
		<a href="javascript:;" class="btn" action-type="act-run-shell" tabindex="1">执行</a>
	</div>
</form>
