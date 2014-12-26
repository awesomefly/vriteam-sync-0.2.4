<?php /* Smarty version 2.6.26, created on 2014-12-12 19:23:39
         compiled from web/ticket_searchd.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'web/ticket_searchd.tpl', 19, false),)), $this); ?>
<div class="searchMaine">
	<form id="search" action="/index.php" method="GET">
	<!--<div class="searchBox">
		<input type="hidden" value="web.ticket" name="mod">
		<input type="hidden" value="search" name="act">
		<input type="text" value="search" name="key" class="sbox">
		<input type="submit" class="query">
	</div>-->
    <div class="input-append searchBox">
    	<input type="hidden" value="web.ticket" name="mod">
		<input type="hidden" value="search" name="act">
   		<input id="appendedInputButton" type="text" name="key" class="span3">
    	<button class="btn" type="submit">Go!</button>
    </div>
	<ul class="choose">
			<li><label><input name="stype" type="radio" value="username" checked="checked"> 按用户名搜索</label></li>
			<li>
			<div class="dates clearfix">
			<input type="text"  name="bt" value="<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
"><span class="to">--</span>
			<input type="text"  name="et" value="<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
"></div></li>
			<li><input name="stype" type="radio" value="sync" <?php if ($_REQUEST['stype'] == 'sync'): ?>checked="checked"<?php endif; ?>> 最后同步日期</li>
			<li><input name="stype" type="radio" value="update" <?php if ($_REQUEST['stype'] == 'update'): ?>checked="checked"<?php endif; ?>> 文件列表更新日期</li>
	</ul>
	</form>
</div>