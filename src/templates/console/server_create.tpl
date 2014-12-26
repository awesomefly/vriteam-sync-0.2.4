                    <form action="{$smarty.const.SERVER_ACTION_DOCREATE}" method="post" id="server_form">
					    <div class="control-group error" style="display:none">
                            <label class="control-label" for="inputError">Input with error</label>
                            <div class="controls">
                                <input type="text" id="inputError">
                                <span class="help-inline">Please correct the error</span>
                            </div>
                        </div>
                        <div class="info-list">
							<em>服务器名称  ：</em>
							<div class="InputInner">
                                <input type="text" name="{$smarty.const.SERVER_INPUT_DESC}" value="{$item[$smarty.const.SVN_INFO_KEY_DESC]}" tabindex="1"/ class="span1">
							    <div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list">
							<em>服务器类型  ：</em>
							<div class="choose_server">
                                <select name="{$smarty.const.SERVER_INPUT_S_TYPE}" id="server_select" tabindex="1">
                                    <option value="{$smarty.const.SERVER_TYPE_SVN}" {if $item[$smarty.const.SVN_INFO_KEY_SVNSE]}selected="selected"{/if}>SVN服务器</option>
                                    <option value="{$smarty.const.SERVER_TYPE_FILE}" {if $item[$smarty.const.SVN_INFO_KEY_FILESE]}selected="selected"{/if}>文件同步服务器</option>
                                </select>
								<div class="error" style="display:none"></div>
							</div>
						</div>
						<div class="info-list" id="ip_url" {if $item[$smarty.const.SYNC_SERVER_INFO_KEY_ID] && $item[$smarty.const.SVN_INFO_KEY_SVNSE] || !$item}style="display:none"{/if}>
							<em>IP地址  ：</em>
							<div class="InputInner">
                                <input type="text" name="{$smarty.const.SERVER_INPUT_IP_URL}" value="{$item[$smarty.const.SYNC_SERVER_INFO_KEY_IP]}"  tabindex="1" class="span1"/>
								<div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list" id="host_port" {if $item[$smarty.const.SYNC_SERVER_INFO_KEY_ID] && $item[$smarty.const.SVN_INFO_KEY_SVNSE] || !$item}style="display:none"{/if}>
							<em>端口  ：</em>
							<div class="InputInner">
                                <input type="text" name="{$smarty.const.SERVER_INPUT_PORT}" value="{if $item[$smarty.const.SYNC_SERVER_INFO_KEY_PORT]}{$item[$smarty.const.SYNC_SERVER_INFO_KEY_PORT]}{else}22{/if}"  tabindex="1" class="span1"/>
								<div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list" id="prefix" {if $item[$smarty.const.SYNC_SERVER_INFO_KEY_ID] && $item[$smarty.const.SVN_INFO_KEY_SVNSE] || !$item}style="display:none"{/if}>
							<em>文件部署根路径  ：</em>
							<div class="InputInner">
                                <input type="text" name="{$smarty.const.SERVER_INPUT_PREFIX}" value="{$item[$smarty.const.SYNC_SERVER_INFO_KEY_WWWROOT]}"  tabindex="1" class="span1"/>
								<div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list" id="s_uri" {if $item[$smarty.const.SVN_INFO_KEY_FILESE]}style="display:none"{/if}>
							<em>svn地址  ：</em>
							<div class="InputInner">
                                <input type="text" name="{$smarty.const.SERVER_INPUT_S_URI}" value="{$item[$smarty.const.SVN_INFO_KEY]}" tabindex="1" class="span1"/>
								<div class="error" style="display:none"></div>
                            </div>
						</div>
						{if $smarty.const.SYNC_SVN_TRUNK}
						<div class="info-list" id="trunk_uri" {if $item[$smarty.const.SVN_INFO_KEY_FILESE]}style="display:none"{/if}>
							<em>trunk地址   ：</em>
							<div class="InputInner">
                                <input type="text" name="{$smarty.const.SERVER_INPUT_TRUNK_URI}" value="{$item[$smarty.const.SVN_INFO_KEY_TRUNK]}" tabindex="1" class="span1"/>
								<div class="error" style="display:none"></div>
                            </div>
						</div>
						{/if}
						<div class="info-list">
							<em>用  户   名  ：</em>
							<div class="InputInner">
                                <input type="text" name="{$smarty.const.SERVER_INPUT_USER_NAME}" value="{$item[$smarty.const.SYNC_SERVER_INFO_KEY_USERNAME]|escape}" tabindex="1" class="span1"/>
								<div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list">
							<em>密　　码 ：</em>
							<div class="InputInner">
                                <input type="password" name="{$smarty.const.SERVER_INPUT_PASSWORD}" tabindex="1" value="{$item[$smarty.const.SYNC_SERVER_INFO_KEY_PASSWORD]|escape}" class="span1">
								<div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list">
							<em>状　　态 ：</em>
							<div class="chooses Mtop10">
                                <input type="radio" {if $item[$smarty.const.SVN_INFO_KEY_CLOSE] == $smarty.const.SERVER_CLOSE_FALSE}checked="true"{/if} name="{$smarty.const.SERVER_INPUT_IS_DEL}" tabindex="1" value="{$smarty.const.SERVER_CLOSE_FALSE}"> 启用　
                                <input type="radio" {if $item[$smarty.const.SVN_INFO_KEY_CLOSE] == $smarty.const.SERVER_CLOSE_TRUE}checked="true"{/if}name="{$smarty.const.SERVER_INPUT_IS_DEL}" tabindex="1" value="{$smarty.const.SERVER_CLOSE_TRUE}"> 停用
                            </div>
						</div>
                        <input type="hidden" name="id" value="{$smarty.const.CONSOLE_ID}" tabindex="3"/>
						<div class="info-submit"><input type="submit" value="下一步" tabindex="2" class="btn"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
