{foreach from=$ticket[$smarty.const.WT_OL] item='item' name='o_list'}
<li>
<span>
{$smarty.foreach.o_list.iteration}:
{if $item[$smarty.const.OP_LIST_KEY_HID]}
<a href="/index.php?mod=web.ticket&act=history_detail&hid={$item[$smarty.const.OP_LIST_KEY_HID]}"
action-type="act-history-detal" onclick="return false;">
{/if}
操作人：{$item[$smarty.const.OP_LIST_KEY_OPER]}，操作：{$item[$smarty.const.OP_LIST_KEY_OPTYPER]} 时间截：{$item[$smarty.const.OP_LIST_KEY_OPTIME]|date_format:"%Y-%m-%d %H:%M:%S"}
{if $item[$smarty.const.OP_LIST_KEY_HID]}
</a>
{/if}
</span>
</li>
{/foreach}
