<?php /* Smarty version 2.6.26, created on 2014-12-11 14:44:39
         compiled from console/pgroup_create.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'console/pgroup_create.tpl', 12, false),)), $this); ?>
                    <form action="<?php echo @PGROUP_ACTION_DOCREATE; ?>
" method="post" id="project_group_form">
						<div class="info-list">
							<em>项目组名称  ：</em>
							<div class="InputInner">
                                <input type="text" name="<?php echo @PGROUP_INPUT_NAME; ?>
" value="<?php echo $this->_tpl_vars['item'][@DB_PGROUP_NAME]; ?>
" tabindex="1" class="span2"/>
							    <div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list">
							<em>项目组描述  ：</em>
							<div class="textBox">
                                <textarea name="<?php echo @PGROUP_INPUT_GROUP_DESC; ?>
" tabindex="1"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][@DB_PGROUP_DESC])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea>
							    <div class="error" style="display:none"></div>
                            </div>
						</div>
						<div class="info-list">
							<em>状　　态 ：</em>
							<div class="chooses Mtop10">
                               <input type="radio" <?php if ($this->_tpl_vars['item'][@DB_PGROUP_DEL] == @PGROUP_DEL_NOT): ?>checked="true"<?php endif; ?> name="<?php echo @PGROUP_INPUT_IS_DEL; ?>
" tabindex="1" value="<?php echo @PGROUP_DEL_NOT; ?>
"> 启用　
                                <input type="radio" <?php if ($this->_tpl_vars['item'][@DB_PGROUP_DEL] == @PGROUP_DEL_YES): ?>checked="true"<?php endif; ?>name="<?php echo @SERVER_INPUT_IS_DEL; ?>
" tabindex="1" value="<?php echo @PGROUP_DEL_YES; ?>
"> 停用
                            </div>
						</div>
                        <div class="info-submit">
                            <input type="hidden" name="id" value="<?php echo @CONSOLE_ID; ?>
" />
                            <input type="submit" value="下一步" tabindex="1" class="btn">
                        </div>
					</form>
				</div>
				<div class="CtentFoor"></div>
			</div>
		</div>
	</div>