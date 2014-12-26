<div class="selectLists">
	<div class="document">
        <form id="act-save" method="post" class="mask-scroll-y" action="index.php?id={$smarty.const.TICKET_ID}&mod=web.ticket&act=save">
		{include file="web/ticket_detail_fls.tpl"}
        </form>
		<div class="handy act-choose">
			<input type="checkbox" checked="checked" action-type="all" tabindex="1"> 全选　　　
			<input type="checkbox" action-type="reverse" tabindex="1"> 反选　　　
			<a href="javascript:;" class="delete btn" action-type="act-save-choose" tabindex="1">保存</a> 
		</div>
	</div>
</div>
