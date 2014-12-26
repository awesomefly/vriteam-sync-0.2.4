<table width="660" border="0" class="table table-bordered table-striped projectTable">
	{if $list}
	<tr class="trTitle">
		<td width="150" height="30" align="center"><span class="STYLE1">项目组名称</span></td>
		<td width="190" height="30" align="center"><span class="STYLE1">项目组描述</span></td>
		<td width="270" height="30" align="center"><span class="STYLE1">创建时间</span></td>
		<td width="60" height="30" align="center"><span class="STYLE1">操作</span></td>
	  </tr>
	{foreach from=$list item='item'}
	<tr acttion-type="act-pgroup-info" {if $item[$smarty.const.DB_PGROUP_DEL]}style="color:#f00"{/if}>
		<td width="150" height="30" align="center" title="{$item[$smarty.const.DB_PGROUP_NAME]|escape}">{$item[$smarty.const.DB_PGROUP_NAME]|escape}</td>
		<td width="190" height="30" align="center">{if $item[$smarty.const.DB_PGROUP_DESC]}{$item[$smarty.const.DB_PGROUP_DESC]|escape}{else}无{/if}</td>
		<td width="270" height="30" align="center">{$item[$smarty.const.DB_PGROUP_CTIME]|date_format:"%Y:%m:%d %H:%M:%S"}</td>
		<td width="60" height="30" align="center">
            <a href="{$smarty.const.PGROUP_ACTION_CREATE}&id={$item[$smarty.const.DB_PGROUP_ID]}" class="edits" title="编辑">【编辑】</a>
            <a href="{$smarty.const.PGROUP_ACTION_DELETE}&id={$item[$smarty.const.DB_PGROUP_ID]}" class="del" title="删除" action-type="act-pgroup-del">【删除】</a>
        </td>
	</tr>
	{/foreach}
	{else}
		<p class="none"><img src="../../static/core/img/none.png" border="0"> <span>还没有创建项目组？赶紧<a href="{$smarty.const.PGROUP_ACTION_PGROUP}">创建</a>一个吧！</span></p>
	{/if}
</table>
{if $list}
  {include file="console/page.tpl"}
{/if}

</div>
<div class="CtentFoor"></div>
</div>
</div>
</div>
