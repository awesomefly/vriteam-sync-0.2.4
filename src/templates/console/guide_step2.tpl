<!--配置svn服务器开始-->
<form id="server_form" action="{$smarty.const.GUIDE_REDIRECT_STEP2}" method="post">
	<div class="info-list clearfix">
		<em>服务器名称  ：</em>
		<div class="InputInner">
            <input type="text" name="{$smarty.const.SERVER_INPUT_DESC}" value="{$smarty.session.gd_st2.dc}" class="span2">
			<div class="error"></div>
        </div>
	</div>
	<div class="info-list clearfix">
		<em>svn地址  ：</em>
		<div class="InputInner">
            <input type="text" name="{$smarty.const.SERVER_INPUT_S_URI}" value="{$smarty.session.gd_st2.si}" class="span2">
			<div class="error"></div>
        </div>
	</div>
	
	{if $smarty.const.SYNC_SVN_TRUNK}
    <div class="info-list clearfix">
        <em>trunk地址   ：</em>
        <div class="InputInner">
            <input type="text" name="{$smarty.const.SERVER_INPUT_TRUNK_URI}" value="{$smarty.session.gd_st2.ti}" class="span2">
			<div class="error"></div>
        </div>
    </div>
	{/if}
    <div class="info-list clearfix">
        <em>用  户   名  ：</em>
        <div class="InputInner">
            <input type="text" name="{$smarty.const.SERVER_INPUT_USER_NAME}" value="{$smarty.session.gd_st2.un}" class="span2">
			<div class="error"></div>
        </div>
    </div>
    <div class="info-list clearfix">
        <em>密       码 ：</em>
        <div class="InputInner">
            <input type="password" name="{$smarty.const.SERVER_INPUT_PASSWORD}" value="{$smarty.session.gd_st2.pd|escape}" class="span2">
			<div class="error"></div>
        </div>
    </div>
    <div class="info-operating">
    <input type="hidden" name="{$smarty.const.SERVER_INPUT_S_TYPE}" value="{$smarty.const.SERVER_TYPE_SVN}" />
        <input type="hidden" name="{$smarty.const.GUIDE_KEY_JUMP}" value="{$jump}" />
        <a href="{$smarty.const.GUIDE_REDIRECT_STEP1}" class="btn">上一步</a>
        <input type="submit" value="下一步" class="btn">
    </div>
</form>
<!--配置svn服务器结束-->
