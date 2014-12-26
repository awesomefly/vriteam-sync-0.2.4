{include file="header.tpl"}
<link rel="stylesheet" type="text/css" href="./static/guide/css/guide.css">
	<!--中间-->
	<div class="Content">
   		<div class="guideInfo clearfix">
        {if $guide_step != $smarty.const.GUIDE_ACT_STEP4}
		    <!--配置开始-->
			<div class="guideInfo-top"></div>
			<div class="guideInfo-middle">
				<div class="guideInfo-left">
					{if $curr_tpl != 'console/guide_index.tpl'}{include file="console/guide_nav.tpl"}{/if}
					{include file="$curr_tpl"}
				</div>
				{* 帮助模板 *} 
            	{include file="console/guide_`$guide_step`_help.tpl"}
			</div>
			<div class="guideInfo-bottom"></div>	
		    <!--配置结束-->
		    {else}
           		{include file="console/guide_step4.tpl"}
        	{/if}
		</div>
	</div>
{include file="page.footer.tpl"}
{include file="static.core.js.tpl"}
<script type="text/javascript" src="./static/{$curr_tpl}.js"></script>
{include file="page.end.tpl"}
