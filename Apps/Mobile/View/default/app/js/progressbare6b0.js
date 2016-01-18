$(function () {
    /// ============================================================================
    /// TODU: 更新状态函数；
    $(".progressbar").on("statusUpdate.SRCountdown", function (evt) {
        var status = evt.status;

        if (status == "disabled") {
            // $(this).addClass("not-start");
            $(this).children('.time-txt').css('z-index', '-1');
            $(this).children(".state").css('z-index', '99').text("即将开始");
            return;
        }

        if (status == "prepering") {
            //$(this).addClass("not-start");
            $(this).children('.time-txt').css('z-index', '-1');
            $(this).children(".state").css('z-index', '99').text("即将开始");
            return;
        }

        if (status == "complete") {
            //$(this).addClass("not-start");
            $(this).children('.time-txt').css('z-index', '-1');
            if ($(this).hasClass('nextround'))
                $(this).children(".state").css('z-index', '99').text("已经开始");
            else
                $(this).children(".state").css('z-index', '99').text("已结束");
            return;
        }

        if (status == "running") {
            $(this).removeClass("not-start");
            $(this).children('.time-txt').css('z-index', '1');
            $(this).children(".state").css('z-index', '-1');
            return;
        }
        /// ============================================================================
        /// TODU: 更新内容函数；
    }).on("contentUpdate.SRCountdown", function (evt) {
        var content = evt.content;
        var percent = evt.percent || 0;

        $(this).find(".value").html(content);
        if ($(this).hasClass('nextround')) {
            $(this).find(".percent").text(((100 * percent) | 0) + "%");
            $(this).find('.charts').css('width', +((100 * percent) | 0) + "%");
        }
        else {
            $(this).find(".percent").text(((100 * (1 - percent)) | 0) + "%");
            $(this).find('.charts').css('width', +((100 * (1 - percent)) | 0) + "%");
        }
    })
/// ============================================================================
/// TODU: 创建倒计时对象；
        .SRCountDown({
            /* 计时器配置 */
            //"updateOnStart": true,
            //"useRequestAPI": true,
            //"updateFPS"    : 100,

            /* 倒计时配置 */
            "timeOffset": 1000
            //"formatToDay"  : false,

            /* 事件 */
            //"onUpdateCallBack": null,
            //"onStartCallBack" : null,
            //"onStopCallBack"  : null,

            /* DOM 更新 */
            //"setStatusFn"  : null,
            //"setContentFn" : null,
            //"dataCountdown": "countdown",

            /* 格式化 */
            //"formatPattern": /\{\{\s*([^\}\s]+)\s*\}\}/g,
            //"formatString" : '{{H:2}}:{{M:2}}:{{S:2}}'
        });
    /// ============================================================================

    $base = new Array(18, 14, 8, 5, 4, 3, 4, 8, 10, 13, 14, 18, 23, 20, 17, 15, 14, 16, 19, 22, 24, 25, 26, 20);
    $hours = new Date().getHours();
    $int = parseInt($base[$hours].toString() + GetRandomNum(10, 99).toString());
    onlineInit($int);
    //秒杀人数改变
    setTimeout(seckill, 5000);


});


var screen_w = document.documentElement.clientWidth;
var _top = screen_w < 640 ? '2' : '4';
var _init_top = screen_w < 640 ? '20' : '40';
var outter = $('.seckill .outter');
var inner = $('.seckill .inner');
var init_num_str, init_num;
var a, b, c,t,k;
var $hundred_digits = $('.hundred-digits'), $ten_digits = $('.ten-digits'),$single_digits = $('.single-digits'),$thousand_digits = $('.thousand-digits');
var $hundred_digits_new = $hundred_digits.children('.inner'), $ten_digits_new = $ten_digits.children('.inner'), $single_digits_new = $single_digits.children('.inner'),$thousand_digits_new=$thousand_digits.children('.inner');
var $hundred_digits_old = $hundred_digits.children('.outter'), $ten_digits_old = $ten_digits.children('.outter'), $single_digits_old = $single_digits.children('.outter'),$thousand_digits_old = $thousand_digits.children('.outter');

function onlineInit($num) {
    init_num = $num;
   f_initnum(1);
	
}


function seckill() {
    var mathnum = GetRandomNum(-99, 99); //随机增加的数值
    init_num = init_num + mathnum;

    if (init_num < 39999 && init_num > 0) {
        f_initnum(2);

        $(outter).each(function (i, item) {
            var outter_value = $(this).text();
            var _inner = $(this).next('.inner');
            var inner_value = $(_inner).text();
            if (outter_value != inner_value) {
                $(_inner).animate({top: _top}, 1000);
                setTimeout(function () {
                    $(_inner).stop().css('top', _init_top + 'px');
                }, 1000);
                setTimeout(function () {
                    $(item).text(inner_value);
                }, 1000);
            }
        });
       // setCookie('seckillnum', init_num_str, 12);
    }
    setTimeout(seckill, 5000);
}


function setCookie(c_name, value, expirehours) {
    var exdate = new Date();
    exdate.setHours(exdate.getHours() + expirehours);
    document.cookie = c_name + "=" + escape(value) + ((expirehours == null) ? "" : ";expires=" + exdate.toGMTString());
}


function getCookie(name) {

    var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");

    if (arr = document.cookie.match(reg))

        return unescape(arr[2]);
    else
        return null;
}


function GetRandomNum(Min, Max) {
    var Range = Max - Min;
    var Rand = Math.random();
    return (Min + Math.round(Rand * Range));
}

function f_initnum(type){
 if (init_num <= 9)
        init_num_str = '000' + init_num.toString();
    else if (init_num <= 99)
        init_num_str = '00' + init_num.toString();
	else if(init_num <= 999)
		init_num_str = '0' + init_num.toString();
    else
        init_num_str = init_num.toString();
	t = parseInt(init_num_str.substr(0, 1)); //千位
    a = parseInt(init_num_str.substr(1, 1)); //百位
    b = parseInt(init_num_str.substr(2, 1)); //十位
    c = parseInt(init_num_str.substr(3, 1));//个位

    if(type==1)
    {

	    $thousand_digits_old.text(t);
        $hundred_digits_old.text(a);
        $ten_digits_old.text(b);
        $single_digits_old.text(c);
    }
    else
    {
     
	    $thousand_digits_new.text(t);
        $hundred_digits_new.text(a);
        $ten_digits_new.text(b);
        $single_digits_new.text(c);
    }

}