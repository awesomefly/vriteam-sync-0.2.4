<?php /* Smarty version 2.6.26, created on 2014-12-11 14:44:49
         compiled from console/server_list.tpl */ ?>
				    <table width="660" border="0" class="table table-bordered table-striped projectTable">
                        <?php if ($this->_tpl_vars['list']): ?>
					    <tr class="trTitle">
							<td width="200" height="30" align="center"><span class="STYLE1">server描述</span></td>
							<td width="150" height="30" align="center"><span class="STYLE1">用户名</span></td>
							<td width="150" height="30" align="center"><span class="STYLE1">服务器类型</span></td>
							<td width="60" height="30" align="center"><span class="STYLE1">操作</span></td>
						</tr>
                        <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                        <tr action-type="act-server-info" action-data <?php if ($this->_tpl_vars['item'][@SVN_INFO_KEY_CLOSE] == @SERVER_CLOSE_TRUE): ?>style="color:red;"<?php endif; ?>>
                            <td width="200" height="30" align="center" title=<?php echo $this->_tpl_vars['item'][@SVN_INFO_KEY_DESC]; ?>
><?php echo $this->_tpl_vars['item'][@SVN_INFO_KEY_DESC]; ?>
</td>
                            <td width="150" height="30" align="center"><?php echo $this->_tpl_vars['item'][@SYNC_SERVER_INFO_KEY_USERNAME]; ?>
</td>
                            <td width="150" height="30" align="center"><?php if ($this->_tpl_vars['item'][@SVN_INFO_KEY_SVNSE]): ?>SVN<?php elseif ($this->_tpl_vars['item'][@SVN_INFO_KEY_FILESE]): ?>FILE<?php endif; ?></td>
                            <td width="60" height="30" align="center">
				<a href="<?php echo @SERVER_ACTION_CREATE; ?>
&id=<?php echo $this->_tpl_vars['item'][@SYNC_SERVER_INFO_KEY_ID]; ?>
" class="edits" title="编辑">编辑</a>
				<a href="<?php echo @SERVER_ACTION_DELETE; ?>
&id=<?php echo $this->_tpl_vars['item'][@SYNC_SERVER_INFO_KEY_ID]; ?>
" class="del" action-type="act-server-del" title="删除" >删除</a>
				</td>
				</tr>
                        <?php endforeach; endif; unset($_from); ?>
                        <?php else: ?>
                            <p class="none"><img src="/static/core/img/none.png"><span>还没有服务器？赶紧<a href="<?php echo @SERVER_ACTION_SERVER; ?>
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