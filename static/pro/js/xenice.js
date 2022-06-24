var xenice = (function(){
    var x = {
		scrollTop:function(){
		    return document.body.scrollTop + document.documentElement.scrollTop;
		},
        // collapse menu
        collapse: function(toggle, left, right, shade, overflow){
            $(toggle).on('click',function(){
                $(left).animate({
                    left:'0px'
                });
                $(right).animate({
                    left: '65%'
                });
                $(overflow).css('overflow','hidden');
                $(shade).fadeIn();
            });
            $(shade).on('click',function(){
                $(left).animate({
                    left:'-65%'
                });
                $(right).animate({
                    left: '0px'
                });
                $(overflow).css('overflow','');
                $(shade).fadeOut();
            });
            
            $(window).resize(function(){
                if($(window).width()>=768){
                    $(left).css('left','');
                    $(right).css('left','');
                    $(overflow).css('overflow','');
                    $(shade).hide();
                }
            });
        }
    };

	
    return x;
})();


jQuery(function($){
    // mobile scroll
    var scrollTop = xenice.scrollTop();
    var scroll = function() {
        if($(window).width()<768){
            $(window).off('scroll');
            var pos = xenice.scrollTop();
            if(pos>scrollTop && pos>50){
                $('header').fadeOut();
            }
            else{
                $('header').fadeIn();
            }
            scrollTop = pos;
            setTimeout(function() {
                $(window).on('scroll', scroll);
                var pos = xenice.scrollTop();
                if(pos<=50){
                    $('header').fadeIn();
                }
            }, 400);
        }
    };
    $(window).on('scroll', scroll);

	// moblie menu slide
    xenice.collapse('.menu-toggle','.menu-collapse','body,.navbar','.shade','body');
    
    // show sub-menu
    $(".menu-item").mouseenter(function(){
        $(this).children(".sub-menu").show();
    })
    
    $(".menu-item").mouseleave(function() {
        $(this).children(".sub-menu").hide();
    })
	$(".sub-menu").mouseenter(function() {
        $(this).show();
    })
    $(".sub-menu").mouseleave(function() {
        $(this).hide();
    })
    
    // moblie search form
    
    $(".search-toggle").on('click',function(){
        var e = $('.search-form')
        var d = e.css('display');
        if(d === 'none'){
            e.fadeIn();
            $(".search-toggle").html('<i class="fa fa-times"></i>')
            $('.keywords').focus();
        }
        else{
            e.fadeOut();
            $(".search-toggle").html('<i class="fa fa-search"></i>')
            $('.keywords').blur();
        }
        
        
    });
    $(".menu-toggle").on('click',function(){
        $('.search-form').hide();
        $(".search-toggle").html('<i class="fa fa-search"></i>')
    })
    
    $(window).resize(function(){
        if($(window).width()<768){
            $('.sub-menu').show();

        }
        else{
            $('header').show();
        }
    });
    
    // rollbar
    $('.scroll-top').on('click',function(){
        $('body,html').animate({'scrollTop':0},500);
    });
    
    len = $(".post-tags a").length - 1;
    $(".post-tags a").each(function(i) {
        var arr = new Array( '27ea80','3366FF','ff5473','df27ea', '31ac76', 'ea4563', '31a6a0', '8e7daa', '4fad7b', 'f99f13', 'f85200', '666666');
        var random1 = Math.floor(Math.random() * 12) + 0;
        var num = Math.floor(Math.random() * 5 + 12);
        $(this).attr('style', 'background:#' + arr[random1] + '; opacity: 0.6;'+'');
        if ($(this).next().length > 0) {
            last = $(this).next().position().left
        }
    })
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

function check(){
    if($('.keywords').val() === ''){
        return false;
    }
    return true;
}