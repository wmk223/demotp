<?php
/**
 *	΢�Ź���ƽ̨PHP-SDK, �ٷ�API����
 *  @author  dodge <dodgepudding@gmail.com>
 *  @link https://github.com/dodgepudding/wechat-php-sdk
 *  @version 1.2
 *  usage:
 *   $options = array(
 *			'token'=>'tokenaccesskey', //��д���趨��key
 *			'encodingaeskey'=>'encodingaeskey', //��д�����õ�EncodingAESKey
 *			'appid'=>'wxdk1234567890', //��д�߼����ù��ܵ�app id
 *			'appsecret'=>'xxxxxxxxxxxxxxxxxxx' //��д�߼����ù��ܵ���Կ
 *		);
 *	 $weObj = new Wechat($options);
 *   $weObj->valid();
 *   $type = $weObj->getRev()->getRevType();
 *   switch($type) {
 *   		case Wechat::MSGTYPE_TEXT:
 *   			$weObj->text("hello, I'm wechat")->reply();
 *   			exit;
 *   			break;
 *   		case Wechat::MSGTYPE_EVENT:
 *   			....
 *   			break;
 *   		case Wechat::MSGTYPE_IMAGE:
 *   			...
 *   			break;
 *   		default:
 *   			$weObj->text("help info")->reply();
 *   }
 *
 *   //��ȡ�˵�����:
 *   $menu = $weObj->getMenu();
 *   //���ò˵�
 *   $newmenu =  array(
 *   		"button"=>
 *   			array(
 *   				array('type'=>'click','name'=>'������Ϣ','key'=>'MENU_KEY_NEWS'),
 *   				array('type'=>'view','name'=>'��Ҫ����','url'=>'http://www.baidu.com'),
 *   				)
 *  		);
 *   $result = $weObj->createMenu($newmenu);
 */
namespace Admin\Wechat;
class Wechat
{
    const MSGTYPE_TEXT = 'text';
    const MSGTYPE_IMAGE = 'image';
    const MSGTYPE_LOCATION = 'location';
    const MSGTYPE_LINK = 'link';
    const MSGTYPE_EVENT = 'event';
    const MSGTYPE_MUSIC = 'music';
    const MSGTYPE_NEWS = 'news';
    const MSGTYPE_VOICE = 'voice';
    const MSGTYPE_VIDEO = 'video';
    const EVENT_SUBSCRIBE = 'subscribe';       //����
    const EVENT_UNSUBSCRIBE = 'unsubscribe';   //ȡ������
    const EVENT_SCAN = 'SCAN';                 //ɨ���������ά��
    const EVENT_LOCATION = 'LOCATION';         //�ϱ�����λ��
    const EVENT_MENU_VIEW = 'VIEW';                     //�˵� - ����˵���ת����
    const EVENT_MENU_CLICK = 'CLICK';                   //�˵� - ����˵���ȡ��Ϣ
    const EVENT_MENU_SCAN_PUSH = 'scancode_push';       //�˵� - ɨ�����¼�(�ͻ�����URL)
    const EVENT_MENU_SCAN_WAITMSG = 'scancode_waitmsg'; //�˵� - ɨ�����¼�(�ͻ��˲���URL)
    const EVENT_MENU_PIC_SYS = 'pic_sysphoto';          //�˵� - ����ϵͳ���շ�ͼ
    const EVENT_MENU_PIC_PHOTO = 'pic_photo_or_album';  //�˵� - �������ջ�����ᷢͼ
    const EVENT_MENU_PIC_WEIXIN = 'pic_weixin';         //�˵� - ����΢����ᷢͼ��
    const EVENT_MENU_LOCATION = 'location_select';      //�˵� - ��������λ��ѡ����
    const EVENT_SEND_MASS = 'MASSSENDJOBFINISH';        //���ͽ�� - �߼�Ⱥ�����
    const EVENT_SEND_TEMPLATE = 'TEMPLATESENDJOBFINISH';//���ͽ�� - ģ����Ϣ���ͽ��
    const EVENT_KF_SEESION_CREATE = 'kfcreatesession';  //��ͷ� - ����Ự
    const EVENT_KF_SEESION_CLOSE = 'kfclosesession';    //��ͷ� - �رջỰ
    const EVENT_KF_SEESION_SWITCH = 'kfswitchsession';  //��ͷ� - ת�ӻỰ
    const EVENT_CARD_PASS = 'card_pass_check';          //��ȯ - ���ͨ��
    const EVENT_CARD_NOTPASS = 'card_not_pass_check';   //��ȯ - ���δͨ��
    const EVENT_CARD_USER_GET = 'user_get_card';        //��ȯ - �û���ȡ��ȯ
    const EVENT_CARD_USER_DEL = 'user_del_card';        //��ȯ - �û�ɾ����ȯ
    const API_URL_PREFIX = 'https://api.weixin.qq.com/cgi-bin';
    const AUTH_URL = '/token?grant_type=client_credential&';
    const MENU_CREATE_URL = '/menu/create?';
    const MENU_GET_URL = '/menu/get?';
    const MENU_DELETE_URL = '/menu/delete?';
    const GET_TICKET_URL = '/ticket/getticket?';
    const CALLBACKSERVER_GET_URL = '/getcallbackip?';
    const QRCODE_CREATE_URL='/qrcode/create?';
    const QR_SCENE = 0;
    const QR_LIMIT_SCENE = 1;
    const QRCODE_IMG_URL='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=';
    const SHORT_URL='/shorturl?';
    const USER_GET_URL='/user/get?';
    const USER_INFO_URL='/user/info?';
    const USER_UPDATEREMARK_URL='/user/info/updateremark?';
    const GROUP_GET_URL='/groups/get?';
    const USER_GROUP_URL='/groups/getid?';
    const GROUP_CREATE_URL='/groups/create?';
    const GROUP_UPDATE_URL='/groups/update?';
    const GROUP_MEMBER_UPDATE_URL='/groups/members/update?';
    const GROUP_MEMBER_BATCHUPDATE_URL='/groups/members/batchupdate?';
    const CUSTOM_SEND_URL='/message/custom/send?';
    const MEDIA_UPLOADNEWS_URL = '/media/uploadnews?';
    const MASS_SEND_URL = '/message/mass/send?';
    const TEMPLATE_SET_INDUSTRY_URL = '/message/template/api_set_industry?';
    const TEMPLATE_ADD_TPL_URL = '/message/template/api_add_template?';
    const TEMPLATE_SEND_URL = '/message/template/send?';
    const MASS_SEND_GROUP_URL = '/message/mass/sendall?';
    const MASS_DELETE_URL = '/message/mass/delete?';
    const MASS_PREVIEW_URL = '/message/mass/preview?';
    const MASS_QUERY_URL = '/message/mass/get?';
    const UPLOAD_MEDIA_URL = 'http://file.api.weixin.qq.com/cgi-bin';
    const MEDIA_UPLOAD_URL = '/media/upload?';
    const MEDIA_GET_URL = '/media/get?';
    const MEDIA_VIDEO_UPLOAD = '/media/uploadvideo?';
    const MEDIA_FOREVER_UPLOAD_URL = '/material/add_material?';
    const MEDIA_FOREVER_NEWS_UPLOAD_URL = '/material/add_news?';
    const MEDIA_FOREVER_NEWS_UPDATE_URL = '/material/update_news?';
    const MEDIA_FOREVER_GET_URL = '/material/get_material?';
    const MEDIA_FOREVER_DEL_URL = '/material/del_material?';
    const MEDIA_FOREVER_COUNT_URL = '/material/get_materialcount?';
    const MEDIA_FOREVER_BATCHGET_URL = '/material/batchget_material?';
    const OAUTH_PREFIX = 'https://open.weixin.qq.com/connect/oauth2';
    const OAUTH_AUTHORIZE_URL = '/authorize?';
    ///��ͷ���ص�ַ
    const CUSTOM_SERVICE_GET_RECORD = '/customservice/getrecord?';
    const CUSTOM_SERVICE_GET_KFLIST = '/customservice/getkflist?';
    const CUSTOM_SERVICE_GET_ONLINEKFLIST = '/customservice/getonlinekflist?';
    const API_BASE_URL_PREFIX = 'https://api.weixin.qq.com'; //����API�ӿ�URL��Ҫʹ�ô�ǰ׺
    const OAUTH_TOKEN_URL = '/sns/oauth2/access_token?';
    const OAUTH_REFRESH_URL = '/sns/oauth2/refresh_token?';
    const OAUTH_USERINFO_URL = '/sns/userinfo?';
    const OAUTH_AUTH_URL = '/sns/auth?';
    ///��ͷ���ص�ַ
    const CUSTOM_SESSION_CREATE = '/customservice/kfsession/create?';
    const CUSTOM_SESSION_CLOSE = '/customservice/kfsession/close?';
    const CUSTOM_SESSION_SWITCH = '/customservice/kfsession/switch?';
    const CUSTOM_SESSION_GET = '/customservice/kfsession/getsession?';
    const CUSTOM_SESSION_GET_LIST = '/customservice/kfsession/getsessionlist?';
    const CUSTOM_SESSION_GET_WAIT = '/customservice/kfsession/getwaitcase?';
    const CS_KF_ACCOUNT_ADD_URL = '/customservice/kfaccount/add?';
    const CS_KF_ACCOUNT_UPDATE_URL = '/customservice/kfaccount/update?';
    const CS_KF_ACCOUNT_DEL_URL = '/customservice/kfaccount/del?';
    const CS_KF_ACCOUNT_UPLOAD_HEADIMG_URL = '/customservice/kfaccount/uploadheadimg?';
    ///��ȯ��ص�ַ
    const CARD_CREATE                     = '/card/create?';
    const CARD_DELETE                     = '/card/delete?';
    const CARD_UPDATE                     = '/card/update?';
    const CARD_GET                        = '/card/get?';
    const CARD_BATCHGET                   = '/card/batchget?';
    const CARD_MODIFY_STOCK               = '/card/modifystock?';
    const CARD_LOCATION_BATCHADD          = '/card/location/batchadd?';
    const CARD_LOCATION_BATCHGET          = '/card/location/batchget?';
    const CARD_GETCOLORS                  = '/card/getcolors?';
    const CARD_QRCODE_CREATE              = '/card/qrcode/create?';
    const CARD_CODE_CONSUME               = '/card/code/consume?';
    const CARD_CODE_DECRYPT               = '/card/code/decrypt?';
    const CARD_CODE_GET                   = '/card/code/get?';
    const CARD_CODE_UPDATE                = '/card/code/update?';
    const CARD_CODE_UNAVAILABLE           = '/card/code/unavailable?';
    const CARD_TESTWHILELIST_SET          = '/card/testwhitelist/set?';
    const CARD_MEMBERCARD_ACTIVATE        = '/card/membercard/activate?';      //�����Ա��
    const CARD_MEMBERCARD_UPDATEUSER      = '/card/membercard/updateuser?';    //���»�Ա��
    const CARD_MOVIETICKET_UPDATEUSER     = '/card/movieticket/updateuser?';   //���µ�ӰƱ(δ�ӷ���)
    const CARD_BOARDINGPASS_CHECKIN       = '/card/boardingpass/checkin?';     //�ɻ�Ʊ-����ѡ��(δ�ӷ���)
    const CARD_LUCKYMONEY_UPDATE          = '/card/luckymoney/updateuserbalance?';     //���º�����
    const SEMANTIC_API_URL = '/semantic/semproxy/search?'; //�������
    ///���ݷ����ӿ�
    static $DATACUBE_URL_ARR = array(        //�û�����
        'user' => array(
            'summary' => '/datacube/getusersummary?',		//��ȡ�û��������ݣ�getusersummary��
            'cumulate' => '/datacube/getusercumulate?',		//��ȡ�ۼ��û����ݣ�getusercumulate��
        ),
        'article' => array(            //ͼ�ķ���
            'summary' => '/datacube/getarticlesummary?',		//��ȡͼ��Ⱥ��ÿ�����ݣ�getarticlesummary��
            'total' => '/datacube/getarticletotal?',		//��ȡͼ��Ⱥ�������ݣ�getarticletotal��
            'read' => '/datacube/getuserread?',			//��ȡͼ��ͳ�����ݣ�getuserread��
            'readhour' => '/datacube/getuserreadhour?',		//��ȡͼ��ͳ�Ʒ�ʱ���ݣ�getuserreadhour��
            'share' => '/datacube/getusershare?',			//��ȡͼ�ķ���ת�����ݣ�getusershare��
            'sharehour' => '/datacube/getusersharehour?',		//��ȡͼ�ķ���ת����ʱ���ݣ�getusersharehour��
        ),
        'upstreammsg' => array(        //��Ϣ����
            'summary' => '/datacube/getupstreammsg?',		//��ȡ��Ϣ���͸ſ����ݣ�getupstreammsg��
            'hour' => '/datacube/getupstreammsghour?',	//��ȡ��Ϣ���ͷ�ʱ���ݣ�getupstreammsghour��
            'week' => '/datacube/getupstreammsgweek?',	//��ȡ��Ϣ���������ݣ�getupstreammsgweek��
            'month' => '/datacube/getupstreammsgmonth?',	//��ȡ��Ϣ���������ݣ�getupstreammsgmonth��
            'dist' => '/datacube/getupstreammsgdist?',	//��ȡ��Ϣ���ͷֲ����ݣ�getupstreammsgdist��
            'distweek' => '/datacube/getupstreammsgdistweek?',	//��ȡ��Ϣ���ͷֲ������ݣ�getupstreammsgdistweek��
            'distmonth' => '/datacube/getupstreammsgdistmonth?',	//��ȡ��Ϣ���ͷֲ������ݣ�getupstreammsgdistmonth��
        ),
        'interface' => array(        //�ӿڷ���
            'summary' => '/datacube/getinterfacesummary?',	//��ȡ�ӿڷ������ݣ�getinterfacesummary��
            'summaryhour' => '/datacube/getinterfacesummaryhour?',	//��ȡ�ӿڷ�����ʱ���ݣ�getinterfacesummaryhour��
        )
    );


