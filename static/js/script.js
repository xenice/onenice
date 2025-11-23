/**
 * Xenice
 *
 * @package YYThemes
 */

var xenice = (function(){
	var x = {
	};
	return x;
})();

jQuery(function($){
    
    // The bottom absorbs the bottom when the inner space is insufficient.
    setTimeout(function(){
        var screenHeight = jQuery(window).height();
        var divHeight = jQuery('.yy-site').height();
        if(divHeight+80 < screenHeight){
            jQuery('.yy-footer').attr('style', 'position:fixed;bottom: 0;left: 0;right: 0;');
            jQuery('.yy-footer').fadeIn();
        }
        else{
            jQuery('.yy-footer').attr('style', 'display:block;');
        }
    },100);
    
    // show sub-menu
    $(".navbar-nav > .menu-item").mouseenter(function(){
        $(this).children(".sub-menu").show();
    })
    
    $(".navbar-nav > .menu-item").mouseleave(function() {
        $(this).children(".sub-menu").hide();
    })
    
    $(".sub-item").mouseenter(function(){
        $(this).show();
    })
    $(".sub-menu").mouseleave(function() {
        $(this).hide();
    })
});



/* get a like */
jQuery(function($){
    if($('.post-like-a').length<1) return;
    $('.post-like-a').on('click', function(){
        var pid = $(this).attr('data-pid');
        $.post(
			admin_ajax + '?action=like',
			{
				pid: pid,
			},
			function (data) {
			    var data = JSON.parse(data)
			    if(data.key == 'success'){
                  $('.post-like-a').html(data.value);
                }
				else if(data.key == 'liked'){
				    alert(data.value);
				}
				else{
				    console.log(data);
				}
			}
		);
    })
});
