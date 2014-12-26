{if $ticket}
<div class="present">
{include file="web/ticket_detail_sum.tpl"}
</div>
<!--{include file="web/ticket_detail_opr.tpl"}-->
<div class="document">
<div class="help clearfix"><a href="##" action-type="act-get-help">帮助</a>
<div class="clearfix"></div>
<div class="helpExplain" style="display:none">
</div>
</div>
<form id="detail_list" action="/index.php?mod=web.ticket&act=delete&id={$ticket[$smarty.const.WT_ID]}" method="POST">
{include file="web/ticket_detail_fls.tpl"}
</form>
<div class="handy">
<input type="checkbox" value="" name="" action-type="all"> 全选
<input type="checkbox" value="" name="" action-type="reverse"> 反选
<!--a href="javascript:;" class="delete btn" action-type="act-delete-file">删除</a--> 
{include file="web/ticket_detail_opr.tpl"}
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
{include file="web/ticket_shell_opr.tpl"}
</div>
</div>
<div class="historyMain">
<div class="see" id="see">查看历史</div>
<ul class="seeList">
{include file="web/ticket_detail_his.tpl"}
</ul>
</div>
{elseif $msg}
<p class="none"><img src="../../static/core/img/none.png" border="0"> <span>{$msg}</span></p>
{else}
<p class="none"><img src="../../static/core/img/none.png" border="0">　<span>上线单{$smarty.const.TICKET_ID}不存在! </span></p>
{/if}
