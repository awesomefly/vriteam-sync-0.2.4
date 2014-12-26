<div class="guide-nav">
    <a href="{if $smarty.session.gd_st1}{$smarty.const.GUIDE_REDIRECT_STEP1}{/if}" {if $guide_step == $smarty.const.GUIDE_ACT_STEP1}class="Cur"{/if}>创建项目</a>
    <a href="{if $smarty.session.gd_st2}{$smarty.const.GUIDE_REDIRECT_STEP2}{/if}" {if $guide_step == $smarty.const.GUIDE_ACT_STEP2}class="Cur"{/if}>配置SVN服务器{$guide_step2}</a>
    <a href="{if $smarty.session.gd_st3}{$smarty.const.GUIDE_REDIRECT_STEP3}{/if}" {if $guide_step == $smarty.const.GUIDE_ACT_STEP3}class="Cur"{/if}>配置文件服务器</a>
    <a href="{if $smarty.session.gd_st1 && $smarty.session.gd_st2 && $smarty.session.gd_st3}{$smarty.const.GUIDE_REDIRECT_STEP4}{/if}" {if $guide_step == $smarty.const.GUIDE_ACT_STEP4}class="Cur"{/if}>综合页</a>
    <a href="/index.php?mod=console.server" class="exit">退出引导</a>
</div>