    private $token;
    private $encodingAesKey;
    private $encrypt_type;
    private $appid;
    private $appsecret;
    private $access_token;
    private $jsapi_ticket;
    private $user_token;
    private $partnerid;
    private $partnerkey;
    private $paysignkey;
    private $postxml;
    private $_msg;
    private $_funcflag = false;
    private $_receive;
    private $_text_filter = true;
    public $debug =  false;
    public $errCode = 40001;
    public $errMsg = "no access";
    public $logcallback;

    public function __construct($options)
    {
        $this->token = isset($options['token'])?$options['token']:'';
        $this->encodingAesKey = isset($options['encodingaeskey'])?$options['encodingaeskey']:'';
        $this->appid = isset($options['appid'])?$options['appid']:'';
        $this->appsecret = isset($options['appsecret'])?$options['appsecret']:'';
        $this->debug = isset($options['debug'])?$options['debug']:false;
        $this->logcallback = isset($options['logcallback'])?$options['logcallback']:false;
    }

    /**
     * For weixin server validation
     */
    private function checkSignature($str='')
    {
        $signature = isset($_GET["signature"])?$_GET["signature"]:'';
        $signature = isset($_GET["msg_signature"])?$_GET["msg_signature"]:$signature; //������ڼ�����֤���ü�����֤��
        $timestamp = isset($_GET["timestamp"])?$_GET["timestamp"]:'';
        $nonce = isset($_GET["nonce"])?$_GET["nonce"]:'';

        $token = $this->token;
        $tmpArr = array($token, $timestamp, $nonce,$str);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    /**
     * For weixin server validation
     * @param bool $return �Ƿ񷵻�
     */
    public function valid($return=false)
    {
        $encryptStr="";
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $postStr = file_get_contents("php://input");
            $array = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $this->encrypt_type = isset($_GET["encrypt_type"]) ? $_GET["encrypt_type"]: '';
            if ($this->encrypt_type == 'aes') { //aes����
                $this->log($postStr);
                $encryptStr = $array['Encrypt'];
                $pc = new Prpcrypt($this->encodingAesKey);
                $array = $pc->decrypt($encryptStr,$this->appid);
                if (!isset($array[0]) || ($array[0] != 0)) {
                    if (!$return) {
                        die('decrypt error!');
                    } else {
                        return false;
                    }
                }
                $this->postxml = $array[1];
                if (!$this->appid)
                    $this->appid = $array[2];//Ϊ��û��appid�Ķ��ĺš�
            } else {
                $this->postxml = $postStr;
            }
        } elseif (isset($_GET["echostr"])) {
            $echoStr = $_GET["echostr"];
            if ($return) {
                if ($this->checkSignature())
                    return $echoStr;
                else
                    return false;
            } else {
                if ($this->checkSignature())
                    die($echoStr);
                else
                    die('no access');
            }
        }

        if (!$this->checkSignature($encryptStr)) {
            if ($return)
                return false;
            else
                die('no access');
        }
        return true;
    }

    /**
     * ���÷�����Ϣ
     * @param array $msg ��Ϣ����
     * @param bool $append �Ƿ���ԭ��Ϣ����׷��
     */
    public function Message($msg = '',$append = false){
        if (is_null($msg)) {
            $this->_msg =array();
        }elseif (is_array($msg)) {
            if ($append)
                $this->_msg = array_merge($this->_msg,$msg);
            else
                $this->_msg = $msg;
            return $this->_msg;
        } else {
            return $this->_msg;
        }
    }

    /**
     * ������Ϣ���Ǳ��־���ٷ���ȡ���Դ˹��ܵ�֧��
     */
    public function setFuncFlag($flag) {
        $this->_funcflag = $flag;
        return $this;
    }

    /**
     * ��־��¼���ɱ����ء�
     * @param mixed $log ������־
     * @return mixed
     */
    protected function log($log){
        if ($this->debug && function_exists($this->logcallback)) {
            if (is_array($log)) $log = print_r($log,true);
            return call_user_func($this->logcallback,$log);
        }
    }

    /**
     * ��ȡ΢�ŷ�������������Ϣ
     */
    public function getRev()
    {
        if ($this->_receive) return $this;
        $postStr = !empty($this->postxml)?$this->postxml:file_get_contents("php://input");
        //���ʹ�������ֲ������valid()���������
        $this->log($postStr);
        if (!empty($postStr)) {
            $this->_receive = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        }
        return $this;
    }

    /**
     * ��ȡ΢�ŷ�������������Ϣ
     */
    public function getRevData()
    {
        return $this->_receive;
    }

    /**
     * ��ȡ��Ϣ������
     */
    public function getRevFrom() {
        if (isset($this->_receive['FromUserName']))
            return $this->_receive['FromUserName'];
        else
            return false;
    }

    /**
     * ��ȡ��Ϣ������
     */
    public function getRevTo() {
        if (isset($this->_receive['ToUserName']))
            return $this->_receive['ToUserName'];
        else
            return false;
    }

    /**
     * ��ȡ������Ϣ������
     */
    public function getRevType() {
        if (isset($this->_receive['MsgType']))
            return $this->_receive['MsgType'];
        else
            return false;
    }

    /**
     * ��ȡ��ϢID
     */
    public function getRevID() {
        if (isset($this->_receive['MsgId']))
            return $this->_receive['MsgId'];
        else
            return false;
    }

    /**
     * ��ȡ��Ϣ����ʱ��
     */
    public function getRevCtime() {
        if (isset($this->_receive['CreateTime']))
            return $this->_receive['CreateTime'];
        else
            return false;
    }

    /**
     * ��ȡ������Ϣ��������
     */
    public function getRevContent(){
        if (isset($this->_receive['Content']))
            return $this->_receive['Content'];
        else if (isset($this->_receive['Recognition'])) //��ȡ����ʶ���������ݣ������뿪ͨ
            return $this->_receive['Recognition'];
        else
            return false;
    }

    /**
     * ��ȡ������ϢͼƬ
     */
    public function getRevPic(){
        if (isset($this->_receive['PicUrl']))
            return array(
                'mediaid'=>$this->_receive['MediaId'],
                'picurl'=>(string)$this->_receive['PicUrl'],    //��ֹpicurlΪ�յ��½�������
            );
        else
            return false;
    }

    /**
     * ��ȡ������Ϣ����
     */
    public function getRevLink(){
        if (isset($this->_receive['Url'])){
            return array(
                'url'=>$this->_receive['Url'],
                'title'=>$this->_receive['Title'],
                'description'=>$this->_receive['Description']
            );
        } else
            return false;
    }

    /**
     * ��ȡ���յ���λ��
     */
    public function getRevGeo(){
        if (isset($this->_receive['Location_X'])){
            return array(
                'x'=>$this->_receive['Location_X'],
                'y'=>$this->_receive['Location_Y'],
                'scale'=>$this->_receive['Scale'],
                'label'=>$this->_receive['Label']
            );
        } else
            return false;
    }

    /**
     * ��ȡ�ϱ�����λ���¼�
     */
    public function getRevEventGeo(){
        if (isset($this->_receive['Latitude'])){
            return array(
                'x'=>$this->_receive['Latitude'],
                'y'=>$this->_receive['Longitude'],
                'precision'=>$this->_receive['Precision'],
            );
        } else
            return false;
    }

    /**
     * ��ȡ�����¼�����
     */
    public function getRevEvent(){
        if (isset($this->_receive['Event'])){
            $array['event'] = $this->_receive['Event'];
        }
        if (isset($this->_receive['EventKey'])){
            $array['key'] = $this->_receive['EventKey'];
        }
        if (isset($array) && count($array) > 0) {
            return $array;
        } else {
            return false;
        }
    }

    /**
     * ��ȡ�Զ���˵���ɨ�����¼���Ϣ
     *
     * �¼�����Ϊ��������ʱ����ô˷�����Ч
     * Event	 �¼����ͣ�scancode_push
     * Event	 �¼����ͣ�scancode_waitmsg
     *
     * @return: array | false
     * array (
     *     'ScanType'=>'qrcode',
     *     'ScanResult'=>'123123'
     * )
     */
    public function getRevScanInfo(){
        if (isset($this->_receive['ScanCodeInfo'])){
            if (!is_array($this->_receive['ScanCodeInfo'])) {
                $array=(array)$this->_receive['ScanCodeInfo'];
                $this->_receive['ScanCodeInfo']=$array;
            }else {
                $array=$this->_receive['ScanCodeInfo'];
            }
        }
        if (isset($array) && count($array) > 0) {
            return $array;
        } else {
            return false;
        }
    }

    /**
     * ��ȡ�Զ���˵���ͼƬ�����¼���Ϣ
     *
     * �¼�����Ϊ��������ʱ����ô˷�����Ч
     * Event	 �¼����ͣ�pic_sysphoto        ����ϵͳ���շ�ͼ���¼�����
     * Event	 �¼����ͣ�pic_photo_or_album  �������ջ�����ᷢͼ���¼�����
     * Event	 �¼����ͣ�pic_weixin          ����΢����ᷢͼ�����¼�����
     *
     * @return: array | false
     * array (
     *   'Count' => '2',
     *   'PicList' =>array (
     *         'item' =>array (
     *             0 =>array ('PicMd5Sum' => 'aaae42617cf2a14342d96005af53624c'),
     *             1 =>array ('PicMd5Sum' => '149bd39e296860a2adc2f1bb81616ff8'),
     *         ),
     *   ),
     * )
     *
     */
    public function getRevSendPicsInfo(){
        if (isset($this->_receive['SendPicsInfo'])){
            if (!is_array($this->_receive['SendPicsInfo'])) {
                $array=(array)$this->_receive['SendPicsInfo'];
                if (isset($array['PicList'])){
                    $array['PicList']=(array)$array['PicList'];
                    $item=$array['PicList']['item'];
                    $array['PicList']['item']=array();
                    foreach ( $item as $key => $value ){
                        $array['PicList']['item'][$key]=(array)$value;
                    }
                }
                $this->_receive['SendPicsInfo']=$array;
            } else {
                $array=$this->_receive['SendPicsInfo'];
            }
        }
        if (isset($array) && count($array) > 0) {
            return $array;
        } else {
            return false;
        }
    }

    /**
     * ��ȡ�Զ���˵��ĵ���λ��ѡ�����¼�����
     *
     * �¼�����Ϊ����ʱ����Ե��ô˷�����Ч
     * Event	 �¼����ͣ�location_select        ��������λ��ѡ�������¼�����
     *
     * @return: array | false
     * array (
     *   'Location_X' => '33.731655000061',
     *   'Location_Y' => '113.29955200008047',
     *   'Scale' => '16',
     *   'Label' => 'ĳĳ��ĳĳ��ĳĳ·',
     *   'Poiname' => '',
     * )
     *
     */
    public function getRevSendGeoInfo(){
        if (isset($this->_receive['SendLocationInfo'])){
            if (!is_array($this->_receive['SendLocationInfo'])) {
                $array=(array)$this->_receive['SendLocationInfo'];
                if (empty($array['Poiname'])) {
                    $array['Poiname']="";
                }
                if (empty($array['Label'])) {
                    $array['Label']="";
                }
                $this->_receive['SendLocationInfo']=$array;
            } else {
                $array=$this->_receive['SendLocationInfo'];
            }
        }
        if (isset($array) && count($array) > 0) {
            return $array;
        } else {
            return false;
        }
    }

    /**
     * ��ȡ������������
     */
    public function getRevVoice(){
        if (isset($this->_receive['MediaId'])){
            return array(
                'mediaid'=>$this->_receive['MediaId'],
                'format'=>$this->_receive['Format'],
            );
        } else
            return false;
    }

    /**
     * ��ȡ������Ƶ����
     */
    public function getRevVideo(){
        if (isset($this->_receive['MediaId'])){
            return array(
                'mediaid'=>$this->_receive['MediaId'],
                'thumbmediaid'=>$this->_receive['ThumbMediaId']
            );
        } else
            return false;
    }

    /**
     * ��ȡ����TICKET
     */
    public function getRevTicket(){
        if (isset($this->_receive['Ticket'])){
            return $this->_receive['Ticket'];
        } else
            return false;
    }

