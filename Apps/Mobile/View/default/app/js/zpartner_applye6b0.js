/*
	2015-9-15
	about pay page
	by:sibu zxy
*/
$(function(){
	'use strict';
	/*--add tel number in"-"(start)--*/
	var zpplyinTel=$('.zpplyin-tel').val(),zpplyTelPTxt=$('.zpply-tel'),nowStr='',strStart,strLeng=3;

    nowStr = zpplyinTel.substr(0,3)+'-';
    nowStr += zpplyinTel.substr(3,4)+'-';
    nowStr += zpplyinTel.substr(7);
	$(zpplyTelPTxt).text(nowStr);
	/*--add tel number in"-"(end)--*/
	/*--== when click the zp-aggree-icon toggle class and change the input val (start)==--*/
	var nowaggreeVal=1,
		aggreeIcon=$('.zp-aggree-icon'),
		zpplyAggreein=$('.zpply-aggreein');
	$(aggreeIcon).click(function(){
		$(this).toggleClass('actived');
		if($(zpplyAggreein).val()=='0'){
			$(zpplyAggreein).val(1);
		}else{
			$(zpplyAggreein).val(0);
		}
	});
	/*--== when click the zp-aggree-icon toggle class and change the input val (end)==--*/
})