<?php /* Smarty version 2.6.26, created on 2014-12-11 14:40:01
         compiled from console/guide_step1.tpl */ ?>
<!--创建项目开始-->
<form id="server_form" action="<?php echo @GUIDE_REDIRECT_STEP1; ?>
" method="post">
    <div class="info-list clearfix">
        <em>项目名称　 ：</em>
        <div class="InputInner">
            <input type="text" name="<?php echo @PROJECT_INPUT_NAME; ?>
" value="<?php echo $_SESSION['gd_st1']['pn']; ?>
" class="span2">
			<div class="error"></div>
        </div>
    </div>
    <div class="info-list clearfix">
        <em>所属项目组  ：</em>
        <div class="InputInner">
            <input type="text" name="<?php echo @PGROUP_INPUT_NAME; ?>
" value="<?php echo $_SESSION['gd_st1']['gn']; ?>
" class="span2">
			<div class="error"></div>
        </div>
    </div>
    <input type="hidden" name="<?php echo @GUIDE_KEY_JUMP; ?>
" value="<?php echo $this->_tpl_vars['jump']; ?>
" />
    <div class="info-operating"><input type="submit" value="下一步" class="btn"></div>
</form>
<!--创建项目结束-->