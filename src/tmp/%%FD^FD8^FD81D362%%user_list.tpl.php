<?php /* Smarty version 2.6.26, created on 2014-12-12 19:16:57
         compiled from console/user_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'console/user_list.tpl', 10, false),)), $this); ?>
                    <table border="0" class="table table-bordered table-striped projectTable">
                        <?php if ($this->_tpl_vars['list']): ?>
						<tr class="trTitle">
						    <td width="150" height="30" align="center"><span class="STYLE1">用户名</span></td>
							<td width="270" height="30" align="center"><span class="STYLE1">用户权限</span></td>
							<td width="60" height="30" align="center"><span class="STYLE1">操作</span></td>
						  </tr>
                        <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                        <tr <?php if ($this->_tpl_vars['item'][@DB_USERS_DEL] == @USER_DEL_YES): ?>style="color:#f00;"<?php endif; ?>>
                            <td width="170" height="30" align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][@DB_USERS_USERNAME])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
                            <td width="160" height="30" align="center">
                            <?php if ($this->_tpl_vars['item']['user_mod']['select_file']): ?>
                                选文件 
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['item']['user_mod']['operate_ticket']): ?>
                                同步上线单 
                            <?php endif; ?>
                            </td>
                            <td width="60" height="30" align="center"><a href="<?php echo @USER_ACTION_CREATE; ?>
&id=<?php echo $this->_tpl_vars['item'][@DB_USERS_ID]; ?>
" class="edits" title="编辑">编辑</a><a href="<?php echo @USER_ACTION_DELETE; ?>
&id=<?php echo $this->_tpl_vars['item'][@DB_USERS_ID]; ?>
" class="del" title="删除" action-type="act-user-del">删除</a></td>
                        </tr>
                        <?php endforeach; endif; unset($_from); ?>
                        <?php else: ?>
                            <p class="none"><img src="../../static/core/img/none.png"> <span>还没用户？赶紧<a href="<?php echo @USER_ACTION_USER; ?>
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
<script type="text/javascript" src="./static/console/user.js"></script>