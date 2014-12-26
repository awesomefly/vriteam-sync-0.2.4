<div class="front-nav">
<div class="mainNav">
	<a href="/index.php?mod=web.ticket&act=mine" class="{if $curr_tpl == 'web/ticket_mine.tpl'} Cur{/if}">我的上线单</a>
	<a href="/index.php?mod=web.ticket&act=latest" class="{if $curr_tpl == 'web/ticket_latest.tpl'} Cur{/if}">最新上线单</a>
	<a href="/index.php?mod=web.ticket&act=detail" class="{if $curr_tpl == 'web/ticket_detail.tpl' || $curr_tpl == 'web/ticket_create.tpl'} Cur{/if}">查看上线单</a>
	<a href="/index.php?mod=web.ticket&act=search" class="{if $curr_tpl == 'web/ticket_search.tpl'} Cur{/if}">搜索</a>
	<a href="/index.php?mod=web.ticket&act=faq" class="last{if $curr_tpl == 'web/ticket_faq.tpl'} Cur{/if}">常见问题</a>
</div>
<div class="lookover">
<form id="index_form" method="GET" action="/index.php">
<input type="hidden"  name="mod" value="web.ticket"/>
<input type="hidden"  name="act" value="detail"/>
	<input type="text"  name="id" value="请输入上线单号" tabindex="1" action-type="act-placeholder"
	{if $smarty.const.TICKET_NEXT_ID}
	action-data="建议单号：{$smarty.const.TICKET_NEXT_ID}"/>　
	{else}
	action-data="请输入上线单号"/>　
	{/if}
	<a action-type="act-exist" tabindex="2" href="###" class="btn">查看</a>
	<a action-type="act-create" tabindex="3" href="###" class="btn">新建</a>
</form>
</div>
</div>