    /**
     * ��ȡ��ά��ĳ���ֵ
     */
    public function getRevSceneId (){
        if (isset($this->_receive['EventKey'])){
            return str_replace('qrscene_','',$this->_receive['EventKey']);
        } else{
            return false;
        }
    }

    /**
     * ��ȡ�������͵���ϢID
     * ������֤���������ͨ����ϢMsgId��һ��
     * ��EventΪ MASSSENDJOBFINISH �� TEMPLATESENDJOBFINISH
     */
    public function getRevTplMsgID(){
        if (isset($this->_receive['MsgID'])){
            return $this->_receive['MsgID'];
        } else
            return false;
    }

    /**
     * ��ȡģ����Ϣ����״̬
     */
    public function getRevStatus(){
        if (isset($this->_receive['Status'])){
            return $this->_receive['Status'];
        } else
            return false;
    }

    /**
     * ��ȡȺ����ģ����Ϣ���ͽ��
     * ��EventΪ MASSSENDJOBFINISH �� TEMPLATESENDJOBFINISH�����߼�Ⱥ��/ģ����Ϣ
     */
    public function getRevResult(){
        if (isset($this->_receive['Status'])) //�����Ƿ�ɹ�������ķ���ֵ��ο� �߼�Ⱥ��/ģ����Ϣ ���¼�����˵��
            $array['Status'] = $this->_receive['Status'];
        if (isset($this->_receive['MsgID'])) //���͵���Ϣid
            $array['MsgID'] = $this->_receive['MsgID'];

        //���½���Ⱥ����Ϣʱ�Ż��е��¼�����
        if (isset($this->_receive['TotalCount']))     //�����openid�б��ڷ�˿����
            $array['TotalCount'] = $this->_receive['TotalCount'];
        if (isset($this->_receive['FilterCount']))    //���ˣ�������ָ�ض��������Ա�Ĺ��ˡ��û����þ��յĹ��ˣ��û������ѳ�4���Ĺ��ˣ���׼�����͵ķ�˿��
            $array['FilterCount'] = $this->_receive['FilterCount'];
        if (isset($this->_receive['SentCount']))     //���ͳɹ��ķ�˿��
            $array['SentCount'] = $this->_receive['SentCount'];
        if (isset($this->_receive['ErrorCount']))    //����ʧ�ܵķ�˿��
            $array['ErrorCount'] = $this->_receive['ErrorCount'];
        if (isset($array) && count($array) > 0) {
            return $array;
        } else {
            return false;
        }
    }

    /**
     * ��ȡ��ͷ��Ự״̬�����¼� - ����Ự
     * ��EventΪ kfcreatesession ������Ự
     * @return string | boolean  ���ط��䵽�Ŀͷ�
     */
    public function getRevKFCreate(){
        if (isset($this->_receive['KfAccount'])){
            return $this->_receive['KfAccount'];
        } else
            return false;
    }

    /**
     * ��ȡ��ͷ��Ự״̬�����¼� - �رջỰ
     * ��EventΪ kfclosesession ���رջỰ
     * @return string | boolean  ���ط��䵽�Ŀͷ�
     */
    public function getRevKFClose(){
        if (isset($this->_receive['KfAccount'])){
            return $this->_receive['KfAccount'];
        } else
            return false;
    }

    /**
     * ��ȡ��ͷ��Ự״̬�����¼� - ת�ӻỰ
     * ��EventΪ kfswitchsession ��ת�ӻỰ
     * @return array | boolean  ���ط��䵽�Ŀͷ�
     * {
     *     'FromKfAccount' => '',      //ԭ����ͷ�
     *     'ToKfAccount' => ''            //ת�ӵ��ͷ�
     * }
     */
    public function getRevKFSwitch(){
        if (isset($this->_receive['FromKfAccount']))     //ԭ����ͷ�
            $array['FromKfAccount'] = $this->_receive['FromKfAccount'];
        if (isset($this->_receive['ToKfAccount']))    //ת�ӵ��ͷ�
            $array['ToKfAccount'] = $this->_receive['ToKfAccount'];
        if (isset($array) && count($array) > 0) {
            return $array;
        } else {
            return false;
        }
    }

    /**
     * ��ȡ��ȯ�¼����� - ��������Ƿ�ͨ��
     * ��EventΪ card_pass_check(���ͨ��) �� card_not_pass_check(δͨ��)
     * @return string|boolean  ���ؿ�ȯID
     */
    public function getRevCardPass(){
        if (isset($this->_receive['CardId']))
            return $this->_receive['CardId'];
        else
            return false;
    }

    /**
     * ��ȡ��ȯ�¼����� - ��ȡ��ȯ
     * ��EventΪ user_get_card(�û���ȡ��ȯ)
     * @return array|boolean
     */
    public function getRevCardGet(){
        if (isset($this->_receive['CardId']))     //��ȯ ID
            $array['CardId'] = $this->_receive['CardId'];
        if (isset($this->_receive['IsGiveByFriend']))    //�Ƿ�Ϊת����1 �����ǣ�0 �����
            $array['IsGiveByFriend'] = $this->_receive['IsGiveByFriend'];
        if (isset($this->_receive['UserCardCode']) && !empty($this->_receive['UserCardCode'])) //code ���кš��Զ��� code �����Զ��� code�Ŀ�ȯ����ȡ��֧���¼����͡�
            $array['UserCardCode'] = $this->_receive['UserCardCode'];
        if (isset($array) && count($array) > 0) {
            return $array;
        } else {
            return false;
        }
    }

    /**
     * ��ȡ��ȯ�¼����� - ɾ����ȯ
     * ��EventΪ user_del_card(�û�ɾ����ȯ)
     * @return array|boolean
     */
    public function getRevCardDel(){
        if (isset($this->_receive['CardId']))     //��ȯ ID
            $array['CardId'] = $this->_receive['CardId'];
        if (isset($this->_receive['UserCardCode']) && !empty($this->_receive['UserCardCode'])) //code ���кš��Զ��� code �����Զ��� code�Ŀ�ȯ����ȡ��֧���¼����͡�
            $array['UserCardCode'] = $this->_receive['UserCardCode'];
        if (isset($array) && count($array) > 0) {
            return $array;
        } else {
            return false;
        }
    }

    public static function xmlSafeStr($str)
    {
        return '<![CDATA['.preg_replace("/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/",'',$str).']]>';
    }

    /**
     * ����XML����
     * @param mixed $data ����
     * @return string
     */
    public static function data_to_xml($data) {
        $xml = '';
        foreach ($data as $key => $val) {
            is_numeric($key) && $key = "item id=\"$key\"";
            $xml    .=  "<$key>";
            $xml    .=  ( is_array($val) || is_object($val)) ? self::data_to_xml($val)  : self::xmlSafeStr($val);
            list($key, ) = explode(' ', $key);
            $xml    .=  "</$key>";
        }
        return $xml;
    }

    /**
     * XML����
     * @param mixed $data ����
     * @param string $root ���ڵ���
     * @param string $item �����������ӽڵ���
     * @param string $attr ���ڵ�����
     * @param string $id   ���������ӽڵ�keyת����������
     * @param string $encoding ���ݱ���
     * @return string
     */
    public function xml_encode($data, $root='xml', $item='item', $attr='', $id='id', $encoding='utf-8') {
        if(is_array($attr)){
            $_attr = array();
            foreach ($attr as $key => $value) {
                $_attr[] = "{$key}=\"{$value}\"";
            }
            $attr = implode(' ', $_attr);
        }
        $attr   = trim($attr);
        $attr   = empty($attr) ? '' : " {$attr}";
        $xml   = "<{$root}{$attr}>";
        $xml   .= self::data_to_xml($data, $item, $id);
        $xml   .= "</{$root}>";
        return $xml;
    }

    /**
     * �������ֻظ�\r\n���з�
     * @param string $text
     * @return string|mixed
     */
    private function _auto_text_filter($text) {
        if (!$this->_text_filter) return $text;
        return str_replace("\r\n", "\n", $text);
    }

    /**
     * ���ûظ���Ϣ
     * Example: $obj->text('hello')->reply();
     * @param string $text
     */
    public function text($text='')
    {
        $FuncFlag = $this->_funcflag ? 1 : 0;
        $msg = array(
            'ToUserName' => $this->getRevFrom(),
            'FromUserName'=>$this->getRevTo(),
            'MsgType'=>self::MSGTYPE_TEXT,
            'Content'=>$this->_auto_text_filter($text),
            'CreateTime'=>time(),
            'FuncFlag'=>$FuncFlag
        );
        $this->Message($msg);
        return $this;
    }
    /**
     * ���ûظ���Ϣ
     * Example: $obj->image('media_id')->reply();
     * @param string $mediaid
     */
    public function image($mediaid='')
    {
        $FuncFlag = $this->_funcflag ? 1 : 0;
        $msg = array(
            'ToUserName' => $this->getRevFrom(),
            'FromUserName'=>$this->getRevTo(),
            'MsgType'=>self::MSGTYPE_IMAGE,
            'Image'=>array('MediaId'=>$mediaid),
            'CreateTime'=>time(),
            'FuncFlag'=>$FuncFlag
        );
        $this->Message($msg);
        return $this;
    }

    /**
     * ���ûظ���Ϣ
     * Example: $obj->voice('media_id')->reply();
     * @param string $mediaid
     */
    public function voice($mediaid='')
    {
        $FuncFlag = $this->_funcflag ? 1 : 0;
        $msg = array(
            'ToUserName' => $this->getRevFrom(),
            'FromUserName'=>$this->getRevTo(),
            'MsgType'=>self::MSGTYPE_VOICE,
            'Voice'=>array('MediaId'=>$mediaid),
            'CreateTime'=>time(),
            'FuncFlag'=>$FuncFlag
        );
        $this->Message($msg);
        return $this;
    }

    /**
     * ���ûظ���Ϣ
     * Example: $obj->video('media_id','title','description')->reply();
     * @param string $mediaid
     */
    public function video($mediaid='',$title='',$description='')
    {
        $FuncFlag = $this->_funcflag ? 1 : 0;
        $msg = array(
            'ToUserName' => $this->getRevFrom(),
            'FromUserName'=>$this->getRevTo(),
            'MsgType'=>self::MSGTYPE_VIDEO,
            'Video'=>array(
                'MediaId'=>$mediaid,
                'Title'=>$title,
                'Description'=>$description
            ),
            'CreateTime'=>time(),
            'FuncFlag'=>$FuncFlag
        );
        $this->Message($msg);
        return $this;
    }

    /**
     * ���ûظ�����
     * @param string $title
     * @param string $desc
     * @param string $musicurl
     * @param string $hgmusicurl
     * @param string $thumbmediaid ����ͼƬ����ͼ��ý��id���Ǳ���
     */
    public function music($title,$desc,$musicurl,$hgmusicurl='',$thumbmediaid='') {
        $FuncFlag = $this->_funcflag ? 1 : 0;
        $msg = array(
            'ToUserName' => $this->getRevFrom(),
            'FromUserName'=>$this->getRevTo(),
            'CreateTime'=>time(),
            'MsgType'=>self::MSGTYPE_MUSIC,
            'Music'=>array(
                'Title'=>$title,
                'Description'=>$desc,
                'MusicUrl'=>$musicurl,
                'HQMusicUrl'=>$hgmusicurl
            ),
            'FuncFlag'=>$FuncFlag
        );
        if ($thumbmediaid) {
            $msg['Music']['ThumbMediaId'] = $thumbmediaid;
        }
        $this->Message($msg);
        return $this;
    }

    /**
     * ���ûظ�ͼ��
     * @param array $newsData
     * ����ṹ:
     *  array(
     *  	"0"=>array(
     *  		'Title'=>'msg title',
     *  		'Description'=>'summary text',
     *  		'PicUrl'=>'http://www.domain.com/1.jpg',
     *  		'Url'=>'http://www.domain.com/1.html'
     *  	),
     *  	"1"=>....
     *  )
     */
    public function news($newsData=array())
    {
        $FuncFlag = $this->_funcflag ? 1 : 0;
        $count = count($newsData);

        $msg = array(
            'ToUserName' => $this->getRevFrom(),
            'FromUserName'=>$this->getRevTo(),
            'MsgType'=>self::MSGTYPE_NEWS,
            'CreateTime'=>time(),
            'ArticleCount'=>$count,
            'Articles'=>$newsData,
            'FuncFlag'=>$FuncFlag
        );
        $this->Message($msg);
        return $this;
    }

