<!--配置文件服务器开始-->
<form id="server_form" action="{$smarty.const.GUIDE_REDIRECT_STEP3}" method="post">
    <div class="info-list clearfix">
        <em>服务器名称  ：</em>
        <div class="InputInner">
            <input type="text" name="{$smarty.const.SERVER_INPUT_DESC}" value="{$smarty.session.gd_st3.dc}" class="span2">
			<div class="error"></div>
        </div>
    </div>
    <div class="info-list clearfix">
        <em>IP地址  ：</em>
        <div class="InputInner">
            <input type="text" name="{$smarty.const.SERVER_INPUT_IP_URL}" value="{$smarty.session.gd_st3.ip}" class="span2">
			<div class="error"></div>
        </div>
    </div>
    <div class="info-list clearfix">
        <em>端口  ：</em>
        <div class="InputInner">
            <input type="text" name="{$smarty.const.SERVER_INPUT_PORT}" value="{if $smarty.session.gd_st3.pt}{$smarty.session.gd_st3.pt}{else}22{/if}" class="span2">
			<div class="error"></div>
        </div>
    </div>
    <div class="info-list clearfix">
        <em>项目根路径 ：</em>
        <div class="InputInner">
            <input type="text" name="{$smarty.const.SERVER_INPUT_PREFIX}" value="{$smarty.session.gd_st3.px}" class="span2">
			<div class="error"></div>
        </div>
    </div>
    <div class="info-list clearfix">
        <em>用  户   名  ：</em>
        <div class="InputInner">
            <input type="text" name="{$smarty.const.SERVER_INPUT_USER_NAME}" value="{$smarty.session.gd_st3.un}" class="span2">
			<div class="error"></div>
        </div>
    </div>
    <div class="info-list clearfix">
        <em>密       码 ：</em>
        <div class="InputInner">
            <input type="password" name="{$smarty.const.SERVER_INPUT_PASSWORD}" value="{$smarty.session.gd_st3.pd|escape}" class="span2">
			<div class="error"></div>
        </div>
    </div>
    <div class="info-operating">
        <input type="hidden" name="{$smarty.const.SERVER_INPUT_S_TYPE}" value="{$smarty.const.SERVER_TYPE_FILE}" />
        <input type="hidden" name="{$smarty.const.GUIDE_KEY_JUMP}" value="{$jump}" />
        <a href="{$smarty.const.GUIDE_REDIRECT_STEP2}" class="btn">上一步</a>
        <input type="submit" value="下一步" class="btn">
    </div>
</form>
<!--文件服务器结束-->
