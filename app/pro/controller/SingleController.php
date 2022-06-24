<?php

namespace app\pro\controller;

use xenice\theme\Theme;

class SingleController extends \app\web\controller\SingleController
{
    public function index($view = 'index')
    {
        $this->addScripts();
        parent::index($view);
    }
    
    public function scripts()
    {
        parent::scripts();
        
        $cdn = take('enable_cdn');
        $cdn_url = take('cdn_url');
        
        if(take('enable_photoswipe')){
            if($cdn){
                wp_enqueue_style('photoswipe-css', $cdn_url . '/photoswipe/4.1.0/photoswipe.min.css', [], '4.1.0');
                wp_enqueue_style('photoswipe-css-skin', $cdn_url . '/photoswipe/4.1.0/default-skin/default-skin.min.css', [], '4.1.0');
                wp_enqueue_script('photoswipe-js', $cdn_url . '/photoswipe/4.1.0/photoswipe.min.js', [], '4.1.0', true);
                wp_enqueue_script('photoswipe-js-ui', $cdn_url . '/photoswipe/4.1.0/photoswipe-ui-default.min.js', [], '4.1.0', true);
            }
            else{
                wp_enqueue_style('photoswipe-css', STATIC_URL_EX . '/lib/photoswipe/css/photoswipe.css', [], '4.1.0');
                wp_enqueue_style('photoswipe-css-skin', STATIC_URL_EX . '/lib/photoswipe/css/default-skin/default-skin.css', [], '4.1.0');
                wp_enqueue_script('photoswipe-js', STATIC_URL_EX . '/lib/photoswipe/js/photoswipe.min.js', [], '4.1.0', true);
                wp_enqueue_script('photoswipe-js-ui', STATIC_URL_EX . '/lib/photoswipe/js/photoswipe-ui-default.min.js', [], '4.1.0', true);
            }
            wp_enqueue_script('photoswipe-init', STATIC_URL_EX . '/lib/photoswipe/init.js', [], '4.1.0', true);
        }

        
    }
    
    private function addScripts()
    {
        if(take('enable_photoswipe')){
        Theme::use('template')->js .=<<<js
jQuery(function($){
	var imgdefereds=[];
	$('.gallery img').each(function(){
		var dfd=$.Deferred();
		$(this).bind('load',function(){
			dfd.resolve();
		}).bind('error',function(){
			// dfd.resolve();
		});
		if(this.complete){
			setTimeout(function(){
				dfd.resolve();
			},1000);
		}
		else{
			imgdefereds.push(dfd);
		}
	});
	$.when.apply(null,imgdefereds).done(function(){
		$('.gallery img').each(function(i, val){
    		var img = new Image();
            img.src = this.src;
            let obj = {}
            // 如果图片被缓存，则直接返回缓存数据
            if (img.complete) {
                obj.width = img.width;
                obj.height = img.height;
            } else {
                img.onload = function () {
                    obj.width = img.width;
                    obj.height = img.height;
                }
            }
			var str = '';
			str += '<figure><a href="'+this.src+'" data-size="'+obj.width+'x'+obj.height+'">';
			str += '<img src="'+this.src+'" alt="'+this.alt+'" title="'+this.title+'" />';
			str +='</a></figure>';
			$(this).replaceWith(str);
		});
		initPhotoSwipeFromDOM('.gallery');
	});
});
js;
        }
        
        if(take('enable_like')){
        Theme::use('template')->js .=<<<js
jQuery(function($){
    $('.post-like-a').on('click', function(){
        var pid = $(this).attr('data-pid');
        var nonce = $(this).attr('data-nonce');
        $.post(
			xenice.action + 'like',
			{
			    like_nonce: nonce,
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
js;
        }


    }
}