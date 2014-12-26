<div class="details">
<div class="details_top"></div>
<div class="details_center">
{foreach from=$history.h_sum item='item'}
<p>项目:{$item[$smarty.const.OP_LIST_KEY_PN]} 文件:{$item[$smarty.const.OP_LIST_KEY_URI]}</p>
{/foreach}
</div>
<div class="details_bottom"></div>
</div>
