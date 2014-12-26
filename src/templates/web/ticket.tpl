{include file="header.tpl"}
<link rel="stylesheet" type="text/css" href="/static/frontEnd/css/frontEnd.css">
	<!--中间-->
	<div class="Content">
        <!--前端统一导航-->
		<div class="frontEndMain">
            <!--统一菜单列表-->
            {include file="web/ticket_menu.tpl"}
			<div class="detail">
				<div class="detail_content clearfix">
                    <!--主体模板-->
                    {include file=$curr_tpl}
				</div>
			</div>
		</div>
	</div>
{include file="page.footer.tpl"}
{include file="static.core.js.tpl"}
<script type="text/javascript" src="/static/{$curr_tpl}.js"></script>
{include file="page.end.tpl"}
