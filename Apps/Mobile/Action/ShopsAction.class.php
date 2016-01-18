<?php
namespace Mobile\Action;
/**
 * ============================================================================
 * WSTMall开源商城
 * 官网地址:http://www.wstmall.com 
 * 联系QQ:707563272
 * ============================================================================
 * 店铺控制器
 */
class ShopsAction extends BaseAction {

	/**
     * 跳到店铺街
     */
	public function toShopStreet(){
		$this->list=D('Mobile/Shops')->shopsList();
		$this->display("default/shops_list");
	}
	/**
	 * 店铺商城买的商城分类
	 */
	public function toShopGoodsCats(){
		$this->list=D('Mobile/Shops')->shopsGoodsCatsList();
		$this->data=D('Mobile/Shops')->getShopInfo();
		$this->display("default/shops_GoodsCat");
	}
	
	
}