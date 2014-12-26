<?php /* Smarty version 2.6.26, created on 2014-12-11 14:44:28
         compiled from console/project_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'console/project_list.tpl', 12, false),array('modifier', 'truncate', 'console/project_list.tpl', 33, false),)), $this); ?>
				    <table  border="0" class="table table-bordered table-striped projectTable">
                        <?php if ($this->_tpl_vars['list']): ?>
					    <tr>
							<td width="110" height="30" align="center"><span class="STYLE1">项目名称</span></td>
							<td width="150" height="30" align="center"><span class="STYLE1">所属项目组</span></td>
							<td width="140" height="30" align="center"><span class="STYLE1">svn服务器</span></td>
							<td width="130" height="30" align="center"><span class="STYLE1">文件服务器</span></td>
							<td width="60" height="30" align="center"><span class="STYLE1">操作</span></td>
						</tr>
                        <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                        <tr <?php if ($this->_tpl_vars['item'][@DB_PROJECTS_STATUS] == PROJECT_STATUS_STOP): ?>style="color:#f00;"<?php endif; ?>>
                            <td  width="130" height="30" align="center" title=<?php echo $this->_tpl_vars['item'][@DB_PROJECTS_NAME]; ?>
><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][@DB_PROJECTS_NAME])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
                            <td  width="170" height="30" align="center" title=<?php echo $this->_tpl_vars['item']['group_info'][@DB_PGROUP_NAME]; ?>
><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['group_info'][@DB_PGROUP_NAME])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
                            <td  width="155" height="30" align="center" title=<?php echo $this->_tpl_vars['item']['server_svn_list']['s_desc']; ?>
>
                            <?php if ($this->_tpl_vars['item']['server_svn_list']): ?>
                                <?php echo $this->_tpl_vars['item']['server_svn_list']['s_desc']; ?>

                            <?php else: ?>
                                无
                            <?php endif; ?>
                            </td>
                            <td  width="140" height="30" align="center" action-type="act-server-info">
                            <?php if ($this->_tpl_vars['item']['server_count'] > 1): ?>
                                <?php echo $this->_tpl_vars['item']['server_count']; ?>

                                <div class="server-list" style="display:none;">
                                <ul>
                                <?php $_from = $this->_tpl_vars['item']['server_file_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['file_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['file_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['file_server']):
        $this->_foreach['file_list']['iteration']++;
?>
                                    <li><?php echo $this->_foreach['file_list']['iteration']; ?>
：<?php echo $this->_tpl_vars['file_server']['s_desc']; ?>
</li>
                                <?php endforeach; endif; unset($_from); ?>
                                </ul>
                            <?php elseif ($this->_tpl_vars['item']['server_count'] == 1): ?>
                                <ul>
                                <?php $_from = $this->_tpl_vars['item']['server_file_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['file_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['file_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['file_server']):
        $this->_foreach['file_list']['iteration']++;
?>
                                    <li title=<?php echo $this->_tpl_vars['file_server']['desc']; ?>
><?php echo ((is_array($_tmp=$this->_tpl_vars['file_server']['s_desc'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 8) : smarty_modifier_truncate($_tmp, 8)); ?>
</li>
                                <?php endforeach; endif; unset($_from); ?>
                                </ul>
                            <?php else: ?>
                                无
                            <?php endif; ?>
                            </div>
                            </td>
                            <td>
                                <a href="<?php echo @PROJECT_ACTION_CREATE; ?>
&id=<?php echo $this->_tpl_vars['item'][@DB_PROJECTS_ID]; ?>
" class="edits" title="编辑">【编辑】</a>
                                <a href="<?php echo @PROJECT_ACTION_DELETE; ?>
&id=<?php echo $this->_tpl_vars['item'][@DB_PROJECTS_ID]; ?>
" class="del" title="删除" action-type="act-project-del">【删除】</a>
                            </td>
                        </tr>
                    <?php endforeach; endif; unset($_from); ?>
                    <?php else: ?>
                        <p class="none"><img src="../../static/core/img/none.png"><span>还没有创建项目？赶紧<a href="<?php echo @PROJECT_ACTION_PROJECT; ?>
">创建</a>一个吧！</span></p>
                    <?php endif; ?>
			       </table>
                   <?php if ($this->_tpl_vars['list']): ?>
                      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "console/page.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                   <?php endif; ?>

				</div>
				<div class="CtentFoor"></div>
			</div>
		</div>
	</div>
<script type="text/javascript" src="./static/console/project.js"></script>