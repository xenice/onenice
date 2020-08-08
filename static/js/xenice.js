var xenice = (function(){
    var x = {
    };
    return x;
})();

jQuery(function($){
    Gifffer();
    // show sub-menu
    if($(window).width()<768){
        $(".menu-item-has-children").click(function(){
            if($(window).width()<768){
                $(this).children(".sub-menu").toggle();
            }
        })
    }
    else{
        $(".menu-item-has-children").mouseenter(function(){
            $(this).children(".sub-menu").show();
        })
        $(".menu-item-has-children").mouseleave(function() {
            $(this).children(".sub-menu").hide();
        })
        $(".sub-menu").mouseleave(function() {
            $(this).hide();
        })
    }
    /*
    $(window).resize(function(){
        if($(window).width()<768){
            $('.sub-menu').show();

        }
    });*/
    // rollbar
    $('.scroll-top').on('click',function(){
        $('body,html').animate({'scrollTop':0},500);
    });

});

function _t(key){
    return xenice.lang[key];
}

function is_check_name(str)
{    
	return /^[\w]{3,16}$/.test(str) ;
}

function is_check_mail(str)
{
	return /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/.test(str);
}

function is_check_url(str)
{
    return /^((http|https)\:\/\/)([a-z0-9-]{1,}.)?[a-z0-9-]{2,}.([a-z0-9-]{1,}.)?[a-z0-9]{2,}$/.test(str);
}