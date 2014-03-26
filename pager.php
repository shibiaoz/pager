<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhangshibiao
 * Date: 14-3-26
 * Time: 下午9:52
 * To change this template use File | Settings | File Templates.
 */
class pager{
    public $total;
    public $start;
    public $end;
    public $cur;
    public $default;
    public $url;
    public function __construct($total,$cur='1',$url='?p=',$default='5'){
           $this->total = $total;
           $this->url = $url;
           $this->cur = $cur;
           $this->default = $default;//左边有多少页  5页 总共有10页
           $this->init();
           $this->order();
        error_reporting(E_ALL^E_NOTICE);
    }
    function init(){
        if($this->cur > $this->total){
            $this->cur = $this->total;
        }
    }
    function order(){
        if($this->total <= 2*$this->default){
              $this->start = 1;
            $this->end = $this->total;
        }else{
              if($this->cur <= $this->default){
                  $this->start = 1;
                  $this->end = 2*$this->default;
              }else{
                  if($this->cur > $this->default && ($this->total-$this->cur) >= $this->default-1){
                      $this->start = $this->cur- $this->default + 1;
                      $this ->end = $this->cur + $this->default -1;
                  }else{
                      $this->start = $this->total - 2 * $this->default + 1;
                      $this->end = $this->total;
                  }
              }
        }
    }
    function show(){
        if($this->total<=0){
            return false;
        }
        $re = '<div class="page">';
        $re.="<a href=\"{$this->url}\">首页</a>";
        if($this->cur==1){
            $re = '<div class="page">';
        }
        for ($i = $this->start; $i <= $this->end; $i++) {
            $re .= ($i == $this->cur)? "$i ": "<a href=\"{$this->url}$i\">$i </a> ";
        }
        $next = ($this->cur + 1 >= $this->total) ? $this->total : ($this->cur + 1);
        //当前页是最后一页的页数,不要下一页和最后一页
        if ($this->cur != $this->total) {
            $re .= "<a href=\"{$this->url}$next\">下一页</a> ";
            $re .= "<a href=\"{$this->url}$this->total\">最后一页</a>";
        }
        return $re;
    }
}
header("Content-type: text/html; charset=utf-8");
$p = $_GET['p'];
$total =8;
$page = new pager($total,$p);
echo $page->show();


?>
