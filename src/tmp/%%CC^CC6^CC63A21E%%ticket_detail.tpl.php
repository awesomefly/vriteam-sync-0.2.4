<?php /* Smarty version 2.6.26, created on 2014-12-26 15:53:29
         compiled from web/ticket_detail.tpl */ ?>
<?php if ($this->_tpl_vars['ticket']): ?>
<div class="present">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "web/ticket_detail_sum.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<!--<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "web/ticket_detail_opr.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>-->
<div class="document">
<div class="help clearfix"><a href="##" action-type="act-get-help">帮助</a>
<div class="clearfix"></div>
<div class="helpExplain" style="display:none">
</div>
</div>
<form id="detail_list" action="/index.php?mod=web.ticket&act=delete&id=<?php echo $this->_tpl_vars['ticket'][@WT_ID]; ?>
" method="POST">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "web/ticket_detail_fls.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</form>
<div class="handy">
<input type="checkbox" value="" name="" action-type="all"> 全选
<input type="checkbox" value="" name="" action-type="reverse"> 反选
<!--a href="javascript:;" class="delete btn" action-type="act-delete-file">删除</a--> 
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "web/ticket_detail_opr.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</div>
<div class="document">
<ul class="shellfileList act-shellfile-list">
	<li>
	<input type="checkbox" name="shellfiles[]" value="" tabindex="1"/>
	<span>
		1.项目：<strong>帐号-eg</strong>，
		日期：2014-12-24 16:14:00
		</br>
		路径:<em id="s_path">/home/root1/restart.sh</em>
	</span>
	</li>
</ul>
<div class="handy">
<input type="checkbox" value="" name="" action-type="all-shell"> 全选
<input type="checkbox" value="" name="" action-type="reverse-shell"> 反选
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "web/ticket_shell_opr.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</div>
<div class="historyMain">
<div class="see" id="see">查看历史</div>
<ul class="seeList">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "web/ticket_detail_his.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</ul>
</div>
<?php elseif ($this->_tpl_vars['msg']): ?>
<p class="none"><img src="../../static/core/img/none.png" border="0"> <span><?php echo $this->_tpl_vars['msg']; ?>
</span></p>
<?php else: ?>
<p class="none"><img src="../../static/core/img/none.png" border="0">　<span>上线单<?php echo @TICKET_ID; ?>
不存在! </span></p>
<?php endif; ?>