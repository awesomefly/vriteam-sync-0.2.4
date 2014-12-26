<?php /* Smarty version 2.6.26, created on 2014-12-11 14:45:21
         compiled from console/user_create.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'console/user_create.tpl', 5, false),)), $this); ?>
                    <form action="<?php echo @USER_ACTION_DOCREATE; ?>
" method="post" id="user_form">
						<div class="info-list">
							<em>用  户   名  ：</em>
							<div class="InputInner">
                                <input type="text" name="<?php echo @USER_INPUT_USERNAME; ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['item'][@DB_USERS_USERNAME])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" tabindex="1" class="span1"/>
							    <div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list">
							<em>密　　码 ：</em>
							<div class="InputInner">
                                <input type="password" name="<?php echo @USER_INPUT_PASSWORD; ?>
" value="" tabindex="1" class="span1"/>
							    <div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list">
							<em>确认密码 ：</em>
							<div class="InputInner">
                                <input type="password" name="<?php echo @USER_INPUT_RPASSWORD; ?>
" value="" tabindex="1" class="span1"/>
							    <div class="error" style="display:none"></div>
                            </div>
						</div>
                        <?php if (@CONSOLE_ID): ?> <p class="reset">( 注：如果要重置密码，请在上面的文本框中填写新密码，否则可以不填写 )</p><?php endif; ?>
						<div class="info-choose">
							<em>用户权限  ：</em>
							<div class="power">
								<div class="i-checkbox-inspect">
                                <label><input type="checkbox" name="<?php echo @USER_INPUT_USER_MOD; ?>
[]" <?php if ($this->_tpl_vars['item']['user_mod']['select_file']): ?>checked=true<?php endif; ?> value="1" tabindex="1"> 选文件　</label>
                                <label><input type="checkbox" name="<?php echo @USER_INPUT_USER_MOD; ?>
[]" <?php if ($this->_tpl_vars['item']['user_mod']['operate_ticket']): ?>checked=true<?php endif; ?> value="2" tabindex="1"> 同步上线单</label>
							    </div><div class="error" style="display:none"></div>
							</div>
						</div>
						<div class="info-list">
							<em>用户状态 ：</em>
							<div class="chooses Mtop10">
                                <input type="radio" <?php if ($this->_tpl_vars['item'][@DB_USERS_DEL] == @USER_DEL_NOT): ?>checked="true"<?php endif; ?> name="<?php echo @USER_INPUT_IS_DEL; ?>
" tabindex="1" value="<?php echo @USER_DEL_NOT; ?>
"> 启用　
                                <input type="radio" <?php if ($this->_tpl_vars['item'][@DB_USERS_DEL] == @USER_DEL_YES): ?>checked="true"<?php endif; ?>name="<?php echo @USER_INPUT_IS_DEL; ?>
" tabindex="1" value="<?php echo @USER_DEL_YES; ?>
"> 停用
                            </div>
						</div>
						<div class="info-submit">
                            <input type="hidden" name="<?php echo @USER_INPUT_ID; ?>
" value="<?php echo @CONSOLE_ID; ?>
" />
                            <input type="submit" value="下一步" tabindex="1" class="btn">
                        </div>
					</form>
				</div>
				<div class="CtentFoor"></div>
			</div>
		</div>
	</div>
<script type="text/javascript" src="./static/console/user.js"></script>