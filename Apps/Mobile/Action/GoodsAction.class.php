<?php
namespace Mobile\Action;
/**
 * ============================================================================
 * WSTMall开源商城
 * 官网地址:http://www.wstmall.com 
 * 联系QQ:707563272
 * ============================================================================
 * 商品控制器
 */
class GoodsAction extends BaseAction
{
	/**
	 * 所有商品列表
	 */
	public function GoodsList(){
		$this->data = json_encode(D('Mobile/Goods')->getGoodsList());
		$this->display('default/goods_list');
	}
	/**
	 * 所有商品瀑布流
	 */
	public function getAjaxGoodsList(){
		$data = D('Mobile/Goods')->getAjaxGoodsList();
		if($data){
			$rs['ok']=1;
			$rs['res'] = $data;
		}else{
			$rs['ok']=0;
		}
		$this->ajaxReturn($rs);
	}

	/**
	 * 品牌商品列表
	 */
	public function getBrandsGoodsList()
	{
		$this->data = json_encode(D('Mobile/Goods')->getBrandsGoodsList());
		$this->brandsId = ((int)I("brandId")==0)?0:(int)I("brandId");
		$this->display('default/goods_brands_list');
	}
	/**
	 * 品牌瀑布流加载
	 */
	public function getAjaxBrandsGoodsList(){
		$data = D('Mobile/Goods')->getAjaxBrandsGoodsList();
		if($data){
			$rs['ok']=1;
			$rs['res'] = $data;
		}else{
			$rs['ok']=0;
		}
		$this->ajaxReturn($rs);
	}
	/**
	 * 商城分类商品列表
	 */
	public function getCatsGoodsList(){
		$this->data = json_encode(D('Mobile/Goods')->getCatGoodsList());
		$this->catId = ((int)I("catId")==0)?0:(int)I("catId");
		$this->display('default/goods_cats_list');
	}
	/**
	 * 商城分类商品列表流加载
	 */
	public function getAjaxCatGoodsList(){
		$data = D('Mobile/Goods')->getAjaxCatGoodsList();
		if($data){
			$rs['ok']=1;
			$rs['res'] = $data;
		}else{
			$rs['ok']=0;
		}
		$this->ajaxReturn($rs);
	}
	/**
	 * 店铺品牌商品列表
	 */
	public function getShopsBrandsGoodsList(){
		$this->data = json_encode(D('Mobile/Goods')->getShopsBrandsGoodsList());
		$this->brandsId = ((int)I("brandId")==0)?0:(int)I("brandId");
		$this->shopId = ((int)I("shopId")==0)?0:(int)I("shopId");
		$this->display('default/goods_shops_brands_list');
	}
	/**
	 * 店铺品牌商品列表流加载
	 */
	public function getAjaxShopsBrandsGoodsList(){
		$data = D('Mobile/Goods')->getAjaxShopsBrandsGoodsList();
		if($data){
			$rs['ok']=1;
			$rs['res'] = $data;
		}else{
			$rs['ok']=0;
		}
		$this->ajaxReturn($rs);
	}
	/**
	 * 店铺商城分类列表
	 */
	public function getShopsGoodsCatGoodsList(){
		$this->data = json_encode(D('Mobile/Goods')->getShopsGoodsCatGoodsList());
		$this->catId = ((int)I("catId")==0)?0:(int)I("catId");
		$this->shopId = ((int)I("shopId")==0)?0:(int)I("shopId");
		$this->display('default/goods_shops_cats_list');
	}
	/**
	 * 店铺商城分类商品列表流加载
	 */
	public function getAjaxShopsGoodsCatGoodsList(){
		$data = D('Mobile/Goods')->getAjaxShopsGoodsCatGoodsList();
		if($data){
			$rs['ok']=1;
			$rs['res'] = $data;
		}else{
			$rs['ok']=0;
		}
		$this->ajaxReturn($rs);
	}
	/**
	 * 查询商品详情
	 *
	 */
	public function getGoodsDetails()
	{
		$goods = D('Mobile/Goods');

		//查询商品详情		
		$goodsId = (int)I("goodsId");
		$this->assign('goodsId', $goodsId);
		$obj["goodsId"] = $goodsId;
		$goodsDetails = $goods->getGoodsDetails($obj);
		$goodsDetails['goodsDesc'] = htmlspecialchars_decode($goodsDetails['goodsDesc']);

		$shopId = intval($goodsDetails["shopId"]);
		$obj["shopId"] = $shopId;
		$obj["areaId2"] = $this->getDefaultCity();
		$obj["attrCatId"] = $goodsDetails['attrCatId'];
		$this->assign("goodsAttrs",$goods->getAttrs($obj));

		$goodsApp = D('Mobile/GoodsAppraises');
		$this->goodsApp = $goodsApp->getGoodsAppraises($goodsId);
		$this->assign("goodsImgs", $goods->getGoodsImgs());
		$goodsBrand=$goods->getGoodsBrands($obj["goodsId"]);
		$goodsBrand['brandDesc'] = htmlspecialchars_decode($goodsBrand['brandDesc']);
		$goodsShop=$goods->getGoodsShops($obj["goodsId"]);
		$goodsShop['brandDesc'] = htmlspecialchars_decode($goodsShop['brandDesc']);
		$this->assign("goodsBrand", $goodsBrand);
		$this->assign("goodsShop", $goodsShop);
		$this->assign("goodsDetails", $goodsDetails);
		$this->display('default/goods_details');

	}

	/**
	 * 获取商品库存
	 *
	 */
	public function getGoodsStock()
	{
		$data = array();
		$data['goodsId'] = (int)I('goodsId');
		$data['isBook'] = (int)I('isBook');
		$data['goodsAttrId'] = (int)I('goodsAttrId');
		$goods = D('Mobile/Goods');
		$goodsStock = $goods->getGoodsStock($data);
		echo json_encode($goodsStock);

	}

	/**
	 * 获取服务社区
	 *
	 */
	public function getServiceCommunitys()
	{

		$areas = D('Mobile/Areas');
		$serviceCommunitys = $areas->getShopCommunitys();
		echo json_encode($serviceCommunitys);
	}

	/**
	 * 分页查询-出售中的商品
	 */
	public function queryOnSaleByPage()
	{
		$this->isShopLogin();
		$USER = session('WST_USER');
		//获取商家商品分类
		$m = D('Mobile/ShopsCats');
		$this->assign('shopCatsList', $m->queryByList($USER['shopId'], 0));
		$m = D('Mobile/Goods');
		$page = $m->queryOnSaleByPage($USER['shopId']);
		$pager = new \Think\Page($page['total'], $page['pageSize']);
		$page['pager'] = $pager->show();
		$this->assign('Page', $page);
		$this->assign("umark", "queryOnSaleByPage");
		$this->assign("shopCatId2", I('shopCatId2'));
		$this->assign("shopCatId1", I('shopCatId1'));
		$this->assign("goodsName", I('goodsName'));
		var_dump(shopCatsList);
//		$this->display("default/shops/goods/list_onsale");
	}
}