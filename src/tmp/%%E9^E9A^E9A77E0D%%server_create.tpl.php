<?php /* Smarty version 2.6.26, created on 2014-12-11 14:44:36
         compiled from console/server_create.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'console/server_create.tpl', 66, false),)), $this); ?>
                    <form action="<?php echo @SERVER_ACTION_DOCREATE; ?>
" method="post" id="server_form">
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
                                <input type="text" name="<?php echo @SERVER_INPUT_DESC; ?>
" value="<?php echo $this->_tpl_vars['item'][@SVN_INFO_KEY_DESC]; ?>
" tabindex="1"/ class="span1">
							    <div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list">
							<em>服务器类型  ：</em>
							<div class="choose_server">
                                <select name="<?php echo @SERVER_INPUT_S_TYPE; ?>
" id="server_select" tabindex="1">
                                    <option value="<?php echo @SERVER_TYPE_SVN; ?>
" <?php if ($this->_tpl_vars['item'][@SVN_INFO_KEY_SVNSE]): ?>selected="selected"<?php endif; ?>>SVN服务器</option>
                                    <option value="<?php echo @SERVER_TYPE_FILE; ?>
" <?php if ($this->_tpl_vars['item'][@SVN_INFO_KEY_FILESE]): ?>selected="selected"<?php endif; ?>>文件同步服务器</option>
                                </select>
								<div class="error" style="display:none"></div>
							</div>
						</div>
						<div class="info-list" id="ip_url" <?php if ($this->_tpl_vars['item'][@SYNC_SERVER_INFO_KEY_ID] && $this->_tpl_vars['item'][@SVN_INFO_KEY_SVNSE] || ! $this->_tpl_vars['item']): ?>style="display:none"<?php endif; ?>>
							<em>IP地址  ：</em>
							<div class="InputInner">
                                <input type="text" name="<?php echo @SERVER_INPUT_IP_URL; ?>
" value="<?php echo $this->_tpl_vars['item'][@SYNC_SERVER_INFO_KEY_IP]; ?>
"  tabindex="1" class="span1"/>
								<div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list" id="host_port" <?php if ($this->_tpl_vars['item'][@SYNC_SERVER_INFO_KEY_ID] && $this->_tpl_vars['item'][@SVN_INFO_KEY_SVNSE] || ! $this->_tpl_vars['item']): ?>style="display:none"<?php endif; ?>>
							<em>端口  ：</em>
							<div class="InputInner">
                                <input type="text" name="<?php echo @SERVER_INPUT_PORT; ?>
" value="<?php if ($this->_tpl_vars['item'][@SYNC_SERVER_INFO_KEY_PORT]): ?><?php echo $this->_tpl_vars['item'][@SYNC_SERVER_INFO_KEY_PORT]; ?>
<?php else: ?>22<?php endif; ?>"  tabindex="1" class="span1"/>
								<div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list" id="prefix" <?php if ($this->_tpl_vars['item'][@SYNC_SERVER_INFO_KEY_ID] && $this->_tpl_vars['item'][@SVN_INFO_KEY_SVNSE] || ! $this->_tpl_vars['item']): ?>style="display:none"<?php endif; ?>>
							<em>文件部署根路径  ：</em>
							<div class="InputInner">
                                <input type="text" name="<?php echo @SERVER_INPUT_PREFIX; ?>
" value="<?php echo $this->_tpl_vars['item'][@SYNC_SERVER_INFO_KEY_WWWROOT]; ?>
"  tabindex="1" class="span1"/>
								<div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list" id="s_uri" <?php if ($this->_tpl_vars['item'][@SVN_INFO_KEY_FILESE]): ?>style="display:none"<?php endif; ?>>
							<em>svn地址  ：</em>
							<div class="InputInner">
                                <input type="text" name="<?php echo @SERVER_INPUT_S_URI; ?>
" value="<?php echo $this->_tpl_vars['item'][@SVN_INFO_KEY]; ?>
" tabindex="1" class="span1"/>
								<div class="error" style="display:none"></div>
                            </div>
						</div>
						<?php if (@SYNC_SVN_TRUNK): ?>
						<div class="info-list" id="trunk_uri" <?php if ($this->_tpl_vars['item'][@SVN_INFO_KEY_FILESE]): ?>style="display:none"<?php endif; ?>>
							<em>trunk地址   ：</em>
							<div class="InputInner">
                                <input type="text" name="<?php echo @SERVER_INPUT_TRUNK_URI; ?>
" value="<?php echo $this->_tpl_vars['item'][@SVN_INFO_KEY_TRUNK]; ?>
" tabindex="1" class="span1"/>
								<div class="error" style="display:none"></div>
                            </div>
						</div>
						<?php endif; ?>
						<div class="info-list">
							<em>用  户   名  ：</em>
							<div class="InputInner">
                                <input type="text" name="<?php echo @SERVER_INPUT_USER_NAME; ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['item'][@SYNC_SERVER_INFO_KEY_USERNAME])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" tabindex="1" class="span1"/>
								<div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list">
							<em>密　　码 ：</em>
							<div class="InputInner">
                                <input type="password" name="<?php echo @SERVER_INPUT_PASSWORD; ?>
" tabindex="1" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['item'][@SYNC_SERVER_INFO_KEY_PASSWORD])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="span1">
								<div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list">
							<em>状　　态 ：</em>
							<div class="chooses Mtop10">
                                <input type="radio" <?php if ($this->_tpl_vars['item'][@SVN_INFO_KEY_CLOSE] == @SERVER_CLOSE_FALSE): ?>checked="true"<?php endif; ?> name="<?php echo @SERVER_INPUT_IS_DEL; ?>
" tabindex="1" value="<?php echo @SERVER_CLOSE_FALSE; ?>
"> 启用　
                                <input type="radio" <?php if ($this->_tpl_vars['item'][@SVN_INFO_KEY_CLOSE] == @SERVER_CLOSE_TRUE): ?>checked="true"<?php endif; ?>name="<?php echo @SERVER_INPUT_IS_DEL; ?>
" tabindex="1" value="<?php echo @SERVER_CLOSE_TRUE; ?>
"> 停用
                            </div>
						</div>
                        <input type="hidden" name="id" value="<?php echo @CONSOLE_ID; ?>
" tabindex="3"/>
						<div class="info-submit"><input type="submit" value="下一步" tabindex="2" class="btn"></div>
					</form>
				</div>
			</div>
		</div>
	</div>