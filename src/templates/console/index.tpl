{include file="header.tpl"}
<link rel="stylesheet" type="text/css" href="./static/backstage/css/backstage.css">
<!--中间-->
	<div class="Content">
    <!--欢迎-->
		<div class="backstageMain clearfix">
        <!--左侧菜单-->
        {include file="console/left_menu.tpl"}
            <div class="rightContent">
				<div class="CtentTop"></div>
				<div class="CtentMain">
                {include file="console/console_nav.tpl}
                {include file="console/$curr_tpl.tpl"}
{include file="page.footer.tpl"}
{include file="static.core.js.tpl"}
<script type="text/javascript" src="./static/console/{$curr_tpl}.js"></script>
{include file="page.end.tpl"}
