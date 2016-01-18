    /*轮播图  start*/
    var elem = document.getElementById('slider'),
            oSwipe = $("#slider");
            var len=$(".ul_swipe li").length;
    window.mySwipe = Swipe(elem, {
        startSlide: 0,
        auto: 3000,
        continuous: true,
        disableScroll: false,
        callback: function(index, element) {
            $(".ul_swipe li").removeClass("opcity100").eq(index).addClass("opcity100");
             var pre;
             pre=index--;
             //console.log(index+"--"+pre);
             $(".side-text ul li:eq(" + index + ")").stop().fadeOut(0);
             $(".side-text ul li:eq(" + pre + ")").stop().fadeIn(0);
        },
        transitionEnd: function(index, element) {}
    });
    mySwipe.stop = function(){
        delay = options.auto > 0 ? options.auto : 0;
        clearTimeout(interval);
    }