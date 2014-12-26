{include file="header.tpl"}
<link rel="stylesheet" type="text/css" href="/static/backstage/css/backstage.css">
<!--中间-->
	<div class="Content">
    <!--欢迎-->
		<div class="backstageMain clearfix">
        <!--左侧菜单-->
        {include file="console/left_menu.tpl"}
            <div class="rightContent">
				<div class="CtentMain clearfix">
                {include file="console/console_nav.tpl}
                {include file="$curr_tpl"}
{include file="page.footer.tpl"}
{include file="static.core.js.tpl"}
<script type="text/javascript" src="/static/{$smarty.const.CURR_MOD}.js"></script>
{include file="page.end.tpl"}
