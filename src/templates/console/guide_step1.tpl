<!--创建项目开始-->
<form id="server_form" action="{$smarty.const.GUIDE_REDIRECT_STEP1}" method="post">
    <div class="info-list clearfix">
        <em>项目名称　 ：</em>
        <div class="InputInner">
            <input type="text" name="{$smarty.const.PROJECT_INPUT_NAME}" value="{$smarty.session.gd_st1.pn}" class="span2">
			<div class="error"></div>
        </div>
    </div>
    <div class="info-list clearfix">
        <em>所属项目组  ：</em>
        <div class="InputInner">
            <input type="text" name="{$smarty.const.PGROUP_INPUT_NAME}" value="{$smarty.session.gd_st1.gn}" class="span2">
			<div class="error"></div>
        </div>
    </div>
    <input type="hidden" name="{$smarty.const.GUIDE_KEY_JUMP}" value="{$jump}" />
    <div class="info-operating"><input type="submit" value="下一步" class="btn"></div>
</form>
<!--创建项目结束-->
