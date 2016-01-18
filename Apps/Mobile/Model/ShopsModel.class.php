<?php
namespace Mobile\Model;
/**
 * ============================================================================
 * WSTMall开源商城
 * 官网地址:http://www.wstmall.com 
 * 联系QQ:707563272
 * ============================================================================
 * 店铺服务类
 */
class ShopsModel extends BaseModel {

   /**
	* 获取店铺列表
	*/
	public function shopsList(){
		$rs = M('shops')->field('shopId,shopName,shopImg')->where('shopStatus = 1 and shopFlag=1')->select();
		for($i=0;$i<count($rs);$i++){
			/**
			 * 品牌列表
			 */
			$sql = "SELECT distinct b.brandId,b.brandIco,b.brandName FROM wst_goods AS g ,wst_brands AS b WHERE b.brandId=g.brandId and g.shopId=".$rs[$i]['shopId'];
			$rs[$i]['list'] = $this->query($sql);
		}
		return $rs;
	}

	/**
	 * @param $shopId
	 * @return mixed
	 * 获取店铺的商城分类
	 */
	public function shopsGoodsCatsList($oshopId = 0){
        $shopId = (int)I("shopId");
        $shopId = ($shopId==0)?$oshopId:$shopId;
		$sql = "SELECT distinct c.catId,c.catName,c.cateImg FROM wst_goods AS g ,wst_goods_cats AS c WHERE c.catId=g.goodsCatId1 AND g.shopId=".$shopId;
		$rs = $this->query($sql);
		for($i=0;$i<count($rs);$i++){
			$sql = "SELECT distinct g.goodsCatId2,g.goodsCatId1,c.catName,c.cateImg FROM wst_goods AS g ,wst_goods_cats AS c WHERE c.catId=g.goodsCatId2 and g.goodsCatId1=".$rs[$i]['catId']." AND g.shopId=".$shopId;
			$rs[$i]['list'] = $this->query($sql);
//            for($j=0;$j<count($rs[$i]['list']);$j++){
//                $sql = "SELECT distinct g.goodsCatId3,c.catName,c.cateImg FROM wst_goods AS g ,wst_goods_cats AS c WHERE c.catId=g.goodsCatId3 and g.goodsCatId2=".$rs[$i][$j]['goodsCatId1']." AND g.shopId=".$shopId;
//                $rs[$i]['list'][$j]['child'] = $this->query($sql);
//            }
		}
		return $rs;
	}

    /**
     * @param int $oshopId
     * @return mixed
     *
     * 获取店铺信息
     */
    public function getShopInfo($oshopId = 0){
        $shopId = (int)I("shopId");
        $shopId = ($shopId==0)?$oshopId:$shopId;
        $rs = M('shops')->field('shopId,shopName,shopImg')->where(array('shopId'=>$shopId))->find();
        return $rs;
    }
	 
}