<?php
/**
                +------------------------------------------------------------------------------+
                |                           上线系统       授权协议                            |
                |                  版权所有(c) 2013 VRITEAM团队. 保留所有权利                  |
                +------------------------------------------------------------------------------+
                |本软件的著作权归VRITEAM团队所有。具体使用许可请看软件包中的LICENSE文件。或者访|
                |问我们的网站http://www.vriteam.com/sync/license。我们欢迎给使用并给我们提出宝 |
                |贵的意见和建议。感谢团队中的成员为项目所做的努力！                            |
                +------------------------------------------------------------------------------+
                |                               作者：VRITEAM团队                              |
                +------------------------------------------------------------------------------+

 */
/**
 * 分页类
 */
class Page {
    private $first_page     = 1; //分页起始行数 
    private $first_row;          //分页起始条数
    private $per_page       = 10;//每页显示条数
    private $total_count    = 0; //总条数
    private $total_pages    = 0; //总页数
    private $now_page       = 1; //当前页
    private $next_page      = '';//下一页
    private $pre_page       = '';//上一页
    private $is_last_page   = false;
    private $is_first_page  = false;
    private $pre_page_url   = '';
    private $next_page_url  = '';

    /**
     * 构造函数
     */
    function __construct($per_page, $total_count) {
        $this->total_count  = $total_count;
        $this->per_page     = $per_page;
        $this->now_page     = ( (int)$_REQUEST['p'] > 0 ) ? (int)$_REQUEST['p'] : 1;
        $this->total_pages  = ceil($this->total_count / $this->per_page);
        if ( $this->now_page >= $this->total_pages ) 
            $this->is_last_page = true;
        if ( $this->now_page == $this->first_page ) 
            $this->is_first_page = true;
        $this->first_row    = ($this->now_page - 1) * $this->per_page;
        if ( !$this->is_first_page )
            $this->pre_page = $this->now_page - 1;
        if ( !$this->is_last_page )
            $this->next_page = $this->now_page + 1;
    }
    /**
     * 对外输出函数
     */
    public function show() {
        if ( $this->total_pages == 0 || $this->total_count == 0 ) return ;
        $this->get_url();
        $pre_page_str       = $this->get_pre_page_str();
        $current_page_str   = $this->get_current_page_str();
        $next_page_str      = $this->get_next_page_str();
        return $pre_page_str . $current_page_str . $next_page_str;
    }

    /**
     * 获取当前分页展示信息
     */
    public function get_current_page_str() {
        $ret_str = '';
        for ( $i=1;$i<$this->now_page;$i++ ) {
            $ret_str .= '<a href=' . $this->get_page_url($i) . ' class="number"><span>' . $i . '</span></a>';
        }
        $ret_str .= '<a href=' . $this->get_page_url($this->now_page) . ' class="number Cur"><span>' . $this->now_page . '</span></a>';
        if ( $this->next_page > 0 ) {
            for ( $i=$this->next_page;$i<=$this->total_pages;$i++ ) {
                $ret_str .= '<a href=' . $this->get_page_url($i) . ' class="number"><span>' . $i . '</span></a>';
            }
        }

        return $ret_str;
    }

    /**
     * 获取上一页
     */
    public function get_pre_page_str() {
        if ( $this->pre_page )
            return '<a href=' . $this->get_page_url($this->pre_page) . ' class="prev"><span>Previous</span></a>';
    }

    /**
     * 获取下一页
     */
    public function get_next_page_str() {
        if ( $this->next_page )
            return '<a href=' . $this->get_page_url($this->next_page) . ' class="next"><span>Next</span></a>';
    }

    /**
     *获取网页地址 
     */
    private function get_url() {
        $url = $_SERVER['REQUEST_URI'] . (strpos($_SERVER['REQUEST_URI'], '?') ? '' : "?") .
            (strpos($_SERVER['REQUEST_URI'], $this->parameter) === false ? $this->parameter : '');
        $this->url    = preg_replace("/&p=[0-9]+/",'',$url);
    }

    /**
     * 根据页码获取其对应的url地址
     */
    private function get_page_url($curr_page) {
        if ( strpos($this->url, "?") === false ) {
            return $this->url . "?p=" . $curr_page;
        } else {
            return $this->url . "&p=" . $curr_page;
        }
    }

    /**
     * 获取分页limit限制的数据段
     */
    function get_limit($page = NULL) {
        $limit_str = '';
        if ( (int)$page > 0 && (int)$this->per_page > 0 ) {
            $start = ($page - 1) * $this->per_page;
            return " limit $start, $this->per_page";
        } 
        return $limit_str;
    }
}
