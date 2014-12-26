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
			<input type="text"  name="bt" value="{$smarty.now|date_format:"%Y-%m-%d"}"><span class="to">--</span>
			<input type="text"  name="et" value="{$smarty.now|date_format:"%Y-%m-%d"}"></div></li>
			<li><input name="stype" type="radio" value="sync" {if $smarty.request.stype == 'sync'}checked="checked"{/if}> 最后同步日期</li>
			<li><input name="stype" type="radio" value="update" {if $smarty.request.stype == 'update'}checked="checked"{/if}> 文件列表更新日期</li>
	</ul>
	</form>
</div>
