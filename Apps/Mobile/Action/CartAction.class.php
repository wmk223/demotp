<?php
namespace Mobile\Action;
/**
 * ============================================================================
 * WSTMall开源商城
 * 官网地址:http://www.wstmall.com 
 * 联系QQ:707563272
 * ============================================================================
 * 购物车控制器
 */
class CartAction extends BaseAction {
	/**
	 * 跳到购物车列表
	 */
    public function toCart(){
   		$m = D('Mobile/Cart');
		$cartInfo = $m->getCartInfo();
   		$pnow = (int)I("pnow",0);
   		$this->assign('cartInfo',$cartInfo);
   		$this->display('default/cart_pay_list');

    }
    
    /**
     * 添加商品到购物车(ajax)
     */
	public function addToCartAjax(){
   		$m = D('Mobile/Cart');
   		$res = $m->addToCart();
   		echo json_encode(session("WST_CART"));
    }
    /**
     * 修改购物车商品
     * 
     */
    public function changeCartGoods(){
    	$m = D('Mobile/Cart');
   		$res = $m->addToCart();
   		echo "{status:1}";
    }
    
	/**
	 * 获取购物车信息
	 * 
	 */
	public function getCartInfo() {
		$m = D('Mobile/Cart');
		$cartInfo = $m->getCartInfo();
		$axm = (int)I("axm",0);
		if($axm ==1){
			echo json_encode($cartInfo);
		}else{
			$this->assign('cartInfo',$cartInfo);
			$this->display('default/cart_pay_list');
		}
		
	}
	
	/**
	 * 获取购物车商品数量
	 */
	public function getCartGoodCnt(){
		$shopcart = session("WST_CART")?session("WST_CART"):array();
		echo json_encode(array("goodscnt"=>count($shopcart)));
	}
    
	/**
	 * 检测购物车中商品库存
	 * 
	 */
	public function checkCartGoodsStock(){
		$m = D('Mobile/Cart');
		$res = $m->checkCatGoodsStock();
		echo json_encode($res);

	}
	
	
	
	/**
	 * 删除购物车中的商品
	 * 
	 */
	public function delCartGoods(){	
		$m = D('Mobile/Cart');
		$res = $m->delCartGoods();
		$data['status'] = 1;
		echo json_encode($data);
		
	}
	
	/**
	 * 修改购物车中的商品数量
	 * 
	 */
	public function changeCartGoodsNum(){
			
		$m = D('Mobile/Cart');
		$res = $m->changeCartGoodsnum();
		$data['status'] = 1;
		echo json_encode($data);
		
	}
	
	/**
	 *去购物车结算
	 * 
	 */
	public function toCatpaylist(){	
		$m = D('Mobile/Cart');
		$cartInfo = $goodsmodel->getCartInfo();
		$this->assign("cartInfo",$cartInfo);
		
		$this->display('default/cat_pay_list');
	}
	
}