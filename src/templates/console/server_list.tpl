				    <table width="660" border="0" class="table table-bordered table-striped projectTable">
                        {if $list}
					    <tr class="trTitle">
							<td width="200" height="30" align="center"><span class="STYLE1">server描述</span></td>
							<td width="150" height="30" align="center"><span class="STYLE1">用户名</span></td>
							<td width="150" height="30" align="center"><span class="STYLE1">服务器类型</span></td>
							<td width="60" height="30" align="center"><span class="STYLE1">操作</span></td>
						</tr>
                        {foreach from=$list item='item'}
                        <tr action-type="act-server-info" action-data {if $item[$smarty.const.SVN_INFO_KEY_CLOSE] == $smarty.const.SERVER_CLOSE_TRUE}style="color:red;"{/if}>
                            <td width="200" height="30" align="center" title={$item[$smarty.const.SVN_INFO_KEY_DESC]}>{$item[$smarty.const.SVN_INFO_KEY_DESC]}</td>
                            <td width="150" height="30" align="center">{$item[$smarty.const.SYNC_SERVER_INFO_KEY_USERNAME]}</td>
                            <td width="150" height="30" align="center">{if $item[$smarty.const.SVN_INFO_KEY_SVNSE]}SVN{elseif $item[$smarty.const.SVN_INFO_KEY_FILESE]}FILE{/if}</td>
                            <td width="60" height="30" align="center">
				<a href="{$smarty.const.SERVER_ACTION_CREATE}&id={$item[$smarty.const.SYNC_SERVER_INFO_KEY_ID]}" class="edits" title="编辑">编辑</a>
				<a href="{$smarty.const.SERVER_ACTION_DELETE}&id={$item[$smarty.const.SYNC_SERVER_INFO_KEY_ID]}" class="del" action-type="act-server-del" title="删除" >删除</a>
				</td>
				</tr>
                        {/foreach}
                        {else}
                            <p class="none"><img src="/static/core/img/none.png"><span>还没有服务器？赶紧<a href="{$smarty.const.SERVER_ACTION_SERVER}">创建</a>一个吧！</span></p>
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
