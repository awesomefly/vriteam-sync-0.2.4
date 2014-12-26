    <form id="guide_step4" action="{$smarty.const.GUIDE_REDIRECT_STEP4}" method="post">
	    <div class="whole">
			<div class="Oneblock">
				<div class="blocktop"></div>
					<div class="blockMain">
						<h2>项目信息</h2>
						<ul>
							<li><em>项目名称： </em><span>{$smarty.session.gd_st1.pn}</span></li>
							<li><em>所属项目组： </em><span>{$smarty.session.gd_st1.gn}</span></li>
							<li><em>svn服务器： </em><span>{$smarty.session.gd_st2.dc}</span></li>
							<li><em>文件服务器： </em><span>{$smarty.session.gd_st3.dc}</span></li>
							<li class="modify"><a href="{$smarty.const.GUIDE_REDIRECT_STEP1}&jump={$smarty.const.GUIDE_ACT_STEP4}" class="btn">我要修改</a></li>
						</ul>
					</div>
					<div class="blockFoor"></div>
				</div>
				<div class="Oneblock">
					<div class="blocktop"></div>
					<div class="blockMain">
						<h2>配置SVN服务器</h2>
						<ul>
							<li><em>服务器描述：</em><span>{$smarty.session.gd_st2.dc}</span></li>
							<li><em>svn地址： </em><span>{$smarty.session.gd_st2.si}</span></li>
							{if $smarty.const.SYNC_SVN_TRUNK}
							<li><em>trunk地址： </em><span>{$smarty.session.gd_st2.ti}</span></li>
							{/if}
							<li><em>用户名： </em><span>{$smarty.session.gd_st2.un}</span></li>
							<li><em>密　码： </em><span>{$smarty.session.gd_st2.pd|escape}</span></li>
							<li class="modify"><a href="{$smarty.const.GUIDE_REDIRECT_STEP2}&jump={$smarty.const.GUIDE_ACT_STEP4}" class="btn">我要修改</a></li>
						</ul>
					</div>
					<div class="blockFoor"></div>
				</div>
				<div class="Oneblock">
					<div class="blocktop"></div>
					<div class="blockMain">
						<h2>文件服务器信息</h2>
						<ul>
							<li><em>服务器描述：</em><span>{$smarty.session.gd_st3.dc}</span></li>
							<li><em>IP地址： </em><span>{$smarty.session.gd_st3.ip}</span></li>
							<li><em>端口： </em><span>{$smarty.session.gd_st3.pt}</span></li>
							<li><em>文件部署根路径 ：</em><span>{$smarty.session.gd_st3.px}</span></li>
							<li><em>用户名： </em><span>{$smarty.session.gd_st3.un}</span></li>
							<li><em>密　码： </em><span>{$smarty.session.gd_st3.pd|escape}</span></li>
							<li class="modify"><a href="{$smarty.const.GUIDE_REDIRECT_STEP3}&jump={$smarty.const.GUIDE_ACT_STEP4}" class="btn">我要修改</a></li>
						</ul>
					</div>
					<div class="blockFoor"></div>
				</div>
				<div class="theEnd"><input type="submit" value="最终确认修改" class="btn"></div>
	            <input type="hidden" name="guide_st" value="step4">
	        </div>
	    </form>