    /**
     *
     * �ظ�΢�ŷ�����, �˺���֧����ʽ����
     * Example: $this->text('msg tips')->reply();
     * @param string $msg Ҫ���͵���Ϣ, Ĭ��ȡ$this->_msg
     * @param bool $return �Ƿ񷵻���Ϣ�����׳�������� Ĭ��:��
     */
    public function reply($msg=array(),$return = false)
    {
        if (empty($msg)) {
            if (empty($this->_msg))   //��ֹ�������ûظ����ݣ�ֱ�ӵ���reply���������쳣
                return false;
            $msg = $this->_msg;
        }
        $xmldata=  $this->xml_encode($msg);
        $this->log($xmldata);
        if ($this->encrypt_type == 'aes') { //�����Դ��ϢΪ���ܷ�ʽ
            $pc = new Prpcrypt($this->encodingAesKey);
            $array = $pc->encrypt($xmldata, $this->appid);
            $ret = $array[0];
            if ($ret != 0) {
                $this->log('encrypt err!');
                return false;
            }
            $timestamp = time();
            $nonce = rand(77,999)*rand(605,888)*rand(11,99);
            $encrypt = $array[1];
            $tmpArr = array($this->token, $timestamp, $nonce,$encrypt);//����ͨ����ƽ̨����һ�����ܵ�����
            sort($tmpArr, SORT_STRING);
            $signature = implode($tmpArr);
            $signature = sha1($signature);
            $xmldata = $this->generate($encrypt, $signature, $timestamp, $nonce);
            $this->log($xmldata);
        }
        if ($return)
            return $xmldata;
        else
            echo $xmldata;
    }

    /**
     * xml��ʽ���ܣ�������Ϊ���ܷ�ʽʱ����
     */
    private function generate($encrypt, $signature, $timestamp, $nonce)
    {
        //��ʽ��������Ϣ
        $format = "<xml>
<Encrypt><![CDATA[%s]]></Encrypt>
<MsgSignature><![CDATA[%s]]></MsgSignature>
<TimeStamp>%s</TimeStamp>
<Nonce><![CDATA[%s]]></Nonce>
</xml>";
        return sprintf($format, $encrypt, $signature, $timestamp, $nonce);
    }

    /**
     * GET ����
     * @param string $url
     */
    private function http_get($url){
        $oCurl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if(intval($aStatus["http_code"])==200){
            return $sContent;
        }else{
            return false;
        }
    }

