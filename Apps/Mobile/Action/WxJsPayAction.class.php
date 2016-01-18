<?php
namespace Mobile\Action;
use Think\Controller;
class WxJsPayAction extends BaseAction{
  public function index(){
    $this->isUserLogin();
        vendor('Weixinpay.WxPayPubHelper');
        //使用jsapi接口
        $jsApi = new \JsApi_pub();
        //=========步骤1：网页授权获取用户openid============
        //通过code获得openid
        $code = $_GET['code'];
        $jsApi->setCode($code);
        $openid = session('WST_USER')['wxId'];
      $pkey = session('WST_USER')["userId"]."@".$_SESSION["orderIds"];
      $time =time();
        $res = array(
            'order_sn' => $time,
            'order_amount' => $_SESSION['needPay']
        );
        //=========步骤2：使用统一支付接口，获取prepay_id============
        //使用统一支付接口
        $unifiedOrder = new \UnifiedOrder_pub();
        $total_fee = $res['order_amount']*100;
        //$total_fee = 1;
        $body = "订单支付{$res['order_sn']}";
        $unifiedOrder->setParameter("openid", "$openid");//用户标识
        $unifiedOrder->setParameter("body", $body);//商品描述
        //自定义订单号，此处仅作举例
        $out_trade_no = $res['order_sn'];
        $unifiedOrder->setParameter("out_trade_no", "$out_trade_no");//商户订单号
        $unifiedOrder->setParameter("total_fee", $total_fee);//总金额
        $unifiedOrder->setParameter("attach", "$pkey");//附加数据
        $unifiedOrder->setParameter("notify_url", C('WxPayConf_pub.NOTIFY_URL'));//通知地址
        $unifiedOrder->setParameter("trade_type", "JSAPI");//交易类型
        $unifiedOrder->SetParameter("input_charset", "UTF-8");
        //非必填参数，商户可根据实际情况选填
        $prepay_id = $unifiedOrder->getPrepayId();
        //=========步骤3：使用jsapi调起支付============
        $jsApi->setPrepayId($prepay_id);
        $jsApiParameters = $jsApi->getParameters();
        $wxconf = json_decode($jsApiParameters, true);
        if ($wxconf['package'] == 'prepay_id=') {
            $this->error('当前订单存在异常，不能使用支付');
        }
        $this->assign('res', $res);
        $this->assign('jsApiParameters', $jsApiParameters);
        $this->display('default/payment/wxjsapi/wxpay');
  }
  //异步通知url，商户根据实际开发过程设定
  public function notify() {
    vendor('Weixinpay.WxPayPubHelper');
    //使用通用通知接口
    $notify = new \Notify_pub ();
    // 存储微信的回调
    $xml = $GLOBALS ['HTTP_RAW_POST_DATA'];
    $notify->saveData ( $xml );

    // 验证签名，并回应微信。
    if ($notify->checkSign () == FALSE) {
      $notify->setReturnParameter ( "return_code", "FAIL" ); // 返回状态码
      $notify->setReturnParameter ( "return_msg", "签名失败" ); // 返回信息
    } else {
      $notify->setReturnParameter ( "return_code", "SUCCESS" ); // 设置返回码
    }
    $returnXml = $notify->returnXml ();
    echo $returnXml;
    // ==商户根据实际情况设置相应的处理流程=======
    if ($notify->checkSign () == TRUE) {
      if ($notify->data ["return_code"] == "FAIL") {
        // 此处应该更新一下订单状态，商户自行增删操作
      } elseif ($notify->data ["result_code"] == "FAIL") {
        // 此处应该更新一下订单状态，商户自行增删操作
      } else {
        // 此处应该更新一下订单状态，商户自行增删操作
        $order = $notify->getData();
        // $out_trade_no = $order["out_trade_no"];
        $trade_no = $order["transaction_id"];
        $total_fee = $order ["total_fee"];
        $pkey = $order ["attach"];
        $pkeys = explode("@", $pkey);
        $userId = $pkeys [0];
        $out_trade_no = $pkeys [1];

        $pm = D('Mobile/Payments');
        // 商户订单号
        $obj = array();
        $obj ["trade_no"] = $trade_no;
        $obj ["out_trade_no"] = $out_trade_no;
        $obj ["total_fee"] = $total_fee;
        $obj ["userId"] = $userId;
        // 支付成功业务逻辑
        $pm->complatePay($obj);

      }
    }
  }
}
?>