                    <form action="{$smarty.const.PGROUP_ACTION_DOCREATE}" method="post" id="project_group_form">
						<div class="info-list">
							<em>项目组名称  ：</em>
							<div class="InputInner">
                                <input type="text" name="{$smarty.const.PGROUP_INPUT_NAME}" value="{$item[$smarty.const.DB_PGROUP_NAME]}" tabindex="1" class="span2"/>
							    <div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list">
							<em>项目组描述  ：</em>
							<div class="textBox">
                                <textarea name="{$smarty.const.PGROUP_INPUT_GROUP_DESC}" tabindex="1">{$item[$smarty.const.DB_PGROUP_DESC]|escape}</textarea>
							    <div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list">
							<em>状　　态 ：</em>
							<div class="chooses Mtop10">
                               <input type="radio" {if $item[$smarty.const.DB_PGROUP_DEL] == $smarty.const.PGROUP_DEL_NOT}checked="true"{/if} name="{$smarty.const.PGROUP_INPUT_IS_DEL}" tabindex="1" value="{$smarty.const.PGROUP_DEL_NOT}"> 启用　
                                <input type="radio" {if $item[$smarty.const.DB_PGROUP_DEL] == $smarty.const.PGROUP_DEL_YES}checked="true"{/if}name="{$smarty.const.SERVER_INPUT_IS_DEL}" tabindex="1" value="{$smarty.const.PGROUP_DEL_YES}"> 停用
                            </div>
						</div>
                        <div class="info-submit">
                            <input type="hidden" name="id" value="{$smarty.const.CONSOLE_ID}" />
                            <input type="submit" value="下一步" tabindex="1" class="btn">
                        </div>
					</form>
				</div>
				<div class="CtentFoor"></div>
			</div>
		</div>
	</div>
