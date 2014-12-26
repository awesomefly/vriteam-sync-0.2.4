<?php /* Smarty version 2.6.26, created on 2014-12-11 14:40:01
         compiled from console/guide_nav.tpl */ ?>
<div class="guide-nav">
    <a href="<?php if ($_SESSION['gd_st1']): ?><?php echo @GUIDE_REDIRECT_STEP1; ?>
<?php endif; ?>" <?php if ($this->_tpl_vars['guide_step'] == @GUIDE_ACT_STEP1): ?>class="Cur"<?php endif; ?>>创建项目</a>
    <a href="<?php if ($_SESSION['gd_st2']): ?><?php echo @GUIDE_REDIRECT_STEP2; ?>
<?php endif; ?>" <?php if ($this->_tpl_vars['guide_step'] == @GUIDE_ACT_STEP2): ?>class="Cur"<?php endif; ?>>配置SVN服务器<?php echo $this->_tpl_vars['guide_step2']; ?>
</a>
    <a href="<?php if ($_SESSION['gd_st3']): ?><?php echo @GUIDE_REDIRECT_STEP3; ?>
<?php endif; ?>" <?php if ($this->_tpl_vars['guide_step'] == @GUIDE_ACT_STEP3): ?>class="Cur"<?php endif; ?>>配置文件服务器</a>
    <a href="<?php if ($_SESSION['gd_st1'] && $_SESSION['gd_st2'] && $_SESSION['gd_st3']): ?><?php echo @GUIDE_REDIRECT_STEP4; ?>
<?php endif; ?>" <?php if ($this->_tpl_vars['guide_step'] == @GUIDE_ACT_STEP4): ?>class="Cur"<?php endif; ?>>综合页</a>
    <a href="/index.php?mod=console.server" class="exit">退出引导</a>
</div>