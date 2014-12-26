<!--同步后结果开始-->
<div class="mask-scroll-y">
	<div class="document">
		<ul class="fileList">
{foreach from=$ticket.sync_result item='item'}
			<li>
			<h4>{$item.server_info.desc} (ip:{$item.server_info.ip})</h4>
{if $item.sync_result.suc}
	{foreach from=$item.sync_result.suc item='sitem'}
	<span style="color:green">远程路径:{$sitem[$smarty.const.OP_LIST_KEY_RPATH]}</span>
	{/foreach}
{/if}
{if $item.sync_result.fal}
	{foreach from=$item.sync_result.fal item='fitem'}
	<span class="listWrong">远程路径:{$fitem[$smarty.const.OP_LIST_KEY_RPATH]}({$fitem.errmsg})</span>
	{/foreach}
{/if}
			</li>
{/foreach}
		</ul>
	</div>
</div>
<!--同步结果结束-->
