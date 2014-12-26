				    <table  border="0" class="table table-bordered table-striped projectTable">
                        {if $list}
					    <tr>
							<td width="110" height="30" align="center"><span class="STYLE1">项目名称</span></td>
							<td width="150" height="30" align="center"><span class="STYLE1">所属项目组</span></td>
							<td width="140" height="30" align="center"><span class="STYLE1">svn服务器</span></td>
							<td width="130" height="30" align="center"><span class="STYLE1">文件服务器</span></td>
							<td width="60" height="30" align="center"><span class="STYLE1">操作</span></td>
						</tr>
                        {foreach from=$list item='item'}
                        <tr {if $item[$smarty.const.DB_PROJECTS_STATUS] == PROJECT_STATUS_STOP}style="color:#f00;"{/if}>
                            <td  width="130" height="30" align="center" title={$item[$smarty.const.DB_PROJECTS_NAME]}>{$item[$smarty.const.DB_PROJECTS_NAME]|escape}</td>
                            <td  width="170" height="30" align="center" title={$item.group_info[$smarty.const.DB_PGROUP_NAME]}>{$item.group_info[$smarty.const.DB_PGROUP_NAME]|escape}</td>
                            <td  width="155" height="30" align="center" title={$item.server_svn_list.s_desc}>
                            {if $item.server_svn_list}
                                {$item.server_svn_list.s_desc}
                            {else}
                                无
                            {/if}
                            </td>
                            <td  width="140" height="30" align="center" action-type="act-server-info">
                            {if $item.server_count > 1}
                                {$item.server_count}
                                <div class="server-list" style="display:none;">
                                <ul>
                                {foreach from=$item.server_file_list item='file_server' name='file_list'}
                                    <li>{$smarty.foreach.file_list.iteration}：{$file_server.s_desc}</li>
                                {/foreach}
                                </ul>
                            {elseif $item.server_count == 1}
                                <ul>
                                {foreach from=$item.server_file_list item='file_server' name='file_list'}
                                    <li title={$file_server.desc}>{$file_server.s_desc|truncate:8}</li>
                                {/foreach}
                                </ul>
                            {else}
                                无
                            {/if}
                            </div>
                            </td>
                            <td>
                                <a href="{$smarty.const.PROJECT_ACTION_CREATE}&id={$item[$smarty.const.DB_PROJECTS_ID]}" class="edits" title="编辑">【编辑】</a>
                                <a href="{$smarty.const.PROJECT_ACTION_DELETE}&id={$item[$smarty.const.DB_PROJECTS_ID]}" class="del" title="删除" action-type="act-project-del">【删除】</a>
                            </td>
                        </tr>
                    {/foreach}
                    {else}
                        <p class="none"><img src="../../static/core/img/none.png"><span>还没有创建项目？赶紧<a href="{$smarty.const.PROJECT_ACTION_PROJECT}">创建</a>一个吧！</span></p>
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
<script type="text/javascript" src="./static/console/project.js"></script>
