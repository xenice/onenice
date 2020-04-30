var xenice = (function(){
    var x = {
    };
    return x;
})();

jQuery(function($){
    Gifffer();
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