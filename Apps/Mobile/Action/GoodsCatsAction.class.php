<?php
 namespace Mobile\Action;
/**
 * ============================================================================
 * WSTMall开源商城
 * 官网地址:http://www.wstmall.com 
 * 联系QQ:707563272
 * ============================================================================
 * 商品分类控制器
 */
class GoodsCatsAction extends BaseAction{
	/**
	 * 一级列表查询
	 */
    public function oneCateList(){
		$m = D('Mobile/GoodsCats');
		$this->list = $m->queryByList((int)I('id'));
		$this->display("default/one_cate");
	}
	/**
	 * 二级列表查询
	 */
	public function twoCateList(){
		$m = D('Mobile/GoodsCats');
		$this->data = $m->queryById((int)I('id'));
		$this->list = $m->queryErByList((int)I('id'));
		$this->display("default/two_cate");
	}
}
?>