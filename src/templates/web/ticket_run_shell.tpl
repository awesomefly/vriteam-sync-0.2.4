<!--同步后结果开始-->
<div class="mask-scroll-y">
	<div class="document">
		<ul class="fileList">
{foreach from=$ticket.run_shell_result item='item'}
			<li>
			<h4>服务器: {$item.server_info.desc} (ip:{$item.server_info.ip})</h4>
			<h4>脚本路径: {$item.file}</h4>
{if $item.suc}
	{foreach from=$item.suc item='sitem'}
	<span style="color:green">执行成功: {$sitem}</span>
	{/foreach}
{/if}
{if $item.fal}
	{foreach from=$item.fal item='fitem'}
	<span class="listWrong">执行错误: {$fitem}</span>
	{/foreach}
{/if}
			</li>
{/foreach}
		</ul>
	</div>
</div>
<!--同步结果结束-->
