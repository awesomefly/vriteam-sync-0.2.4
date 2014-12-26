<?php /* Smarty version 2.6.26, created on 2014-12-11 14:44:41
         compiled from console/project_create.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'console/project_create.tpl', 27, false),)), $this); ?>
                    <form action="<?php echo @PROJECT_ACTION_DOCREATE; ?>
" method="post" id="project_form">
						<div class="info-list">
							<em>项目名称  ：</em>
							<div class="InputInner">
                                <input type="text" name="<?php echo @PROJECT_INPUT_NAME; ?>
" value="<?php echo $this->_tpl_vars['item'][@DB_PROJECTS_NAME]; ?>
" tabindex="1" class="span1"/>
							    <div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list">
							<em>所属项目组  ：</em>
							<div class="chooses">
                                <select name='<?php echo @PROJECT_INPUT_GROUP_ID; ?>
' tabindex="1">
                                    <option value="0">请选择...</option>
                                    <?php $_from = $this->_tpl_vars['group_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['group']):
?>
                                        <option value="<?php echo $this->_tpl_vars['group']['id']; ?>
" <?php if ($this->_tpl_vars['item']['p_group_id'] == $this->_tpl_vars['group']['id']): ?>selected=selected<?php endif; ?>><?php echo $this->_tpl_vars['group']['name']; ?>
</option>
                                    <?php endforeach; endif; unset($_from); ?>
                                </select>
							    <div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list">
							<em>svn服务器  ：</em>
							<div class="chooses">
                                <select name="<?php echo @PROJECT_INPUT_SERVER_SVN; ?>
" id="project_select" tabindex="1">
                                    <option value="0">请选择...</option>
                                <?php $_from = $this->_tpl_vars['server_svn_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['server_svn']):
?>
                                    <option value="<?php echo $this->_tpl_vars['server_svn']['id']; ?>
" <?php if ($this->_tpl_vars['server_svn']['id'] == $this->_tpl_vars['item'][@DB_PROJECTS_SVN]): ?>selected="selected"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['server_svn']['desc'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30) : smarty_modifier_truncate($_tmp, 30)); ?>
</option>
                                <?php endforeach; endif; unset($_from); ?>
                                </select>
							    <div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list"><em>文件服务器  ：</em>
						<div class="chooses Mtop10"><div class="i-checkbox-inspect">
                        <?php $_from = $this->_tpl_vars['server_file_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['server_file']):
?>
                            <label><input type="checkbox" name="server_file[]" value="<?php echo $this->_tpl_vars['server_file']['id']; ?>
" <?php if ($this->_tpl_vars['server_file']['checked']): ?>checked<?php endif; ?> tabindex="1"><?php echo $this->_tpl_vars['server_file']['desc']; ?>
</label>
                        <?php endforeach; endif; unset($_from); ?>
						</div><div class="error" style="display:none"></div>
                        </div>
						</div>
						<div class="info-list">
							<em>状　　态 ：</em>
							<div class="chooses Mtop10">
                                <input type="radio" <?php if ($this->_tpl_vars['item'][@DB_PROJECTS_STATUS] == @PROJECT_STATUS_USE): ?>checked="true"<?php endif; ?> name="<?php echo @PROJECT_INPUT_STATUS; ?>
" tabindex="1" value="<?php echo @PROJECT_STATUS_USE; ?>
"> 启用　
                                <input type="radio" <?php if ($this->_tpl_vars['item'][@DB_PROJECTS_STATUS]): ?>checked="true"<?php endif; ?>name="<?php echo @PROJECT_INPUT_STATUS; ?>
" tabindex="1" value="<?php echo @PROJECT_STATUS_STOP; ?>
"> 停用
                            </div>
						</div>
                        <input type="hidden" name="id" value="<?php echo @CONSOLE_ID; ?>
" />
                        <div class="info-submit"><input type="submit" value="下一步" tabindex="1" class="btn"></div>
					</form>
				</div>
				<div class="CtentFoor"></div>
			</div>
		</div>
	</div>
<script type="text/javascript" src="./static/console/project.js"></script>