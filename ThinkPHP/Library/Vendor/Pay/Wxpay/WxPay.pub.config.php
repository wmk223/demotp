<?php
/**
* 	配置账号信息
*/

class WxPayConf_pub
{
	//=======【基本信息设置】=====================================
	//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
	const APPID = 'wxad259a42911fa598';
	//受理商ID，身份标识
	const MCHID = '1282883901';
	//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
	const KEY = 'QQFjaWwhLeqfgKCvqiXhYgJHFjHg9a8F';
	//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
	const APPSECRET = '039e5f26008ebdd5665a8656191ec9c2';
	const JS_API_CALL_URL = 'http://9z80cufq7c.proxy.qqbrowser.cc/index.php/Mobile/WxPay/index' ;
	
	
	
	const SSLCERT_PATH = '../cacert/apiclient_cert.pem';
	const SSLKEY_PATH = '../cacert/apiclient_key.pem';

	const NOTIFY_URL = 'http://9z80cufq7c.proxy.qqbrowser.cc/index.php/Mobile/WxPay/notify';
	const CURL_TIMEOUT = 60;
}

	
?>