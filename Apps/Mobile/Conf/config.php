<?php
return array(
	//'配置项'=>'配置值'
//	define('WEB_HOST', WSTDomain()),
	define('WEB_HOST', 'http://e7mqxyzk3g.proxy.qqbrowser.cc'),
	/*微信支付配置*/
	'WxPayConf_pub'=>array(
		'APPID' => 'wxad259a42911fa598',
		'MCHID' => '1282883901',
		'KEY' => 'QQFjaWwhLeqfgKCvqiXhYgJHFjHg9a8F',
		'APPSECRET' => '039e5f26008ebdd5665a8656191ec9c2',
		'JS_API_CALL_URL' => WEB_HOST.'/index.php/Mobile/Index/index',
		'NOTIFY_URL'=>WEB_HOST.'/index.php/Mobile/WxJsPay/notify',
		'CURL_TIMEOUT' => 30
	)

);