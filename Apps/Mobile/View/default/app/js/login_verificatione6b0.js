/*
	2015-9-6
	about login code timer
	by:sibu zxy
*/
$(function(){
	'use strict';
	/*--==when fill the phone check the number if right (start)==--*/
	var zloginBtnCode=$('.veri-codebtn'),znowTel,zflag=0;
	var zloginPhoneNum=$('.veri-tel');
	var telReg=/^1(3|4|5|7|8)\d{9}$/; 
	$(zloginPhoneNum).keyup(function() {
		znowTel= $.trim($(this).val());
		if (znowTel.match(telReg)) { 
			zflag=1;
		}else{
			zflag=0;
		}
	});/*验证手机格式*/
	/*--==define the function setTimeOut click the send code (start)==--*/
	var wait=60;  
	function ztimeFn(elem) {  
			if (wait == 0) { 
				$(elem).removeClass('actived');         
				$(elem).text('获取');  
				wait = 60;  
			} else {  
				$(elem).addClass('actived');           
				$(elem).text("重新获取(" + wait + ")");  
				wait--;  
				setTimeout(function() {  
					ztimeFn(elem)  
				},  
				1000)  
			}  
		};
	/*--==define the function setTimeOut click the send code (start)==--*/
	/*--==click the "获取验证码" use the ztimeFn function (start)==--*/
	$(zloginBtnCode).click(function(){
		if(zflag&&!$(this).hasClass('actived')){
            var self = this;
            var $type = $(this).attr('send-type');
            if($type == undefined)
                $type = 'weblogin';
            $(self).text("正在获取..");
			$(zloginBtnCode).addClass('actived');
            $.get("/user/send-code", {mobile: znowTel, type: $type}, function (result) {
                if (result.success == false) {
                    alert_mesg(result.msg);
                    $(self).removeClass('actived');
                    $(self).text("重新获取");
                } else {
                    ztimeFn(self)
                }
            }, 'json');

		} else{
            alert_mesg('请输入正确的手机号码');
        };
	});
	/*--==click the "获取验证码" use the ztimeFn function (end)==--*/

    $('.veri-btn-submit').click(function () {
        var mobile = $('.veritems-inp');
        var code = $('.veritems-inp-code').val();
        if (code.length == 6) {
            $.post("/user/check-code", {
                mobile: mobile.val(),
                code: code,
                _csrf: $('[name="csrf-token"]').attr('content')
            }, function (result) {
                if (result.success == false) {
                    alert_mesg(result.msg);return;
                } else {
                    //登陆成功
                    window.location = window.location;
                }
            }, 'json');
        }else{
            alert_mesg('请输入正确的验证码');return;
        }
    });

    $('.login-by-pwd').click(function() {
        var mobile = $('.login-info-phone').val();
        var pwd = $('.login-info-psd').val();

        if(mobile == '' || pwd == '')
        {
            alert_mesg('手机号或者密码不能为空');return;
        }
        if(pwd.length < 6)
        {
            alert_mesg('请输入不少于6为的密码');return;
        }
        $.post('/user/check-login', {
            mobile: mobile,
            pwd: pwd,
            _csrf: $('[name="csrf-token"]').attr('content')
        }, function (result) {
            if (result.success == false) {
                alert_mesg(result.msg);return;
            } else {
                //登陆成功
                window.location = window.location;
            }
        }, 'json');
    })



})