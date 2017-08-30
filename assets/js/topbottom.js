jQuery(function ($) {'use stricts',
    $(document).ready(function () {
            var contentWrap = $("#wrapper");

            $("#gototop").hide()  //隐藏go to top按钮
            $(function(){
                $(window).scroll(function(){
                    if($(this).scrollTop() > 20){  //当window的scrolltop距离大于1时，go to top按钮淡出，反之淡入
                        $("#gototop").fadeIn();
                    } else {
                        $("#gototop").fadeOut();
                    }
                    if($(this).scrollTop() > contentWrap.height()-50){
                        $("#gotobottom").fadeOut();
                    }else {
                        $("#gotobottom").fadeIn();
                    }
                });
            });

            $("#gototop").click(function(){
                $("html,body").animate({scrollTop:0},500);
            });
            $("#gotobottom").click(function () {
                $("html,body").animate({scrollTop:contentWrap.height()},800);
            })
    });


});