<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2015/12/21
 * Time: 15:19
 */

namespace Admin\Action;
use Admin\Wechat\Wechat;
use Think\Controller;

class WechatAction extends Controller {
    public function init() {
        $config = M("Wxconfig")->where(array("id"=>1))->find();
        $options = array (
            'token' => $config ["token"],
            'appid' => $config ["appid"],
            'appsecret' => $config ["appsecret"],
        );
        $weObj = new Wechat($options);
        return $weObj;
    }
    public function index() {
        $weObj = $this->init();
        $weObj->valid();
        $type = $weObj->getRev()->getRevType();
        switch ($type) {
            case Wechat::MSGTYPE_TEXT :
 				$weObj->text("")->reply();
                exit ();
                break;
            case Wechat::MSGTYPE_EVENT :
                $eventype = $weObj->getRev ()->getRevEvent ();
                if ($eventype ['event'] == "CLICK") {

                }elseif ($eventype['event'] == "subscribe") {
                    $weObj->text ("欢迎进入2b实验室")->reply();
                }
                exit ();
                break;
            default :
                $weObj->text("help info")->reply();
        }
    }
    public function createMenu(){
        /*
    	 * 菜单处理开始
    	 * 只取3条leftid=0的数据
    	 */
        $we_menu=M('Menu')->where(array('we_menu_leftid'=>0,'we_menu_open'=>1))->order('we_menu_order')->limit(3)->select();
        /*
         * 菜单数据重组
         * 重组结构参考微信公共平台开发文档
         * name 菜单名称
         * type 菜单类型
         * url 链接地址：针对viewleix
         */
        $data = '{"button":[';//菜单头
        foreach($we_menu as $v){
            $data.='{"name":"'.$v['we_menu_name'].'",';//菜单名称

            $count=M('Menu')->where(array('we_menu_leftid'=>$v['id'],'we_menu_open'=>1))->limit(5)->order('we_menu_order')->count();//判断是否有子栏目
            if($count){//二级栏目
                $data.='"sub_button":[';
                $we_twomenu=M('Menu')->where(array('we_menu_leftid'=>$v['id'],'we_menu_open'=>1))->order('we_menu_order')->limit(5)->select();
                $k=0;
                foreach($we_twomenu as $t){
                    $k=$k+1;
                    $data.='{"name":"'.$t['we_menu_name'].'",';
                    $data.='"type":"view",';
                    $data.='"url":"'.$t['we_menu_typeval'].'"';
                    if ($k==$count){
                        $data.= '}';
                    }else{
                        $data.= '},';
                    }
                }
                $data.= ']},';
            }else{
                $data.='"type":"view",';
                $data.='"url":""';
            }
        }
        $data.= '},]';
        $data.= '}';
        $weObj = $this->init();
        $weObj->createMenu($data);
        $this->success("重新创建菜单成功!",U('Admin/Weixin/menuList'));
    }
}