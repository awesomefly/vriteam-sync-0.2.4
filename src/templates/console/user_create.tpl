                    <form action="{$smarty.const.USER_ACTION_DOCREATE}" method="post" id="user_form">
						<div class="info-list">
							<em>用  户   名  ：</em>
							<div class="InputInner">
                                <input type="text" name="{$smarty.const.USER_INPUT_USERNAME}" value="{$item[$smarty.const.DB_USERS_USERNAME]|escape}" tabindex="1" class="span1"/>
							    <div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list">
							<em>密　　码 ：</em>
							<div class="InputInner">
                                <input type="password" name="{$smarty.const.USER_INPUT_PASSWORD}" value="" tabindex="1" class="span1"/>
							    <div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list">
							<em>确认密码 ：</em>
							<div class="InputInner">
                                <input type="password" name="{$smarty.const.USER_INPUT_RPASSWORD}" value="" tabindex="1" class="span1"/>
							    <div class="error" style="display:none"></div>
                            </div>
						</div>
                        {if $smarty.const.CONSOLE_ID} <p class="reset">( 注：如果要重置密码，请在上面的文本框中填写新密码，否则可以不填写 )</p>{/if}
						<div class="info-choose">
							<em>用户权限  ：</em>
							<div class="power">
								<div class="i-checkbox-inspect">
                                <label><input type="checkbox" name="{$smarty.const.USER_INPUT_USER_MOD}[]" {if $item.user_mod.select_file}checked=true{/if} value="1" tabindex="1"> 选文件　</label>
                                <label><input type="checkbox" name="{$smarty.const.USER_INPUT_USER_MOD}[]" {if $item.user_mod.operate_ticket}checked=true{/if} value="2" tabindex="1"> 同步上线单</label>
							    </div><div class="error" style="display:none"></div>
							</div>
						</div>
						<div class="info-list">
							<em>用户状态 ：</em>
							<div class="chooses Mtop10">
                                <input type="radio" {if $item[$smarty.const.DB_USERS_DEL] == $smarty.const.USER_DEL_NOT}checked="true"{/if} name="{$smarty.const.USER_INPUT_IS_DEL}" tabindex="1" value="{$smarty.const.USER_DEL_NOT}"> 启用　
                                <input type="radio" {if $item[$smarty.const.DB_USERS_DEL] == $smarty.const.USER_DEL_YES}checked="true"{/if}name="{$smarty.const.USER_INPUT_IS_DEL}" tabindex="1" value="{$smarty.const.USER_DEL_YES}"> 停用
                            </div>
						</div>
						<div class="info-submit">
                            <input type="hidden" name="{$smarty.const.USER_INPUT_ID}" value="{$smarty.const.CONSOLE_ID}" />
                            <input type="submit" value="下一步" tabindex="1" class="btn">
                        </div>
					</form>
				</div>
				<div class="CtentFoor"></div>
			</div>
		</div>
	</div>
<script type="text/javascript" src="./static/console/user.js"></script>
