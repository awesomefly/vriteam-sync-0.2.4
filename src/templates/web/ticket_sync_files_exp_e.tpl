<!--同步后结果开始-->
<div class="mask-scroll-y">
	<div class="document">
		<ul class="fileList">
{foreach from=$ticket.sync_result_e item='item'}
			<li>
			<h4>{$item[$smarty.const.WT_UL]} (项目:{$item[$smarty.const.OP_LIST_KEY_PN]})</h4>
{if $item[$smarty.const.WT_EM]}
	<span class="listWrong">错误原因:{$item[$smarty.const.WT_EM]}</span>
{/if}
			</li>
{/foreach}
		</ul>
	</div>
</div>
<!--同步结果结束-->
