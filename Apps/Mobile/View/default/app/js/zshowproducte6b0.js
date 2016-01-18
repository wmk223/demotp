// JavaScript Document
/*
	2015-9-25
	about showproduct pages
	by:sibu zxy
*/
 $(function(){
	'use strict';
	/*--==for the right slider bar (start)==--*/
	  var mySwiper = new Swiper('.swiper-container',{
		pagination: '.pagination',
		paginationClickable: true,
		slidesPerView: 'auto',
		mode: 'vertical'
	  });/*make the object of slider bar*/
	 var windowHeight=$(window).height(),/*get the window height*/
		swiperWrapper=$('.swiper-wrapper'),/*get the slider Object*/
		sliderLiHeight=$('.swiper-wrapper li').height(),/*get the slider li height*/
		sliderLiMax=$('.swiper-wrapper li').length-1,/*get the slider li length*/
		/*get the slider show in preview number*/
		showView=(windowHeight-$('.zshowp-header').height())/sliderLiHeight,
		showView=Math.floor(showView),/*get the preview in Int*/
		swiperHeight=$(swiperWrapper).height(),/*get the slider height*/
		nowMove=0,/*defind the slider loading move init*/
		nowFrist=0;/*defind now show first class tab index*/
	$('.swiper-wrapper li').each(function(index, element) {
		if($(element).hasClass('actived')){
			nowFrist=index;
			return true;
		}
	});/*find the top bar*/
	if(sliderLiMax>showView){
		if(nowFrist<sliderLiMax-showView+1){
			nowMove=nowFrist*sliderLiHeight;
			$(swiperWrapper).css({'-moz-transform':'translate3d(0px, '+(-nowMove)+'px, 0px)','-ms-transform':'translate3d(0px, '+(-nowMove)+'px, 0px)','-o-transform':'translate3d(0px, '+(-nowMove)+'px, 0px)','-webkit-transform':'translate3d(0px, '+(-nowMove)+'px, 0px)'});
		}else{
			nowMove=sliderLiHeight*(sliderLiMax-showView);
			$(swiperWrapper).css({'-moz-transform':'translate3d(0px, '+(-nowMove)+'px, 0px)','-ms-transform':'translate3d(0px, '+(-nowMove)+'px, 0px)','-o-transform':'translate3d(0px, '+(-nowMove)+'px, 0px)','-webkit-transform':'translate3d(0px, '+(-nowMove)+'px, 0px)'});
		}
			
	}
	/*--==for the right slider bar (start)==--*/
})