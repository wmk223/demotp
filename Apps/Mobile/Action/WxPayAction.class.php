<?php
// /**
//  * Created by PhpStorm.
//  * User: user
//  * Date: 2016/1/14
//  * Time: 15:31
//  */

// namespace Mobile\Action;
// use Think\Controller;
// class WxPayAction extends BaseAction{

//         public function index(){
//             $this->isUserLogin();
//             $USER = session('WST_USER');
//             //require_once "../lib/WxPay.Api.php";
//             //require_once "WxPay.JsApiPay.php";
//             import('Common.WxpayAPI.lib.WxPay#Api',APP_PATH,'.php');
//             import('Common.WxpayAPI.example.WxPay#JsApiPay',APP_PATH,'.php');
//             $tools = new \JsApiPay();
//             $openId = $tools->GetOpenid();
//             $input = new \WxPayUnifiedOrder();
//             $input->SetBody("test");
//             $input->SetAttach("test");
//             $input->SetOut_trade_no(\WxPayConfig::MCHID.date("YmdHis"));
//             $input->SetTotal_fee("1");
//             $input->SetTime_start(date("YmdHis"));
//             $input->SetTime_expire(date("YmdHis", time() + 20000));
//             $input->SetGoods_tag("test");
//             $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
//             $input->SetTrade_type("JSAPI");
//             $input->SetOpenid($openId);
//             $order = \WxPayApi::unifiedOrder($input);
//             $this->jsApiParameters = $tools->GetJsApiParameters($order);
//             $this->editAddress = $tools->GetEditAddressParameters();
//             $this->display('default/payment/wxjsapi/jspai');
//       }
//       //异步通知url，商户根据实际开发过程设定
//       public function notify_url() {
//             vendor('Weixinpay.WxPayPubHelper');
//           //使用通用通知接口
//             $notify = new \Notify_pub();
//             //存储微信的回调
//             $xml = $GLOBALS['HTTP_RAW_POST_DATA'];    
//             $notify->saveData($xml);
//             //验证签名，并回应微信。
//             //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
//             //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
//             //尽可能提高通知的成功率，但微信不保证通知最终能成功。
//             if($notify->checkSign() == FALSE){
//                   $notify->setReturnParameter("return_code", "FAIL");//返回状态码
//                   $notify->setReturnParameter("return_msg", "签名失败");//返回信息
//             }else{
//                   $notify->setReturnParameter("return_code", "SUCCESS");//设置返回码
//             }
//             $returnXml = $notify->returnXml();
//             //==商户根据实际情况设置相应的处理流程，此处仅作举例=======
//             //以log文件形式记录回调信息
//             //$log_name = "notify_url.log";//log文件路径
//             //$this->log_result($log_name, "【接收到的notify通知】:\n".$xml."\n");
//         $parameter = $notify->xmlToArray($xml);
//         //$this->log_result($log_name, "【接收到的notify通知】:\n".$parameter."\n");
//             if($notify->checkSign() == TRUE){
//                   if ($notify->data["return_code"] == "FAIL") {
//                 //此处应该更新一下订单状态，商户自行增删操作
//                 //$this->log_result($log_name, "【通信出错】:\n".$xml."\n");
//                 //更新订单数据【通信出错】设为无效订单
//                 echo 'error';
//                   }
//                   else if($notify->data["result_code"] == "FAIL"){
//                 //此处应该更新一下订单状态，商户自行增删操作
//                 //$this->log_result($log_name, "【业务出错】:\n".$xml."\n");
//                 //更新订单数据【通信出错】设为无效订单
//                 echo 'error';
//                   }
//                   else{
//                 //$this->log_result($log_name, "【支付成功】:\n".$xml."\n");
//                 //我这里用到一个process方法，成功返回数据后处理，返回地数据具体可以参考微信的文档
//                 if ($this->process($parameter)) {
//                     //处理成功后输出success，微信就不会再下发请求了
//                     echo 'success';
//                 }else {
//                     //没有处理成功，微信会间隔的发送请求
//                     echo 'error';
//                 }
//                   }
//             }
//       }
//     //订单处理
//     private function process($parameter) {
//         //此处应该更新一下订单状态，商户自行增删操作
//         /*
//         * 返回的数据最少有以下几个
//         * $parameter = array(
//             'out_trade_no' => xxx,//商户订单号
//             'total_fee' => XXXX,//支付金额
//             'openid' => XXxxx,//付款的用户ID
//         );
//         */
//         return true;
//     }

// }