                    <form action="{$smarty.const.PROJECT_ACTION_DOCREATE}" method="post" id="project_form">
						<div class="info-list">
							<em>项目名称  ：</em>
							<div class="InputInner">
                                <input type="text" name="{$smarty.const.PROJECT_INPUT_NAME}" value="{$item[$smarty.const.DB_PROJECTS_NAME]}" tabindex="1" class="span1"/>
							    <div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list">
							<em>所属项目组  ：</em>
							<div class="chooses">
                                <select name='{$smarty.const.PROJECT_INPUT_GROUP_ID}' tabindex="1">
                                    <option value="0">请选择...</option>
                                    {foreach from=$group_list item='group'}
                                        <option value="{$group.id}" {if $item.p_group_id == $group.id}selected=selected{/if}>{$group.name}</option>
                                    {/foreach}
                                </select>
							    <div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list">
							<em>svn服务器  ：</em>
							<div class="chooses">
                                <select name="{$smarty.const.PROJECT_INPUT_SERVER_SVN}" id="project_select" tabindex="1">
                                    <option value="0">请选择...</option>
                                {foreach from=$server_svn_list item="server_svn"}
                                    <option value="{$server_svn.id}" {if $server_svn.id == $item[$smarty.const.DB_PROJECTS_SVN]}selected="selected"{/if}>{$server_svn.desc|truncate:30}</option>
                                {/foreach}
                                </select>
							    <div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list"><em>文件服务器  ：</em>
						<div class="chooses Mtop10"><div class="i-checkbox-inspect">
                        {foreach from=$server_file_list item="server_file"}
                            <label><input type="checkbox" name="server_file[]" value="{$server_file.id}" {if $server_file.checked}checked{/if} tabindex="1">{$server_file.desc}</label>
                        {/foreach}
						</div><div class="error" style="display:none"></div>
                        </div>
						</div>
						<div class="info-list">
							<em>状　　态 ：</em>
							<div class="chooses Mtop10">
                                <input type="radio" {if $item[$smarty.const.DB_PROJECTS_STATUS] == $smarty.const.PROJECT_STATUS_USE}checked="true"{/if} name="{$smarty.const.PROJECT_INPUT_STATUS}" tabindex="1" value="{$smarty.const.PROJECT_STATUS_USE}"> 启用　
                                <input type="radio" {if $item[$smarty.const.DB_PROJECTS_STATUS]}checked="true"{/if}name="{$smarty.const.PROJECT_INPUT_STATUS}" tabindex="1" value="{$smarty.const.PROJECT_STATUS_STOP}"> 停用
                            </div>
						</div>
                        <input type="hidden" name="id" value="{$smarty.const.CONSOLE_ID}" />
                        <div class="info-submit"><input type="submit" value="下一步" tabindex="1" class="btn"></div>
					</form>
				</div>
				<div class="CtentFoor"></div>
			</div>
		</div>
	</div>
<script type="text/javascript" src="./static/console/project.js"></script>
