//var baseUrl = eval({cart:'http://local.kuaigou.sibu.cn/', 'mall':'http://local.kuaigou.sibu.cn/'});
var baseUrl = eval({cart:'/', 'mall':'/'});

function addCartq($uid, $gid, $num, $callBack, $attr) {
    if ($attr == undefined)
        var $attr = '';

    $.post("/flow/add-cart", {
        uid: $uid,
        gid: $gid,
        num: $num,
        attr: $attr,
        _csrf: $('[name="csrf-token"]').attr('content')
    }, function (result) {
        if (result.status != 0) {
            alert_mesg(result.message);
        } else {
            if ($callBack == undefined) {
                var $pop = $('.pop-bg');
                if ($pop.length == 0) {
                    $('body').append('<div class="pop-bg" style="display: block"><div class="pop-cart-conbox"><p class="title">添加购物车成功！！</p><div class="button-group"><a class="button1" href="javascript:void(0)">继续逛逛</a><a class="button2" href="'+ baseUrl.cart +'flow/cart">去购物车</a></div></div></div>');
                } else {
                    $pop.show();
                }
                //alert_mesg(result.message, 'success');
                $('.cart-l').html('<div class="cart-l-num"></div>');
            } else {
                $callBack();
            }
        }
    }, 'json');
}

$('body').on('click', '.pop-bg .button1', function () {
    $('body').find('.pop-bg').hide();
    if ($('.first-layer').length > 0) {
        $('.first-layer').css('height', 'auto');
    }
});

function alert_mesg(str, warning) {

    //var output = '<div class="alerter phone-pop" style="z-index:999;"><p>'+str+'</p></div>';
    var output = '<div class="pop-text-box-out"><div class="pop-text-box"><p>' + str + '</p></div></div>';
    /*if(warning == 'success')
     {
     var output = '<div class="alerter phone-pop2" style="z-index:999;"><p>'+str+'</p></div>';
     }*/
    $('body').find('.pop-text-box-out').remove();
    $('body').prepend(output);
    $('.pop-text-box-out').delay(1500).fadeOut(500, function () {
        $(this).remove();
    })
}

function alert_mesg2(str, warning) {
    var output = '<div class="alerter phone-pop"><p>' + str + '</p></div>';
    if (warning == 'success') {
        var output = '<div class="alerter phone-pop2"><p>' + str + '</p></div>';
    }
    $('body').find('.alerter').remove();
    $('body').prepend(output);
    $('.alerter').delay(1500).fadeOut(500, function () {
        location.href = 'http://kuaigou.sibu.cn';
    })
}

function share(obj, url, title, pic) {
    var sinaShareURL = "http://service.weibo.com/share/share.php?";
    var qqShareURL = "http://share.v.t.qq.com/index.php?c=share&a=index&";
    if(url == undefined) {
        var share_url = encodeURIComponent(window.location);
    }else{
        var share_url = encodeURIComponent(url);
    }
    if(title == undefined) {
        var title = $("title").text();
    }
    if(pic == undefined) {
        var pic = encodeURIComponent($('#wx_pic').find('.index-topconimg').attr('src'));
    }else{
        var pic = encodeURIComponent(pic);
    }
    var desc_s = '';
    var _URL;
    if (obj == "weibo") {
        _URL = sinaShareURL + "url=" + share_url + "&title=" + title + "&pic=" + pic;
    } else if (obj == "weiqq") {
        _URL = qqShareURL + "url=" + share_url + "&title=" + title + "&pic=" + pic;
    } else if (obj == "kongqq") {
        _URL = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?summary=' + title + '&url=' + share_url + '&pics=' + pic
    } else if (obj == "qq") {
        _URL = 'http://connect.qq.com/widget/shareqq/index.html?url=' + share_url + '&title=' + title + '&desc=' + desc_s + '&summary=&site=baidu';
    } else if (obj == "yixin") {
        _URL = 'http://s.jiathis.com/?webid=yixin&url=' + share_url + '&title=' + title + '&uid=1&su=1';
    } else if (obj == "renren") {
        _URL = 'http://share.renren.com/share/buttonshare.do?link=' + share_url + '&title=' + title;
    }
    window.location = _URL;
}

function setCookie(c_name, value, expirehours) {
    var exdate = new Date();
    exdate.setHours(exdate.getHours() + expirehours);
    //document.cookie = c_name + "=" + value + ";domain=sibu.cn;path=/;expires=" + exdate.toGMTString();
    document.cookie = c_name + "=" + value + ";path=/;expires=" + exdate.toGMTString();
}

function getCookie(name) {

    var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");

    if (arr = document.cookie.match(reg))

        return unescape(arr[2]);
    else
        return null;
}
