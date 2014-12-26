                    <table border="0" class="table table-bordered table-striped projectTable">
                        {if $list}
						<tr class="trTitle">
						    <td width="150" height="30" align="center"><span class="STYLE1">用户名</span></td>
							<td width="270" height="30" align="center"><span class="STYLE1">用户权限</span></td>
							<td width="60" height="30" align="center"><span class="STYLE1">操作</span></td>
						  </tr>
                        {foreach from=$list item='item'}
                        <tr {if $item[$smarty.const.DB_USERS_DEL] == $smarty.const.USER_DEL_YES}style="color:#f00;"{/if}>
                            <td width="170" height="30" align="center">{$item[$smarty.const.DB_USERS_USERNAME]|escape}</td>
                            <td width="160" height="30" align="center">
                            {if $item.user_mod.select_file}
                                选文件 
                            {/if}
                            {if $item.user_mod.operate_ticket}
                                同步上线单 
                            {/if}
                            </td>
                            <td width="60" height="30" align="center"><a href="{$smarty.const.USER_ACTION_CREATE}&id={$item[$smarty.const.DB_USERS_ID]}" class="edits" title="编辑">编辑</a><a href="{$smarty.const.USER_ACTION_DELETE}&id={$item[$smarty.const.DB_USERS_ID]}" class="del" title="删除" action-type="act-user-del">删除</a></td>
                        </tr>
                        {/foreach}
                        {else}
                            <p class="none"><img src="../../static/core/img/none.png"> <span>还没用户？赶紧<a href="{$smarty.const.USER_ACTION_USER}">创建</a>一个吧！</span></p>
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
<script type="text/javascript" src="./static/console/user.js"></script>
