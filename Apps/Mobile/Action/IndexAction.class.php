<?php
namespace Mobile\Action;
/**
 * ============================================================================
 * WSTMall开源商城
 * 官网地址:http://www.wstmall.com 
 * 联系QQ:707563272
 * ============================================================================
 * 首页控制器
 */
class IndexAction extends BaseAction {
	/**
	 * 获取首页信息
	 * 
	 */
    public function index(){
//		$url = "http://e7mqxyzk3g.proxy.qqbrowser.cc/index.php/Mobile/Index/Index.html";
//		$redirect_uri = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxad259a42911fa598&redirect_uri='.$url.'&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect';
//		if($_GET['code']){
//			$getAccess_tokenUrl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxad259a42911fa598&secret=039e5f26008ebdd5665a8656191ec9c2&code=".$_GET['code']."&grant_type=authorization_code";
//			$Access_tokenInfo = http_get($getAccess_tokenUrl);
//			$json = json_decode($Access_tokenInfo,true);
//			$getUseInfoUrl = "https://api.weixin.qq.com/sns/userinfo?access_token=".$json['access_token']."&openid=".$json['openid']."&lang=zh_CN";
//			$userInfo = http_get($getUseInfoUrl);
//			$arr = json_decode($userInfo,true);
//			var_dump($arr);
////			$userData =D('Mobile/Users')->getWxId($data['openid']);
////			var_dump($userData);
////			if($userData){
////				if(!empty($user))session('WST_USER',$userData);
////			}else{
//			$userData = array(
//				'wxId'=>$arr['openid'],
//				'userPhoto'=>$arr['headimgurl'],
//				'loginName'=>$arr['openid'],
//				'loginPwd'=>md5($arr['openid']),
//				'userName'=>$arr['nickname'],
//			);
//			var_dump($userData);
//			$rs=M('Users')->add($userData);
//			var_dump($rs);
//				if($rs>0){//注册成功
//					//加载用户信息
//					$user = D('Mobile/Users')->get($arr['userId']);
//					if(!empty($user))session('WST_USER',$user);
//				}
////			}
//		}else{
//			echo "<script language=javascript>window.location.href='".$redirect_uri."'</script>";
//		}

		//index
		$ads = D('Mobile/Ads');
		$areaId2 = $this->getDefaultCity();
		//获取分类
		$gcm = D('Mobile/GoodsCats');
		$this->catList = $gcm->getGoodsCatsAndGoodsForIndex($areaId2);
		//首页主广告
		$this->indexAds = $ads->getAds($areaId2,-1);
		//主页新上架商品
		$this->goods = D('Mobile/Goods')->getNewtimeGoodlist();
		$this->brands = D('Mobile/Brands')->indexBrands();
		if(I("changeCity")){
			echo $_SERVER['HTTP_REFERER'];
		}else{
			$this->display("default/index");
		}
//
//		}else{
//			echo "<script language=javascript>window.location.href='".$redirect_uri."'</script>";
//		}
    }
    /**
     * 广告记数
     */
    public function access(){
    	$ads = D('Mobile/Ads');
    	$ads->statistics((int)I('id'));
    }
    /**
     * 切换城市
     */
    public function changeCity(){
    	$m = D('Mobile/Areas');
    	$areaId2 = $this->getDefaultCity();
    	$provinceList = $m->getProvinceList();
    	$cityList = $m->getCityGroupByKey();
    	$area = $m->getArea($areaId2);
    	$this->assign('provinceList',$provinceList);
    	$this->assign('cityList',$cityList);
    	$this->assign('area',$area);
    	$this->assign('areaId2',$areaId2);
    	$this->display("default/change_city");
    }
    /**
     * 跳到用户注册协议
     */
    public function toUserProtocol(){
    	$this->display("default/user_protocol");
    }
    
    /**
     * 修改切换城市ID
     */
    public function reChangeCity(){
    	$this->getDefaultCity();
    }
}