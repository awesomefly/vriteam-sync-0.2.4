<?php /* Smarty version 2.6.26, created on 2014-12-11 14:45:45
         compiled from web/ticket_detail_sum.tpl */ ?>
<span>当前上线单 id：<?php echo $this->_tpl_vars['ticket'][@WT_ID]; ?>
　创建者：<?php echo $this->_tpl_vars['ticket'][@WT_OW]; ?>
　创建时间：<?php echo $this->_tpl_vars['ticket'][@WT_CT]; ?>
　
 拥有文件的数目：<?php echo $this->_tpl_vars['ticket'][@WT_FC]; ?>
　最后操作的状态：<?php echo $this->_tpl_vars['ticket'][@WT_OP]; ?>
   </span>
<a href="#see" class="history">查看历史>></a>