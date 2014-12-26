	<div class="details">
{foreach from=$ticket.sync_result item='item'}
			<div class="details_top"> </div>
			<div class="details_center">
			<h4>{$item.server_info.desc} (ip:{$item.server_info.ip})</h4>
{if $item.sync_result.suc}
	<ul>
	{foreach from=$item.sync_result.suc item='sitem'}
	<li> <span style="color:green">远程路径:{$sitem[$smarty.const.OP_LIST_KEY_RPATH]}</span> </li>
	{/foreach}
	</ul>
{/if}
{if $item.sync_result.fal}
	<ul>
	{foreach from=$item.sync_result.fal item='fitem'}
	<li> <span class="listWrong">远程路径:{$fitem[$smarty.const.OP_LIST_KEY_RPATH]}({$fitem.errmsg})</span> </li>
	{/foreach}
	</ul>
{/if}
			</div>
		<div class="details_bottom"></div>
{/foreach}
		</div>
