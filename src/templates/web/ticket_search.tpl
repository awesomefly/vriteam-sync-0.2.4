{include file="web/ticket_searchd.tpl"}
{if $list}
{include file="web/ticket_list.tpl"}
{else}
<p class="none"><img src="../../static/core/img/none.png" border="0">　<span>系统还没有上线单!</span></p>
{/if}
