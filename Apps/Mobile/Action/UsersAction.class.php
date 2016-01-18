<?php
namespace Mobile\Action;
/**
 * ============================================================================
 * WSTMall开源商城
 * 官网地址:http://www.wstmall.com 
 * 联系QQ:707563272
 * ============================================================================
 * 会员控制器
 */
class UsersAction extends BaseAction {

   /**
    * 会员中心页面
    */
	public function index(){
		$this->isUserLogin();
		$USER = session('WST_USER');
		$m = D('Mobile/UserAddress');
		$this->list = $m->queryByList($USER['userId']);
		$this->user=session('WST_USER');
		$this->display("default/users/index");
	}
	/**
	 * 用户地址选择
	 */
	public function selectAdress(){
		$this->isUserLogin();
		$this->rnd=I('rnd');
		$m = D('Mobile/UserAddress');
		$USER = session('WST_USER');
		$this->list = $m->queryByList($USER['userId']);
		$this->display("default/users/useraddress/list");
	}
	/**
	 * 用户的收货默认地址
	 */
	public function isDefault(){
		$rs=I('addressId');
		$arr = array(
			'isDefault'=>1
		);
		$arrIsDefault = array(
			'isDefault'=>0
		);
		$m = M('user_address');
		if($m->where('userId='.(int)session('WST_USER.userId'))->save($arrIsDefault)){
			if($m->where(array('addressId'=>$rs))->save($arr)){
				$data['ok']=1;
			}else{
				$data['ok']=0;
			}
		}else{
			$data['ok']=0;
		}
		$this->ajaxReturn($data);
	}
	/**
	 * 删除收货地址
	 */
	public function delAddress(){
		$rs=I('addressId');
		$m = M('user_address');
		if($m->where(array('addressId'=>$rs))->delete()){
			$data['ok']=1;
		}else{
			$data['ok']=0;
		}
		$this->ajaxReturn($data);
	}
}