    /**
     * POST ����
     * @param string $url
     * @param array $param
     * @param boolean $post_file �Ƿ��ļ��ϴ�
     * @return string content
     */
    private function http_post($url,$param,$post_file=false){
        $oCurl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if (is_string($param) || $post_file) {
            $strPOST = $param;
        } else {
            $aPOST = array();
            foreach($param as $key=>$val){
                $aPOST[] = $key."=".urlencode($val);
            }
            $strPOST =  join("&", $aPOST);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($oCurl, CURLOPT_POST,true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if(intval($aStatus["http_code"])==200){
            return $sContent;
        }else{
            return false;
        }
    }

    /**
     * ���û��棬��������
     * @param string $cachename
     * @param mixed $value
     * @param int $expired
     * @return boolean
     */
    protected function setCache($cachename,$value,$expired){
        //TODO: set cache implementation
        return false;
    }

    /**
     * ��ȡ���棬��������
     * @param string $cachename
     * @return mixed
     */
    protected function getCache($cachename){
        //TODO: get cache implementation
        return false;
    }

    /**
     * ������棬��������
     * @param string $cachename
     * @return boolean
     */
    protected function removeCache($cachename){
        //TODO: remove cache implementation
        return false;
    }

    /**
     * ��ȡaccess_token
     * @param string $appid �������ʼ��ʱ���ṩ�����Ϊ��
     * @param string $appsecret �������ʼ��ʱ���ṩ�����Ϊ��
     * @param string $token �ֶ�ָ��access_token���Ǳ�Ҫ�����������
     */
    public function checkAuth($appid='',$appsecret='',$token=''){
        if (!$appid || !$appsecret) {
            $appid = $this->appid;
            $appsecret = $this->appsecret;
        }
        if ($token) { //�ֶ�ָ��token������ʹ��
            $this->access_token=$token;
            return $this->access_token;
        }

        $authname = 'wechat_access_token'.$appid;
        if ($rs = $this->getCache($authname))  {
            $this->access_token = $rs;
            return $rs;
        }

        $result = $this->http_get(self::API_URL_PREFIX.self::AUTH_URL.'appid='.$appid.'&secret='.$appsecret);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || isset($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            $this->access_token = $json['access_token'];
            $expire = $json['expires_in'] ? intval($json['expires_in'])-100 : 3600;
            $this->setCache($authname,$this->access_token,$expire);
            return $this->access_token;
        }
        return false;
    }

    /**
     * ɾ����֤����
     * @param string $appid
     */
    public function resetAuth($appid=''){
        if (!$appid) $appid = $this->appid;
        $this->access_token = '';
        $authname = 'wechat_access_token'.$appid;
        $this->removeCache($authname);
        return true;
    }

    /**
     * ɾ��JSAPI��ȨTICKET
     * @param string $appid ���ڶ��appidʱʹ��
     */
    public function resetJsTicket($appid=''){
        if (!$appid) $appid = $this->appid;
        $this->jsapi_ticket = '';
        $authname = 'wechat_jsapi_ticket'.$appid;
        $this->removeCache($authname);
        return true;
    }

    /**
     * ��ȡJSAPI��ȨTICKET
     * @param string $appid ���ڶ��appidʱʹ��,�ɿ�
     * @param string $jsapi_ticket �ֶ�ָ��jsapi_ticket���Ǳ�Ҫ�����������
     */
    public function getJsTicket($appid='',$jsapi_ticket=''){
        if (!$this->access_token && !$this->checkAuth()) return false;
        if (!$appid) $appid = $this->appid;
        if ($jsapi_ticket) { //�ֶ�ָ��token������ʹ��
            $this->jsapi_ticket = $jsapi_ticket;
            return $this->jsapi_ticket;
        }
        $authname = 'wechat_jsapi_ticket'.$appid;
        if ($rs = $this->getCache($authname))  {
            $this->jsapi_ticket = $rs;
            return $rs;
        }
        $result = $this->http_get(self::API_URL_PREFIX.self::GET_TICKET_URL.'access_token='.$this->access_token.'&type=jsapi');
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            $this->jsapi_ticket = $json['ticket'];
            $expire = $json['expires_in'] ? intval($json['expires_in'])-100 : 3600;
            $this->setCache($authname,$this->jsapi_ticket,$expire);
            return $this->jsapi_ticket;
        }
        return false;
    }


    /**
     * ��ȡJsApiʹ��ǩ��
     * @param string $url ��ҳ��URL���Զ�����#������沿��
     * @param string $timestamp ��ǰʱ��� (Ϊ�����Զ�����)
     * @param string $noncestr ����� (Ϊ�����Զ�����)
     * @param string $appid ���ڶ��appidʱʹ��,�ɿ�
     * @return array|bool ����ǩ���ִ�
     */
    public function getJsSign($url, $timestamp=0, $noncestr='', $appid=''){
        if (!$this->jsapi_ticket && !$this->getJsTicket($appid) || !$url) return false;
        if (!$timestamp)
            $timestamp = time();
        if (!$noncestr)
            $noncestr = $this->generateNonceStr();
        $ret = strpos($url,'#');
        if ($ret)
            $url = substr($url,0,$ret);
        $url = trim($url);
        if (empty($url))
            return false;
        $arrdata = array("timestamp" => $timestamp, "noncestr" => $noncestr, "url" => $url, "jsapi_ticket" => $this->jsapi_ticket);
        $sign = $this->getSignature($arrdata);
        if (!$sign)
            return false;
        $signPackage = array(
            "appid"     => $this->appid,
            "noncestr"  => $noncestr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $sign
        );
        return $signPackage;
    }

    /**
     * ΢��api��֧������ת���json�ṹ
     * @param array $arr
     */
    static function json_encode($arr) {
        $parts = array ();
        $is_list = false;
        //Find out if the given array is a numerical array
        $keys = array_keys ( $arr );
        $max_length = count ( $arr ) - 1;
        if (($keys [0] === 0) && ($keys [$max_length] === $max_length )) { //See if the first key is 0 and last key is length - 1
            $is_list = true;
            for($i = 0; $i < count ( $keys ); $i ++) { //See if each key correspondes to its position
                if ($i != $keys [$i]) { //A key fails at position check.
                    $is_list = false; //It is an associative array.
                    break;
                }
            }
        }
        foreach ( $arr as $key => $value ) {
            if (is_array ( $value )) { //Custom handling for arrays
                if ($is_list)
                    $parts [] = self::json_encode ( $value ); /* :RECURSION: */
                else
                    $parts [] = '"' . $key . '":' . self::json_encode ( $value ); /* :RECURSION: */
            } else {
                $str = '';
                if (! $is_list)
                    $str = '"' . $key . '":';
                //Custom handling for multiple data types
                if (!is_string ( $value ) && is_numeric ( $value ) && $value<2000000000)
                    $str .= $value; //Numbers
                elseif ($value === false)
                    $str .= 'false'; //The booleans
                elseif ($value === true)
                    $str .= 'true';
                else
                    $str .= '"' . addslashes ( $value ) . '"'; //All other things
                // :TODO: Is there any more datatype we should be in the lookout for? (Object?)
                $parts [] = $str;
            }
        }
        $json = implode ( ',', $parts );
        if ($is_list)
            return '[' . $json . ']'; //Return numerical JSON
        return '{' . $json . '}'; //Return associative JSON
    }

    /**
     * ��ȡǩ��
     * @param array $arrdata ǩ������
     * @param string $method ǩ������
     * @return boolean|string ǩ��ֵ
     */
    public function getSignature($arrdata,$method="sha1") {
        if (!function_exists($method)) return false;
        ksort($arrdata);
        $paramstring = "";
        foreach($arrdata as $key => $value)
        {
            if(strlen($paramstring) == 0)
                $paramstring .= $key . "=" . $value;
            else
                $paramstring .= "&" . $key . "=" . $value;
        }
        $Sign = $method($paramstring);
        return $Sign;
    }

    /**
     * ��������ִ�
     * @param number $length ���ȣ�Ĭ��Ϊ16���Ϊ32�ֽ�
     * @return string
     */
    public function generateNonceStr($length=16){
        // �����ַ������������������Ҫ���ַ�
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for($i = 0; $i < $length; $i++)
        {
            $str .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $str;
    }

    /**
     * ��ȡ΢�ŷ�����IP��ַ�б�
     * @return array('127.0.0.1','127.0.0.1')
     */
    public function getServerIp(){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_get(self::API_URL_PREFIX.self::CALLBACKSERVER_GET_URL.'access_token='.$this->access_token);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || isset($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json['ip_list'];
        }
        return false;
    }

    /**
     * �����˵�(��֤��Ķ��ĺſ���)
     * @param array $data �˵���������
     * example:
     * 	array (
     * 	    'button' => array (
     * 	      0 => array (
     * 	        'name' => 'ɨ��',
     * 	        'sub_button' => array (
     * 	            0 => array (
     * 	              'type' => 'scancode_waitmsg',
     * 	              'name' => 'ɨ�����ʾ',
     * 	              'key' => 'rselfmenu_0_0',
     * 	            ),
     * 	            1 => array (
     * 	              'type' => 'scancode_push',
     * 	              'name' => 'ɨ�����¼�',
     * 	              'key' => 'rselfmenu_0_1',
     * 	            ),
     * 	        ),
     * 	      ),
     * 	      1 => array (
     * 	        'name' => '��ͼ',
     * 	        'sub_button' => array (
     * 	            0 => array (
     * 	              'type' => 'pic_sysphoto',
     * 	              'name' => 'ϵͳ���շ�ͼ',
     * 	              'key' => 'rselfmenu_1_0',
     * 	            ),
     * 	            1 => array (
     * 	              'type' => 'pic_photo_or_album',
     * 	              'name' => '���ջ�����ᷢͼ',
     * 	              'key' => 'rselfmenu_1_1',
     * 	            )
     * 	        ),
     * 	      ),
     * 	      2 => array (
     * 	        'type' => 'location_select',
     * 	        'name' => '����λ��',
     * 	        'key' => 'rselfmenu_2_0'
     * 	      ),
     * 	    ),
     * 	)
     * type����ѡ��Ϊ���¼��֣�����5-8�����յ��˵��¼����⣬���ᵥ���յ���Ӧ���͵���Ϣ��
     * 1��click��������¼�
     * 2��view����תURL
     * 3��scancode_push��ɨ�����¼�
     * 4��scancode_waitmsg��ɨ�����¼��ҵ�������Ϣ�����С���ʾ��
     * 5��pic_sysphoto������ϵͳ���շ�ͼ
     * 6��pic_photo_or_album���������ջ�����ᷢͼ
     * 7��pic_weixin������΢����ᷢͼ��
     * 8��location_select����������λ��ѡ����
     */
    public function createMenu($data){
        if (!$this->access_token && !$this->checkAuth()) return false;
        //$result = $this->http_post(self::API_URL_PREFIX.self::MENU_CREATE_URL.'access_token='.$this->access_token,self::json_encode($data));
        $result = $this->http_post(self::API_URL_PREFIX.self::MENU_CREATE_URL.'access_token='.$this->access_token,$data);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ��ȡ�˵�(��֤��Ķ��ĺſ���)
     * @return array('menu'=>array(....s))
     */
    public function getMenu(){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_get(self::API_URL_PREFIX.self::MENU_GET_URL.'access_token='.$this->access_token);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || isset($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ɾ���˵�(��֤��Ķ��ĺſ���)
     * @return boolean
     */
    public function deleteMenu(){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_get(self::API_URL_PREFIX.self::MENU_DELETE_URL.'access_token='.$this->access_token);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * �ϴ���ʱ�زģ���Ч��Ϊ3��(��֤��Ķ��ĺſ���)
     * ע�⣺�ϴ����ļ�ʱ������Ҫ�ȵ��� set_time_limit(0) ���ⳬʱ
     * ע�⣺����ļ�ֵ���⣬���ļ���ǰ�����@��ʹ�õ������Ա��Ȿ��·��б�ܱ�ת��
     * ע�⣺��ʱ�زĵ�media_id�ǿɸ��õģ�
     * @param array $data {"media":'@Path\filename.jpg'}
     * @param type ���ͣ�ͼƬ:image ����:voice ��Ƶ:video ����ͼ:thumb
     * @return boolean|array
     */
    public function uploadMedia($data, $type){
        if (!$this->access_token && !$this->checkAuth()) return false;
        //ԭ�ȵ��ϴ���ý���ļ��ӿ�ʹ�� self::UPLOAD_MEDIA_URL ǰ׺
        $result = $this->http_post(self::API_URL_PREFIX.self::MEDIA_UPLOAD_URL.'access_token='.$this->access_token.'&type='.$type,$data,true);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡ��ʱ�ز�(��֤��Ķ��ĺſ���)
     * @param string $media_id ý���ļ�id
     * @param boolean $is_video �Ƿ�Ϊ��Ƶ�ļ���Ĭ��Ϊ��
     * @return raw data
     */
    public function getMedia($media_id,$is_video=false){
        if (!$this->access_token && !$this->checkAuth()) return false;
        //ԭ�ȵ��ϴ���ý���ļ��ӿ�ʹ�� self::UPLOAD_MEDIA_URL ǰ׺
        //���Ҫ��ȡ���ز�����Ƶ�ļ�ʱ������ʹ��httpsЭ�飬���������httpЭ��
        $url_prefix = $is_video?str_replace('https','http',self::API_URL_PREFIX):self::API_URL_PREFIX;
        $result = $this->http_get($url_prefix.self::MEDIA_GET_URL.'access_token='.$this->access_token.'&media_id='.$media_id);
        if ($result)
        {
            if (is_string($result)) {
                $json = json_decode($result,true);
                if (isset($json['errcode'])) {
                    $this->errCode = $json['errcode'];
                    $this->errMsg = $json['errmsg'];
                    return false;
                }
            }
            return $result;
        }
        return false;
    }


    /**
     * �ϴ������ز�(��֤��Ķ��ĺſ���)
     * �����������ز�Ҳ�����ڹ���ƽ̨�����زĹ���ģ���п���
     * ע�⣺�ϴ����ļ�ʱ������Ҫ�ȵ��� set_time_limit(0) ���ⳬʱ
     * ע�⣺����ļ�ֵ���⣬���ļ���ǰ�����@��ʹ�õ������Ա��Ȿ��·��б�ܱ�ת��
     * @param array $data {"media":'@Path\filename.jpg'}
     * @param type ���ͣ�ͼƬ:image ����:voice ��Ƶ:video ����ͼ:thumb
     * @param boolean $is_video �Ƿ�Ϊ��Ƶ�ļ���Ĭ��Ϊ��
     * @param array $video_info ��Ƶ��Ϣ���飬����Ƶ�زĲ���Ҫ�ṩ array('title'=>'��Ƶ����','introduction'=>'����')
     * @return boolean|array
     */
    public function uploadForeverMedia($data, $type,$is_video=false,$video_info=array()){
        if (!$this->access_token && !$this->checkAuth()) return false;
        //#TODO �ݲ�ȷ���˽ӿ��Ƿ���Ҫ����Ƶ�ļ���httpЭ��
        //���Ҫ��ȡ���ز�����Ƶ�ļ�ʱ������ʹ��httpsЭ�飬���������httpЭ��
        //$url_prefix = $is_video?str_replace('https','http',self::API_URL_PREFIX):self::API_URL_PREFIX;
        //���ϴ���Ƶ�ļ�ʱ��������Ƶ�ļ���Ϣ
        if ($is_video) $data['description'] = self::json_encode($video_info);
        $result = $this->http_post(self::API_URL_PREFIX.self::MEDIA_FOREVER_UPLOAD_URL.'access_token='.$this->access_token.'&type='.$type,$data,true);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �ϴ�����ͼ���ز�(��֤��Ķ��ĺſ���)
     * �����������ز�Ҳ�����ڹ���ƽ̨�����زĹ���ģ���п���
     * @param array $data ��Ϣ�ṹ{"articles":[{...}]}
     * @return boolean|array
     */
    public function uploadForeverArticles($data){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_URL_PREFIX.self::MEDIA_FOREVER_NEWS_UPLOAD_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �޸�����ͼ���ز�(��֤��Ķ��ĺſ���)
     * �����ز�Ҳ�����ڹ���ƽ̨�����زĹ���ģ���п���
     * @param string $media_id ͼ���ز�id
     * @param array $data ��Ϣ�ṹ{"articles":[{...}]}
     * @param int $index ���µ�������ͼ���زĵ�λ�ã���һƪΪ0������ͼ��ʹ��
     * @return boolean|array
     */
    public function updateForeverArticles($media_id,$data,$index=0){
        if (!$this->access_token && !$this->checkAuth()) return false;
        if (!isset($data['media_id'])) $data['media_id'] = $media_id;
        if (!isset($data['index'])) $data['index'] = $index;
        $result = $this->http_post(self::API_URL_PREFIX.self::MEDIA_FOREVER_NEWS_UPDATE_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡ�����ز�(��֤��Ķ��ĺſ���)
     * ����ͼ����Ϣ�������������ݣ�ʧ�ܷ���false
     * @param string $media_id ý���ļ�id
     * @param boolean $is_video �Ƿ�Ϊ��Ƶ�ļ���Ĭ��Ϊ��
     * @return boolean|array|raw data
     */
    public function getForeverMedia($media_id,$is_video=false){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array('media_id' => $media_id);
        //#TODO �ݲ�ȷ���˽ӿ��Ƿ���Ҫ����Ƶ�ļ���httpЭ��
        //���Ҫ��ȡ���ز�����Ƶ�ļ�ʱ������ʹ��httpsЭ�飬���������httpЭ��
        //$url_prefix = $is_video?str_replace('https','http',self::API_URL_PREFIX):self::API_URL_PREFIX;
        $result = $this->http_post(self::API_URL_PREFIX.self::MEDIA_FOREVER_GET_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            if (is_string($result)) {
                $json = json_decode($result,true);
                if (isset($json['errcode'])) {
                    $this->errCode = $json['errcode'];
                    $this->errMsg = $json['errmsg'];
                    return false;
                }
                return $json;
            }
            return $result;
        }
        return false;
    }

    /**
     * ɾ�������ز�(��֤��Ķ��ĺſ���)
     * @param string $media_id ý���ļ�id
     * @return boolean
     */
    public function delForeverMedia($media_id){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array('media_id' => $media_id);
        $result = $this->http_post(self::API_URL_PREFIX.self::MEDIA_FOREVER_DEL_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ��ȡ�����ز��б�(��֤��Ķ��ĺſ���)
     * @param string $type �زĵ�����,ͼƬ��image������Ƶ��video�������� ��voice����ͼ�ģ�news��
     * @param int $offset ȫ���زĵ�ƫ��λ�ã�0��ʾ�ӵ�һ���ز�
     * @param int $count �����زĵ�������ȡֵ��1��20֮��
     * @return boolean|array
     * ���������ʽ:
     * array(
     *  'total_count'=>0, //�����͵��زĵ�����
     *  'item_count'=>0,  //���ε��û�ȡ���زĵ�����
     *  'item'=>array()   //�ز��б����飬���ݶ�����ο��ٷ��ĵ�
     * )
     */
    public function getForeverList($type,$offset,$count){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array(
            'type' => $type,
            'offset' => $offset,
            'count' => $count,
        );
        $result = $this->http_post(self::API_URL_PREFIX.self::MEDIA_FOREVER_BATCHGET_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (isset($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡ�����ز�����(��֤��Ķ��ĺſ���)
     * @return boolean|array
     * ���������ʽ:
     * array(
     *  'voice_count'=>0, //����������
     *  'video_count'=>0, //��Ƶ������
     *  'image_count'=>0, //ͼƬ������
     *  'news_count'=>0   //ͼ��������
     * )
     */
    public function getForeverCount(){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_get(self::API_URL_PREFIX.self::MEDIA_FOREVER_COUNT_URL.'access_token='.$this->access_token);
        if ($result)
        {
            $json = json_decode($result,true);
            if (isset($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �ϴ�ͼ����Ϣ�زģ�����Ⱥ��(��֤��Ķ��ĺſ���)
     * @param array $data ��Ϣ�ṹ{"articles":[{...}]}
     * @return boolean|array
     */
    public function uploadArticles($data){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_URL_PREFIX.self::MEDIA_UPLOADNEWS_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �ϴ���Ƶ�ز�(��֤��Ķ��ĺſ���)
     * @param array $data ��Ϣ�ṹ
     * {
     *     "media_id"=>"",     //ͨ���ϴ�ý��ӿڵõ���MediaId
     *     "title"=>"TITLE",    //��Ƶ����
     *     "description"=>"Description"        //��Ƶ����
     * }
     * @return boolean|array
     * {
     *     "type":"video",
     *     "media_id":"mediaid",
     *     "created_at":1398848981
     *  }
     */
    public function uploadMpVideo($data){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::UPLOAD_MEDIA_URL.self::MEDIA_VIDEO_UPLOAD.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �߼�Ⱥ����Ϣ, ����OpenID�б�Ⱥ��ͼ����Ϣ(���ĺŲ�����)
     * 	ע�⣺��Ƶ��Ҫ�ڵ���uploadMedia()��������ʹ�� uploadMpVideo() �������ɣ�
     *             Ȼ���õ� mediaid ��������Ⱥ��������Ϣ����Ϊ mpvideo ���͡�
     * @param array $data ��Ϣ�ṹ
     * {
     *     "touser"=>array(
     *         "OPENID1",
     *         "OPENID2"
     *     ),
     *      "msgtype"=>"mpvideo",
     *      // ������5��������ѡ���Ӧ�Ĳ�������
     *      // mpnews | voice | image | mpvideo => array( "media_id"=>"MediaId")
     *      // text => array ( "content" => "hello")
     * }
     * @return boolean|array
     */
    public function sendMassMessage($data){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_URL_PREFIX.self::MASS_SEND_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �߼�Ⱥ����Ϣ, ����Ⱥ��idȺ��ͼ����Ϣ(��֤��Ķ��ĺſ���)
     * 	ע�⣺��Ƶ��Ҫ�ڵ���uploadMedia()��������ʹ�� uploadMpVideo() �������ɣ�
     *             Ȼ���õ� mediaid ��������Ⱥ��������Ϣ����Ϊ mpvideo ���͡�
     * @param array $data ��Ϣ�ṹ
     * {
     *     "filter"=>array(
     *         "is_to_all"=>False,     //�Ƿ�Ⱥ���������û�.True���÷���id��False����д����id
     *         "group_id"=>"2"     //Ⱥ���ķ���id
     *     ),
     *      "msgtype"=>"mpvideo",
     *      // ������5��������ѡ���Ӧ�Ĳ�������
     *      // mpnews | voice | image | mpvideo => array( "media_id"=>"MediaId")
     *      // text => array ( "content" => "hello")
     * }
     * @return boolean|array
     */
    public function sendGroupMassMessage($data){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_URL_PREFIX.self::MASS_SEND_GROUP_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �߼�Ⱥ����Ϣ, ɾ��Ⱥ��ͼ����Ϣ(��֤��Ķ��ĺſ���)
     * @param int $msg_id ��Ϣid
     * @return boolean|array
     */
    public function deleteMassMessage($msg_id){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_URL_PREFIX.self::MASS_DELETE_URL.'access_token='.$this->access_token,self::json_encode(array('msg_id'=>$msg_id)));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * �߼�Ⱥ����Ϣ, Ԥ��Ⱥ����Ϣ(��֤��Ķ��ĺſ���)
     * 	ע�⣺��Ƶ��Ҫ�ڵ���uploadMedia()��������ʹ�� uploadMpVideo() �������ɣ�
     *             Ȼ���õ� mediaid ��������Ⱥ��������Ϣ����Ϊ mpvideo ���͡�
     * @param array $data ��Ϣ�ṹ
     * {
     *     "touser"=>"OPENID",
     *      "msgtype"=>"mpvideo",
     *      // ������5��������ѡ���Ӧ�Ĳ�������
     *      // mpnews | voice | image | mpvideo => array( "media_id"=>"MediaId")
     *      // text => array ( "content" => "hello")
     * }
     * @return boolean|array
     */
    public function previewMassMessage($data){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_URL_PREFIX.self::MASS_PREVIEW_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �߼�Ⱥ����Ϣ, ��ѯȺ����Ϣ����״̬(��֤��Ķ��ĺſ���)
     * @param int $msg_id ��Ϣid
     * @return boolean|array
     * {
     *     "msg_id":201053012,     //Ⱥ����Ϣ�󷵻ص���Ϣid
     *     "msg_status":"SEND_SUCCESS" //��Ϣ���ͺ��״̬��SENDING��ʾ���ڷ��� SEND_SUCCESS��ʾ���ͳɹ�
     * }
     */
    public function queryMassMessage($msg_id){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_URL_PREFIX.self::MASS_QUERY_URL.'access_token='.$this->access_token,self::json_encode(array('msg_id'=>$msg_id)));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ������ά��ticket
     * @param int|string $scene_id �Զ���׷��id,��ʱ��ά��ֻ������ֵ��
     * @param int $type 0:��ʱ��ά�룻1:���ö�ά��(��ʱexpire������Ч)��2:���ö�ά��(��ʱexpire������Ч)
     * @param int $expire ��ʱ��ά����Ч�ڣ����Ϊ1800��
     * @return array('ticket'=>'qrcode�ִ�','expire_seconds'=>1800,'url'=>'��ά��ͼƬ������ĵ�ַ')
     */
    public function getQRCode($scene_id,$type=0,$expire=1800){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $type = ($type && is_string($scene_id))?2:$type;
        $data = array(
            'action_name'=>$type?($type == 2?"QR_LIMIT_STR_SCENE":"QR_LIMIT_SCENE"):"QR_SCENE",
            'expire_seconds'=>$expire,
            'action_info'=>array('scene'=>($type == 2?array('scene_str'=>$scene_id):array('scene_id'=>$scene_id)))
        );
        if ($type == 1) {
            unset($data['expire_seconds']);
        }
        $result = $this->http_post(self::API_URL_PREFIX.self::QRCODE_CREATE_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡ��ά��ͼƬ
     * @param string $ticket ������getQRCode�������ɵ�ticket����
     * @return string url ����http��ַ
     */
    public function getQRUrl($ticket) {
        return self::QRCODE_IMG_URL.urlencode($ticket);
    }

    /**
     * ������ת�����ӽӿ�
     * @param string $long_url ����Ҫת���ĳ�url
     * @return boolean|string url �ɹ��򷵻�ת����Ķ�url
     */
    public function getShortUrl($long_url){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array(
            'action'=>'long2short',
            'long_url'=>$long_url
        );
        $result = $this->http_post(self::API_URL_PREFIX.self::SHORT_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json['short_url'];
        }
        return false;
    }

    /**
     * ��ȡͳ������
     * @param string $type  ���ݷ���(user|article|upstreammsg|interface)�ֱ�Ϊ(�û�����|ͼ�ķ���|��Ϣ����|�ӿڷ���)
     * @param string $subtype   �����ӷ��࣬�ο� DATACUBE_URL_ARR �������岿�� ����README.md˵���ĵ�
     * @param string $begin_date ��ʼʱ��
     * @param string $end_date   ����ʱ��
     * @return boolean|array �ɹ����ز�ѯ������飬�䶨���뿴�ٷ��ĵ�
     */
    public function getDatacube($type,$subtype,$begin_date,$end_date=''){
        if (!$this->access_token && !$this->checkAuth()) return false;
        if (!isset(self::$DATACUBE_URL_ARR[$type]) || !isset(self::$DATACUBE_URL_ARR[$type][$subtype]))
            return false;
        $data = array(
            'begin_date'=>$begin_date,
            'end_date'=>$end_date?$end_date:$begin_date
        );
        $result = $this->http_post(self::API_BASE_URL_PREFIX.self::$DATACUBE_URL_ARR[$type][$subtype].'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return isset($json['list'])?$json['list']:$json;
        }
        return false;
    }

    /**
     * ������ȡ��ע�û��б�
     * @param unknown $next_openid
     */
    public function getUserList($next_openid=''){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_get(self::API_URL_PREFIX.self::USER_GET_URL.'access_token='.$this->access_token.'&next_openid='.$next_openid);
        if ($result)
        {
            $json = json_decode($result,true);
            if (isset($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡ��ע����ϸ��Ϣ
     * @param string $openid
     * @return array {subscribe,openid,nickname,sex,city,province,country,language,headimgurl,subscribe_time,[unionid]}
     * ע�⣺unionid�ֶ� ֻ�����û������ںŰ󶨵�΢�ſ���ƽ̨�˺ź󣬲Ż���֡��������ǰ��isset()���һ��
     */
    public function getUserInfo($openid){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_get(self::API_URL_PREFIX.self::USER_INFO_URL.'access_token='.$this->access_token.'&openid='.$openid);
        if ($result)
        {
            $json = json_decode($result,true);
            if (isset($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �����û���ע��
     * @param string $openid
     * @param string $remark ��ע��
     * @return boolean|array
     */
    public function updateUserRemark($openid,$remark){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array(
            'openid'=>$openid,
            'remark'=>$remark
        );
        $result = $this->http_post(self::API_URL_PREFIX.self::USER_UPDATEREMARK_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡ�û������б�
     * @return boolean|array
     */
    public function getGroup(){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_get(self::API_URL_PREFIX.self::GROUP_GET_URL.'access_token='.$this->access_token);
        if ($result)
        {
            $json = json_decode($result,true);
            if (isset($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡ�û����ڷ���
     * @param string $openid
     * @return boolean|int �ɹ��򷵻��û�����id
     */
    public function getUserGroup($openid){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array(
            'openid'=>$openid
        );
        $result = $this->http_post(self::API_URL_PREFIX.self::USER_GROUP_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            } else
                if (isset($json['groupid'])) return $json['groupid'];
        }
        return false;
    }

    /**
     * �����Զ�����
     * @param string $name ��������
     * @return boolean|array
     */
    public function createGroup($name){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array(
            'group'=>array('name'=>$name)
        );
        $result = $this->http_post(self::API_URL_PREFIX.self::GROUP_CREATE_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ���ķ�������
     * @param int $groupid ����id
     * @param string $name ��������
     * @return boolean|array
     */
    public function updateGroup($groupid,$name){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array(
            'group'=>array('id'=>$groupid,'name'=>$name)
        );
        $result = $this->http_post(self::API_URL_PREFIX.self::GROUP_UPDATE_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �ƶ��û�����
     * @param int $groupid ����id
     * @param string $openid �û�openid
     * @return boolean|array
     */
    public function updateGroupMembers($groupid,$openid){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array(
            'openid'=>$openid,
            'to_groupid'=>$groupid
        );
        $result = $this->http_post(self::API_URL_PREFIX.self::GROUP_MEMBER_UPDATE_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �����ƶ��û�����
     * @param int $groupid ����id
     * @param string $openid_list �û�openid����,һ�β��ܳ���50��
     * @return boolean|array
     */
    public function batchUpdateGroupMembers($groupid,$openid_list){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data = array(
            'openid_list'=>$openid_list,
            'to_groupid'=>$groupid
        );
        $result = $this->http_post(self::API_URL_PREFIX.self::GROUP_MEMBER_BATCHUPDATE_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ���Ϳͷ���Ϣ
     * @param array $data ��Ϣ�ṹ{"touser":"OPENID","msgtype":"news","news":{...}}
     * @return boolean|array
     */
    public function sendCustomMessage($data){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_URL_PREFIX.self::CUSTOM_SEND_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * oauth ��Ȩ��ת�ӿ�
     * @param string $callback �ص�URI
     * @return string
     */
    public function getOauthRedirect($callback,$state='',$scope='snsapi_userinfo'){
        return self::OAUTH_PREFIX.self::OAUTH_AUTHORIZE_URL.'appid='.$this->appid.'&redirect_uri='.urlencode($callback).'&response_type=code&scope='.$scope.'&state='.$state.'#wechat_redirect';
    }

    /**
     * ͨ��code��ȡAccess Token
     * @return array {access_token,expires_in,refresh_token,openid,scope}
     */
    public function getOauthAccessToken(){
        $code = isset($_GET['code'])?$_GET['code']:'';
        if (!$code) return false;
        $result = $this->http_get(self::API_BASE_URL_PREFIX.self::OAUTH_TOKEN_URL.'appid='.$this->appid.'&secret='.$this->appsecret.'&code='.$code.'&grant_type=authorization_code');
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            $this->user_token = $json['access_token'];
            return $json;
        }
        return false;
    }

    /**
     * ˢ��access token������
     * @param string $refresh_token
     * @return boolean|mixed
     */
    public function getOauthRefreshToken($refresh_token){
        $result = $this->http_get(self::API_BASE_URL_PREFIX.self::OAUTH_REFRESH_URL.'appid='.$this->appid.'&grant_type=refresh_token&refresh_token='.$refresh_token);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            $this->user_token = $json['access_token'];
            return $json;
        }
        return false;
    }

    /**
     * ��ȡ��Ȩ����û�����
     * @param string $access_token
     * @param string $openid
     * @return array {openid,nickname,sex,province,city,country,headimgurl,privilege,[unionid]}
     * ע�⣺unionid�ֶ� ֻ�����û������ںŰ󶨵�΢�ſ���ƽ̨�˺ź󣬲Ż���֡��������ǰ��isset()���һ��
     */
    public function getOauthUserinfo($access_token,$openid){
        $result = $this->http_get(self::API_BASE_URL_PREFIX.self::OAUTH_USERINFO_URL.'access_token='.$access_token.'&openid='.$openid);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ������Ȩƾ֤�Ƿ���Ч
     * @param string $access_token
     * @param string $openid
     * @return boolean �Ƿ���Ч
     */
    public function getOauthAuth($access_token,$openid){
        $result = $this->http_get(self::API_BASE_URL_PREFIX.self::OAUTH_AUTH_URL.'access_token='.$access_token.'&openid='.$openid);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            } else
                if ($json['errcode']==0) return true;
        }
        return false;
    }

    /**
     * ģ����Ϣ ����������ҵ
     * @param int $id1  ���ں�ģ����Ϣ������ҵ��ţ��ο��ٷ������ĵ� ��ҵ����
     * @param int $id2  ͬ$id1�������ֻ��һ����ҵ���˲�����ʡ��
     * @return boolean|array
     */
    public function setTMIndustry($id1,$id2=''){
        if ($id1) $data['industry_id1'] = $id1;
        if ($id2) $data['industry_id2'] = $id2;
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_URL_PREFIX.self::TEMPLATE_SET_INDUSTRY_URL.'access_token='.$this->access_token,self::json_encode($data));
        if($result){
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ģ����Ϣ �����Ϣģ��
     * �ɹ�������Ϣģ��ĵ���id
     * @param string $tpl_id ģ�����ģ��ı�ţ��С�TM**���͡�OPENTMTM**������ʽ
     * @return boolean|string
     */
    public function addTemplateMessage($tpl_id){
        $data = array ('template_id_short' =>$tpl_id);
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_URL_PREFIX.self::TEMPLATE_ADD_TPL_URL.'access_token='.$this->access_token,self::json_encode($data));
        if($result){
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json['template_id'];
        }
        return false;
    }

    /**
     * ����ģ����Ϣ
     * @param array $data ��Ϣ�ṹ
     * ��
    "touser":"OPENID",
    "template_id":"ngqIpbwh8bUfcSsECmogfXcV14J0tQlEpBO27izEYtY",
    "url":"http://weixin.qq.com/download",
    "topcolor":"#FF0000",
    "data":{
    "������1": {
    "value":"����",
    "color":"#173177"	 //������ɫ
    },
    "Date":{
    "value":"06��07�� 19ʱ24��",
    "color":"#173177"
    },
    "CardNumber":{
    "value":"0426",
    "color":"#173177"
    },
    "Type":{
    "value":"����",
    "color":"#173177"
    }
    }
    }
     * @return boolean|array
     */
    public function sendTemplateMessage($data){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_URL_PREFIX.self::TEMPLATE_SEND_URL.'access_token='.$this->access_token,self::json_encode($data));
        if($result){
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡ��ͷ��Ự��¼
     * @param array $data ���ݽṹ{"starttime":123456789,"endtime":987654321,"openid":"OPENID","pagesize":10,"pageindex":1,}
     * @return boolean|array
     */
    public function getCustomServiceMessage($data){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_URL_PREFIX.self::CUSTOM_SERVICE_GET_RECORD.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ת����ͷ���Ϣ
     * Example: $obj->transfer_customer_service($customer_account)->reply();
     * @param string $customer_account ת����ָ���ͷ��ʺţ�test1@test
     */
    public function transfer_customer_service($customer_account = '')
    {
        $msg = array(
            'ToUserName' => $this->getRevFrom(),
            'FromUserName'=>$this->getRevTo(),
            'CreateTime'=>time(),
            'MsgType'=>'transfer_customer_service',
        );
        if ($customer_account) {
            $msg['TransInfo'] = array('KfAccount'=>$customer_account);
        }
        $this->Message($msg);
        return $this;
    }

    /**
     * ��ȡ��ͷ��ͷ�������Ϣ
     *
     * @return boolean|array
     */
    public function getCustomServiceKFlist(){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_get(self::API_URL_PREFIX.self::CUSTOM_SERVICE_GET_KFLIST.'access_token='.$this->access_token);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡ��ͷ����߿ͷ��Ӵ���Ϣ
     *
     * @return boolean|array {
    "kf_online_list": [
    {
    "kf_account": "test1@test",	//�ͷ��˺�@΢�ű���
    "status": 1,			//�ͷ�����״̬ 1��pc���ߣ�2���ֻ�����,��pc���ֻ�ͬʱ������Ϊ 1+2=3
    "kf_id": "1001",		//�ͷ�����
    "auto_accept": 0,		//�ͷ����õ�����Զ�������
    "accepted_case": 1		//�ͷ���ǰ���ڽӴ��ĻỰ��
    }
    ]
    }
     */
    public function getCustomServiceOnlineKFlist(){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_get(self::API_URL_PREFIX.self::CUSTOM_SERVICE_GET_ONLINEKFLIST.'access_token='.$this->access_token);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ����ָ����ͷ��Ự
     * @tutorial ���û��ѱ������ͷ��Ӵ���ָ���ͷ����������ʧ��
     * @param string $openid           //�û�openid
     * @param string $kf_account     //�ͷ��˺�
     * @param string $text                 //������Ϣ���ı���չʾ�ڿͷ���Ա�Ķ�ͷ��ͻ��ˣ���Ϊ��
     * @return boolean | array            //�ɹ�����json����
     * {
     *   "errcode": 0,
     *   "errmsg": "ok",
     * }
     */
    public function createKFSession($openid,$kf_account,$text=''){
        $data=array(
            "openid" =>$openid,
            "kf_account" => $kf_account
        );
        if ($text) $data["text"] = $text;
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX.self::CUSTOM_SESSION_CREATE.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �ر�ָ����ͷ��Ự
     * @tutorial ���û��������ͷ��Ӵ�ʱ���ʧ��
     * @param string $openid           //�û�openid
     * @param string $kf_account     //�ͷ��˺�
     * @param string $text                 //������Ϣ���ı���չʾ�ڿͷ���Ա�Ķ�ͷ��ͻ��ˣ���Ϊ��
     * @return boolean | array            //�ɹ�����json����
     * {
     *   "errcode": 0,
     *   "errmsg": "ok",
     * }
     */
    public function closeKFSession($openid,$kf_account,$text=''){
        $data=array(
            "openid" =>$openid,
            "nickname" => $kf_account
        );
        if ($text) $data["text"] = $text;
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX.self::CUSTOM_SESSION_CLOSE .'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡ�û��Ự״̬
     * @param string $openid           //�û�openid
     * @return boolean | array            //�ɹ�����json����
     * {
     *     "errcode" : 0,
     *     "errmsg" : "ok",
     *     "kf_account" : "test1@test",    //���ڽӴ��Ŀͷ�
     *     "createtime": 123456789,        //�Ự����ʱ��
     *  }
     */
    public function getKFSession($openid){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_get(self::API_BASE_URL_PREFIX.self::CUSTOM_SESSION_GET .'access_token='.$this->access_token.'&openid='.$openid);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡָ���ͷ��ĻỰ�б�
     * @param string $openid           //�û�openid
     * @return boolean | array            //�ɹ�����json����
     *  array(
     *     'sessionlist' => array (
     *         array (
     *             'openid'=>'OPENID',             //�ͻ� openid
     *             'createtime'=>123456789,  //�Ự����ʱ�䣬UNIX ʱ���
     *         ),
     *         array (
     *             'openid'=>'OPENID',             //�ͻ� openid
     *             'createtime'=>123456789,  //�Ự����ʱ�䣬UNIX ʱ���
     *         ),
     *     )
     *  )
     */
    public function getKFSessionlist($kf_account){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_get(self::API_BASE_URL_PREFIX.self::CUSTOM_SESSION_GET_LIST .'access_token='.$this->access_token.'&kf_account='.$kf_account);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡδ����Ự�б�
     * @param string $openid           //�û�openid
     * @return boolean | array            //�ɹ�����json����
     *  array (
     *     'count' => 150 ,                            //δ����Ự����
     *     'waitcaselist' => array (
     *         array (
     *             'openid'=>'OPENID',             //�ͻ� openid
     *             'kf_account ' =>'',                   //ָ���Ӵ��Ŀͷ���Ϊ����δָ��
     *             'createtime'=>123456789,  //�Ự����ʱ�䣬UNIX ʱ���
     *         ),
     *         array (
     *             'openid'=>'OPENID',             //�ͻ� openid
     *             'kf_account ' =>'',                   //ָ���Ӵ��Ŀͷ���Ϊ����δָ��
     *             'createtime'=>123456789,  //�Ự����ʱ�䣬UNIX ʱ���
     *         )
     *     )
     *  )
     */
    public function getKFSessionWait(){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_get(self::API_BASE_URL_PREFIX.self::CUSTOM_SESSION_GET_WAIT .'access_token='.$this->access_token);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ӿͷ��˺�
     *
     * @param string $account      //�����ͷ��˺ţ���ʽΪ���˺�ǰ׺@���ں�΢�źţ��˺�ǰ׺���10���ַ���������Ӣ�Ļ��������ַ�
     * @param string $nickname     //�ͷ��ǳƣ��6�����ֻ�12��Ӣ���ַ�
     * @param string $password     //�ͷ��˺����ĵ�¼���룬���Զ�����
     * @return boolean|array
     * �ɹ����ؽ��
     * {
     *   "errcode": 0,
     *   "errmsg": "ok",
     * }
     */
    public function addKFAccount($account,$nickname,$password){
        $data=array(
            "kf_account" =>$account,
            "nickname" => $nickname,
            "password" => md5($password)
        );
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX.self::CS_KF_ACCOUNT_ADD_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �޸Ŀͷ��˺���Ϣ
     *
     * @param string $account      //�����ͷ��˺ţ���ʽΪ���˺�ǰ׺@���ں�΢�źţ��˺�ǰ׺���10���ַ���������Ӣ�Ļ��������ַ�
     * @param string $nickname     //�ͷ��ǳƣ��6�����ֻ�12��Ӣ���ַ�
     * @param string $password     //�ͷ��˺����ĵ�¼���룬���Զ�����
     * @return boolean|array
     * �ɹ����ؽ��
     * {
     *   "errcode": 0,
     *   "errmsg": "ok",
     * }
     */
    public function updateKFAccount($account,$nickname,$password){
        $data=array(
            "kf_account" =>$account,
            "nickname" => $nickname,
            "password" => md5($password)
        );
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX.self::CS_KF_ACCOUNT_UPDATE_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ɾ���ͷ��˺�
     *
     * @param string $account      //�����ͷ��˺ţ���ʽΪ���˺�ǰ׺@���ں�΢�źţ��˺�ǰ׺���10���ַ���������Ӣ�Ļ��������ַ�
     * @return boolean|array
     * �ɹ����ؽ��
     * {
     *   "errcode": 0,
     *   "errmsg": "ok",
     * }
     */
    public function deleteKFAccount($account){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_get(self::API_BASE_URL_PREFIX.self::CS_KF_ACCOUNT_DEL_URL.'access_token='.$this->access_token.'&kf_account='.$account);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �ϴ��ͷ�ͷ��
     *
     * @param string $account //�����ͷ��˺ţ���ʽΪ���˺�ǰ׺@���ں�΢�źţ��˺�ǰ׺���10���ַ���������Ӣ�Ļ��������ַ�
     * @param string $imgfile //ͷ���ļ�����·��,�磺'D:\user.jpg'��ͷ���ļ�����JPG��ʽ�����ؽ���640*640
     * @return boolean|array
     * �ɹ����ؽ��
     * {
     *   "errcode": 0,
     *   "errmsg": "ok",
     * }
     */
    public function setKFHeadImg($account,$imgfile){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX.self::CS_KF_ACCOUNT_UPLOAD_HEADIMG_URL.'access_token='.$this->access_token.'&kf_account='.$account,array('media'=>'@'.$imgfile),true);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * �������ӿ�
     * @param String $uid      �û�Ψһid���ǿ�����id�����û����ֹ��ں��µĲ�ͬ�û������������û�openid��
     * @param String $query    �����ı���
     * @param String $category ��Ҫʹ�õķ������ͣ�����á���������������Ϊ��
     * @param Float $latitude  γ�����꣬�뾭��ͬʱ���룻����ж�ѡһ����
     * @param Float $longitude �������꣬��γ��ͬʱ���룻����ж�ѡһ����
     * @param String $city     �������ƣ��뾭γ�ȶ�ѡһ����
     * @param String $region   �������ƣ��ڳ��д��ڵ�����¿�ʡ�ԣ��뾭γ�ȶ�ѡһ����
     * @return boolean|array
     */
    public function querySemantic($uid,$query,$category,$latitude=0,$longitude=0,$city="",$region=""){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $data=array(
            'query' => $query,
            'category' => $category,
            'appid' => $this->appid,
            'uid' => ''
        );
        //���������������ƶ�ѡһ
        if ($latitude) {
            $data['latitude'] = $latitude;
            $data['longitude'] = $longitude;
        } elseif ($city) {
            $data['city'] = $city;
        } elseif ($region) {
            $data['region'] = $region;
        }
        $result = $this->http_post(self::API_BASE_URL_PREFIX.self::SEMANTIC_API_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ������ȯ
     * @param Array $data      ��ȯ����
     * @return array|boolean ����������card_idΪ��ȯID
     */
    public function createCard($data) {
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_CREATE . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ���Ŀ�ȯ��Ϣ
     * ���øýӿڸ�����Ϣ����������󣬿�ȯ״̬���Ϊ����ˡ��ѱ��û���ȡ�Ŀ�ȯ��ʵʱ����Ʊ����Ϣ��
     * @param string $data
     * @return boolean
     */
    public function updateCard($data) {
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_UPDATE . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ɾ����ȯ
     * �����̻�ɾ������һ�࿨ȯ��ɾ����ȯ�󣬸ÿ�ȯ��Ӧ�����ɵ���ȡ�ö�ά�롢��ӵ����� JS API ����ʧЧ��
     * ע�⣺ɾ����ȯ����ɾ���ѱ��û���ȡ��������΢�ſͻ����еĿ�ȯ������ȡ�Ŀ�ȯ������Ч��
     * @param string $card_id ��ȯID
     * @return boolean
     */
    public function delCard($card_id) {
        $data = array(
            'card_id' => $card_id,
        );
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_DELETE . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ��ѯ��ȯ����
     * @param string $card_id
     * @return boolean|array    ����������Ϣ�Ƚϸ��ӣ���ο���ȯ�ӿ��ĵ�
     */
    public function getCardInfo($card_id) {
        $data = array(
            'card_id' => $card_id,
        );
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_GET . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡ��ɫ�б�
     * ��ÿ�ȯ��������ɫ�б����ڴ�����ȯ
     * @return boolean|array   ����������ο� ΢�ſ�ȯ�ӿ��ĵ� ��json��ʽ
     */
    public function getCardColors() {
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_get(self::API_BASE_URL_PREFIX . self::CARD_GETCOLORS . 'access_token=' . $this->access_token);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ȡ�ŵ��б�
     * ��ȡ�ڹ���ƽ̨�����봴�����ŵ��б�
     * @param int $offset  ��ʼ��ȡ��ƫ�ƣ�Ĭ��Ϊ0��ͷ��ʼ
     * @param int $count   ��ȡ��������Ĭ��Ϊ0��ȡȫ��
     * @return boolean|array   ����������ο� ΢�ſ�ȯ�ӿ��ĵ� ��json��ʽ
     */
    public function getCardLocations($offset=0,$count=0) {
        $data=array(
            'offset'=>$offset,
            'count'=>$count
        );
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_LOCATION_BATCHGET . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ���������ŵ���Ϣ
     * @tutorial ���ز�����ŵ�id�б��Զ��ŷָ�������в���ʧ�ܵģ���Ϊ-1�������к˲����ĸ�����ʧ��
     * @param array $data    ������ʽ��json���ݣ��������ݽ϶࣬�������ݸ�ʽ��鿴 ΢�ſ�ȯ�ӿ��ĵ�
     * @return boolean|string �ɹ����ز�����ŵ�id�б�
     */
    public function addCardLocations($data) {
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_LOCATION_BATCHADD . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ���ɿ�ȯ��ά��
     * �ɹ���ֱ�ӷ���ticketֵ�������� getQRUrl($ticket) ��ȡ��ά��url
     *
     * @param string $cardid ��ȯID ����
     * @param string $code ָ����ȯ code �룬ֻ�ܱ���һ�Ρ�use_custom_code �ֶ�Ϊ true �Ŀ�ȯ������д�����Զ��� code ������д��
     * @param string $openid ָ����ȡ�ߵ� openid��ֻ�и��û�����ȡ��bind_openid �ֶ�Ϊ true �Ŀ�ȯ������д�����Զ��� openid ������д��
     * @param int $expire_seconds ָ����ά�����Чʱ�䣬��Χ�� 60 ~ 1800 �롣����Ĭ��Ϊ������Ч��
     * @param boolean $is_unique_code ָ���·���ά�룬���ɵĶ�ά���������һ�� code����ȡ�󲻿��ٴ�ɨ�衣��д true �� false��Ĭ�� false��
     * @param string $balance ������Է�Ϊ��λ��������ͱ��LUCKY_MONEY����������ȯ���Ͳ��
     * @return boolean|string
     */
    public function createCardQrcode($card_id,$code='',$openid='',$expire_seconds=0,$is_unique_code=false,$balance='') {
        $card = array(
            'card_id' => $card_id
        );
        if ($code)
            $card['code'] = $code;
        if ($openid)
            $card['openid'] = $openid;
        if ($expire_seconds)
            $card['expire_seconds'] = $expire_seconds;
        if ($is_unique_code)
            $card['is_unique_code'] = $is_unique_code;
        if ($balance)
            $card['balance'] = $balance;
        $data = array(
            'action_name' => "QR_CARD",
            'action_info' => array('card' => $card)
        );
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_QRCODE_CREATE . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ���� code
     * �Զ��� code��use_custom_code Ϊ true�����Ż�ȯ���� code ������ʱ��������ô˽ӿڡ�
     *
     * @param string $code Ҫ���ĵ����к�
     * @param string $card_id Ҫ�������к������� card_id��������ȯʱuse_custom_code ��д true ʱ���
     * @return boolean|array
     * {
     *  "errcode":0,
     *  "errmsg":"ok",
     *  "card":{"card_id":"pFS7Fjg8kV1IdDz01r4SQwMkuCKc"},
     *  "openid":"oFS7Fjl0WsZ9AMZqrI80nbIq8xrA"
     * }
     */
    public function consumeCardCode($code,$card_id='') {
        $data = array('code' => $code);
        if ($card_id)
            $data['card_id'] = $card_id;
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_CODE_CONSUME . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * code ����
     * @param string $encrypt_code ͨ�� choose_card_info ��ȡ�ļ����ַ���
     * @return boolean|array
     * {
     *  "errcode":0,
     *  "errmsg":"ok",
     *  "code":"751234212312"
     *  }
     */
    public function decryptCardCode($encrypt_code) {
        $data = array(
            'encrypt_code' => $encrypt_code,
        );
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_CODE_DECRYPT . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ��ѯ code ����Ч�ԣ����Զ��� code��
     * @param string $code
     * @return boolean|array
     * {
     *  "errcode":0,
     *  "errmsg":"ok",
     *  "openid":"oFS7Fjl0WsZ9AMZqrI80nbIq8xrA",    //�û� openid
     *  "card":{
     *      "card_id":"pFS7Fjg8kV1IdDz01r4SQwMkuCKc",
     *      "begin_time": 1404205036,               //��ʼʹ��ʱ��
     *      "end_time": 1404205036,                 //����ʱ��
     *  }
     * }
     */
    public function checkCardCode($code) {
        $data = array(
            'code' => $code,
        );
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_CODE_GET . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ������ѯ���б�
     * @param $offset  ��ʼ��ȡ��ƫ�ƣ�Ĭ��Ϊ0��ͷ��ʼ
     * @param $count   ��Ҫ��ѯ�Ŀ�Ƭ���������������50,Ĭ��50��
     * @return boolean|array
     * {
     *  "errcode":0,
     *  "errmsg":"ok",
     *  "card_id_list":["ph_gmt7cUVrlRk8swPwx7aDyF-pg"],    //�� id �б�
     *  "total_num":1                                       //���̻����� card_id ����
     * }
     */
    public function getCardIdList($offset=0,$count=50) {
        if ($count>50)
            $count = 50;
        $data = array(
            'offset' => $offset,
            'count'  => $count,
        );
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_BATCHGET . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ���� code
     * Ϊȷ��ת����İ�ȫ�ԣ�΢�������Զ���code���̻������·���code���и��ġ�
     * ע��Ϊ�����û��ɻ󣬽�����ڷ���ת����Ϊ�󣨷���ת����΢�Ż�ͨ���¼����͵ķ�ʽ��֪�̻���ת���Ŀ�ȯcode�����û���code���и��ġ�
     * @param string $code      ��ȯ�� code ����
     * @param string $card_id   ��ȯ ID
     * @param string $new_code  �µĿ�ȯ code ����
     * @return boolean
     */
    public function updateCardCode($code,$card_id,$new_code) {
        $data = array(
            'code' => $code,
            'card_id' => $card_id,
            'new_code' => $new_code,
        );
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_CODE_UPDATE . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ���ÿ�ȯʧЧ
     * ���ÿ�ȯʧЧ�Ĳ���������
     * @param string $code ��Ҫ����ΪʧЧ�� code
     * @param string $card_id �Զ��� code �Ŀ�ȯ������Զ��� code �Ŀ�ȯ���
     * @return boolean
     */
    public function unavailableCardCode($code,$card_id='') {
        $data = array(
            'code' => $code,
        );
        if ($card_id)
            $data['card_id'] = $card_id;
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_CODE_UNAVAILABLE . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ����޸�
     * @param string $data
     * @return boolean
     */
    public function modifyCardStock($data) {
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_MODIFY_STOCK . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ����/�󶨻�Ա��
     * @param string $data ����ṹ��ο���ȯ�����ĵ�(6.1.1 ����/�󶨻�Ա��)�½�
     * @return boolean
     */
    public function activateMemberCard($data) {
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_MEMBERCARD_ACTIVATE . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ��Ա������
     * ��Ա�����׺�ÿ�λ��ּ��������ͨ���ӿ�֪ͨ΢�ţ����ں�����Ϣ֪ͨ��������չ���ܡ�
     * @param string $data ����ṹ��ο���ȯ�����ĵ�(6.1.2 ��Ա������)�½�
     * @return boolean|array
     */
    public function updateMemberCard($data) {
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_MEMBERCARD_UPDATEUSER . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * ���º�����
     * @param string $code      ��������к�
     * @param $balance          ������
     * @param string $card_id   �Զ��� code �Ŀ�ȯ������Զ��� code �ɲ��
     * @return boolean|array
     */
    public function updateLuckyMoney($code,$balance,$card_id='') {
        $data = array(
            'code' => $code,
            'balance' => $balance
        );
        if ($card_id)
            $data['card_id'] = $card_id;
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_LUCKYMONEY_UPDATE . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * ���ÿ�ȯ���԰�����
     * @param string $openid    ���Ե� openid �б�
     * @param string $user      ���Ե�΢�ź��б�
     * @return boolean
     */
    public function setCardTestWhiteList($openid=array(),$user=array()) {
        $data = array();
        if (count($openid) > 0)
            $data['openid'] = $openid;
        if (count($user) > 0)
            $data['username'] = $user;
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_BASE_URL_PREFIX . self::CARD_TESTWHILELIST_SET . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg  = $json['errmsg'];
                return false;
            }
            return true;
        }
        return false;
    }

}
/**
 * PKCS7Encoder class
 *
 * �ṩ����PKCS7�㷨�ļӽ��ܽӿ�.
 */
class PKCS7Encoder
{
    public static $block_size = 32;

    /**
     * ����Ҫ���ܵ����Ľ�����䲹λ
     * @param $text ��Ҫ������䲹λ����������
     * @return ���������ַ���
     */
    function encode($text)
    {
        $block_size = PKCS7Encoder::$block_size;
        $text_length = strlen($text);
        //������Ҫ����λ��
        $amount_to_pad = PKCS7Encoder::$block_size - ($text_length % PKCS7Encoder::$block_size);
        if ($amount_to_pad == 0) {
            $amount_to_pad = PKCS7Encoder::block_size;
        }
        //��ò�λ���õ��ַ�
        $pad_chr = chr($amount_to_pad);
        $tmp = "";
        for ($index = 0; $index < $amount_to_pad; $index++) {
            $tmp .= $pad_chr;
        }
        return $text . $tmp;
    }

    /**
     * �Խ��ܺ�����Ľ��в�λɾ��
     * @param decrypted ���ܺ������
     * @return ɾ����䲹λ�������
     */
    function decode($text)
    {

        $pad = ord(substr($text, -1));
        if ($pad < 1 || $pad > PKCS7Encoder::$block_size) {
            $pad = 0;
        }
        return substr($text, 0, (strlen($text) - $pad));
    }

}

/**
 * Prpcrypt class
 *
 * �ṩ���պ����͸�����ƽ̨��Ϣ�ļӽ��ܽӿ�.
 */
class Prpcrypt
{
    public $key;

    function __construct($k) {
        $this->key = base64_decode($k . "=");
    }

    /**
     * �����ϰ汾php���캯���������� __construct() ����ǰ�ߣ����򱨴�
     */
    function Prpcrypt($k)
    {
        $this->key = base64_decode($k . "=");
    }

    /**
     * �����Ľ��м���
     * @param string $text ��Ҫ���ܵ�����
     * @return string ���ܺ������
     */
    public function encrypt($text, $appid)
    {

        try {
            //���16λ����ַ�������䵽����֮ǰ
            $random = $this->getRandomStr();//"aaaabbbbccccdddd";
            $text = $random . pack("N", strlen($text)) . $text . $appid;
            // �����ֽ���
            $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $iv = substr($this->key, 0, 16);
            //ʹ���Զ������䷽ʽ�����Ľ��в�λ���
            $pkc_encoder = new PKCS7Encoder;
            $text = $pkc_encoder->encode($text);
            mcrypt_generic_init($module, $this->key, $iv);
            //����
            $encrypted = mcrypt_generic($module, $text);
            mcrypt_generic_deinit($module);
            mcrypt_module_close($module);

            //			print(base64_encode($encrypted));
            //ʹ��BASE64�Լ��ܺ���ַ������б���
            return array(ErrorCode::$OK, base64_encode($encrypted));
        } catch (Exception $e) {
            //print $e;
            return array(ErrorCode::$EncryptAESError, null);
        }
    }

    /**
     * �����Ľ��н���
     * @param string $encrypted ��Ҫ���ܵ�����
     * @return string ���ܵõ�������
     */
    public function decrypt($encrypted, $appid)
    {

        try {
            //ʹ��BASE64����Ҫ���ܵ��ַ������н���
            $ciphertext_dec = base64_decode($encrypted);
            $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $iv = substr($this->key, 0, 16);
            mcrypt_generic_init($module, $this->key, $iv);
            //����
            $decrypted = mdecrypt_generic($module, $ciphertext_dec);
            mcrypt_generic_deinit($module);
            mcrypt_module_close($module);
        } catch (Exception $e) {
            return array(ErrorCode::$DecryptAESError, null);
        }


        try {
            //ȥ����λ�ַ�
            $pkc_encoder = new PKCS7Encoder;
            $result = $pkc_encoder->decode($decrypted);
            //ȥ��16λ����ַ���,�����ֽ����AppId
            if (strlen($result) < 16)
                return "";
            $content = substr($result, 16, strlen($result));
            $len_list = unpack("N", substr($content, 0, 4));
            $xml_len = $len_list[1];
            $xml_content = substr($content, 4, $xml_len);
            $from_appid = substr($content, $xml_len + 4);
            if (!$appid)
                $appid = $from_appid;
            //��������appid�ǿյģ�����Ϊ�Ƕ��ĺţ�ʹ����������ȡ������appid
        } catch (Exception $e) {
            //print $e;
            return array(ErrorCode::$IllegalBuffer, null);
        }
        if ($from_appid != $appid)
            return array(ErrorCode::$ValidateAppidError, null);
        //��ע���ϱ����У����⴫��appid�Ǵ�������
        return array(0, $xml_content, $from_appid); //����appid��Ϊ�˽��������ܻظ���Ϣ��ʱ��û��appid�Ķ��ĺŻ��޷��ظ�

    }


    /**
     * �������16λ�ַ���
     * @return string ���ɵ��ַ���
     */
    function getRandomStr()
    {

        $str = "";
        $str_pol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < 16; $i++) {
            $str .= $str_pol[mt_rand(0, $max)];
        }
        return $str;
    }

}

/**
 * error code
 * ���������ڲ�ʹ�ã������ڹٷ�API�ӿڵ�errCode��
 */
class ErrorCode
{
    public static $OK = 0;
    public static $ValidateSignatureError = 40001;
    public static $ParseXmlError = 40002;
    public static $ComputeSignatureError = 40003;
    public static $IllegalAesKey = 40004;
    public static $ValidateAppidError = 40005;
    public static $EncryptAESError = 40006;
    public static $DecryptAESError = 40007;
    public static $IllegalBuffer = 40008;
    public static $EncodeBase64Error = 40009;
    public static $DecodeBase64Error = 40010;
    public static $GenReturnXmlError = 40011;
    public static $errCode=array(
        '0' => '����ɹ�',
        '40001' => 'У��ǩ��ʧ��',
        '40002' => '����xmlʧ��',
        '40003' => '����ǩ��ʧ��',
        '40004' => '���Ϸ���AESKey',
        '40005' => 'У��AppIDʧ��',
        '40006' => 'AES����ʧ��',
        '40007' => 'AES����ʧ��',
        '40008' => '����ƽ̨���͵�xml���Ϸ�',
        '40009' => 'Base64����ʧ��',
        '40010' => 'Base64����ʧ��',
        '40011' => '�����ʺ����ɻذ�xmlʧ��'
    );
    public static function getErrText($err) {
        if (isset(self::$errCode[$err])) {
            return self::$errCode[$err];
        }else {
            return false;
        };
    }
}
