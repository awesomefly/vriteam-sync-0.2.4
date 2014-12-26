<ul class="list">
{foreach from=$list item='item'}
<li><span>上线单 ID：<a href="/index.php?mod=web.ticket&act=detail&id={$item[$smarty.const.WT_ID]}">{$item[$smarty.const.WT_ID]}</a></span> 
<span>创建者：<a href="/index.php?mod=web.ticket&act=search&stype=username&key={$item[$smarty.const.WT_OW]}">{$item[$smarty.const.WT_OW]}</a></span> 
<span>拥有文件的数目：{$item[$smarty.const.WT_FC]}</span>　
<span>操作次数：{$item[$smarty.const.WT_OC]}　</span>　
<span>最近操作的时间：{$item[$smarty.const.WT_OT]}</span>　
<span>　最后操作的状态：{$item[$smarty.const.WT_OP]}</span>　
<a href="/index.php?mod=web.ticket&act=detail&id={$item[$smarty.const.WT_ID]}" class="detail">详细信息</a></li>
{/foreach}
</ul>
{if $list}
    {include file="console/page.tpl"}
{/if}
