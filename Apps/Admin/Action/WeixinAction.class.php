<?php
namespace Admin\Action;;
/**
 * ============================================================================
 * WSTMall开源商城
 * 官网地址:http://www.wstmall.com
 * 联系QQ:707563272
 * ============================================================================
 * 微信控制器
 */
class WeixinAction extends BaseAction{
    /**
     * 微信设置
     */
    public function toSet(){
        $this->isLogin();
        $id=isset($_POST['id'])?$_POST['id']:0;
        if(IS_POST) {
            $data = array(
                'name'=>I('wxname'),
                'token'=>I('token'),
                'appid'=>I('APPID'),
                'appsecret'=>I('APPSECRET')
            );
            if($id>0){
                $data['id'] = $id;
                if(M('Wxconfig')->save($data)){
                    $this->redirect("Admin/Weixin/toSet");
                }
            }else{
                if(M('Wxconfig')->add($data)){
                    $this->redirect("Admin/Weixin/toSet");
                }
            }
        }else{
            $this->data = M("Wxconfig" )->where (array("id" =>1))->find();
            $this->display('/wachat/index');
        }
    }
    /**
     * 新增/修改操作
     */
    public function addMenu(){
        $this->isLogin();
        $id=isset($_GET['id'])?$_GET['id']:0;
        $pid=isset($_POST['id'])?$_POST['id']:0;
        if(IS_POST){
            $data = array(
                'we_menu_name'=>I('we_menu_name'),
                'we_menu_leftid'=>I('pid'),
                'we_menu_type'=>I('we_menu_type'),
                'we_menu_typeval'=>I('we_menu_typeval'),
                'we_menu_open'=>1,
                'we_menu_order'=>I('we_menu_order')
            );
            if($pid>0){
                $data['id'] = $pid;
                if(M('Menu')->save($data)){
                    $this->redirect("Admin/Weixin/menuList");
                }
            }else{
                if(M('Menu')->add($data)){
                    $this->redirect("Admin/Weixin/menuList");
                }
            }
        }else{
            if($id>0){
                $this->data=M('Menu')->where(array('we_menu_leftid'=>0))->select();
                $this->menu=M('Menu')->where(array('id'=>$id))->find();
                $this->display('/wachat/addMenu');
            }else{
                $this->data=M('Menu')->where(array('we_menu_leftid'=>0))->select();
                $this->display('/wachat/addMenu');
            }
        }

    }
    /**
     *菜单列表
     */
    public function menuList(){
        $this->isLogin();
        $nav = new \Org\Util\Leftnav;
        $we_menu=M('Menu')->order('we_menu_order')->select();
        $arr = $nav::menu($we_menu);
        $this->assign('data',$arr);
        $this->display('/wachat/menuList');
    }
    /**
     * 删除菜单
     */
    public function delMenu(){
        $we_menu=M('Menu')->where(array('id'=>I('id')))->delete();
        if($we_menu){
            $re['ok'] =  $we_menu;
        }else{
            $re['ok'] = 0;
        }
        $this->ajaxReturn($re);
    }
};
?>