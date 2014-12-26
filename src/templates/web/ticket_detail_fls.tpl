<ul class="fileList act-file-list">
{if $ticket[$smarty.const.WT_FL]}
{foreach from=$ticket[$smarty.const.WT_FL] item='item'  name='f_list'}
<li>
{if $ticket.browser}
<input type="checkbox" name="files[]" value="{$item[$smarty.const.WT_EC]}" checked="checked" tabindex="1"/>
{else}
<input type="checkbox" value="{$item[$smarty.const.WT_KY]}" name="key[]" tabindex="1">
{/if}
<span><img src="/static/frontEnd/img/{$item[$smarty.const.WT_PC]}" border="0">&nbsp&nbsp&nbsp
　{$smarty.foreach.f_list.iteration}.
项目：<strong>{$item[$smarty.const.OP_LIST_KEY_PN]}</strong>，
版本：{$item[$smarty.const.OP_LIST_KEY_V]}，
日期：{$item[$smarty.const.OP_LIST_KEY_DATE]}，
作者：{$item[$smarty.const.OP_LIST_KEY_AUTHOR]}，
操作：{$item[$smarty.const.WT_AR]}
{if $item[$smarty.const.WT_NV] === null}
未获取(因文件过多,不影响使用)
{else}
最新版本：<strong>{$item[$smarty.const.WT_NV]}</strong>
{if $smarty.const.SYNC_SVN_TRUNK}：trunk文件版本：<strong>{$item[$smarty.const.WT_TV]}</strong>{/if}
{/if}
<br />
{$item[$smarty.const.WT_UL]}
</span>
</li>
{/foreach}
{else}
<p class="none clearfix"><img src="/static/core/img/none.png" border="0">　<span>上线单中还没有文件</span></p>
{/if}
</ul>

