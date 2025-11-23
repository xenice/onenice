<?php

class YYThemes_Photoswipe
{
    public function __construct(){
        add_filter('yythemes_ext_more_fields', [$this, 'fields']);
        
        if(yy_ext_get('enable_photoswipe')){
            add_action('wp_enqueue_scripts', [$this, 'load_scripts'], 20);
            add_filter('wp_footer', [$this, 'wp_footer'], 99);
        }
    }
    
    public function fields($fields)
    {
        $fields[] = [
            'id'   => 'enable_photoswipe',
            'name'  => esc_html__('PhotoSwipe', 'onenice'),
            'type'  => 'checkbox',
            'value' => false,
            'label'  => esc_html__('The slideshow is displayed when you click on post images', 'onenice')
        ];
        return $fields;
    }
    
    /**
     * Load script and style
     */
    public function load_scripts() {
    	if(is_single()){
            wp_enqueue_style('photoswipe', THEME_URL . '/ext/templates/photoswipe/css/photoswipe.css', [], '4.1.1');
            wp_enqueue_style('photoswipe-skin', THEME_URL . '/ext/templates/photoswipe/css/default-skin/default-skin.css', [], '4.1.0');
            wp_enqueue_script('photoswipe', THEME_URL . '/ext/templates/photoswipe/js/photoswipe.min.js', [], '4.1.0', true);
            wp_enqueue_script('photoswipe-ui', THEME_URL . '/ext/templates/photoswipe/js/photoswipe-ui-default.min.js', [], '4.1.0', true);
            wp_enqueue_script('photoswipe-init', THEME_URL . '/ext/templates/photoswipe/init.js', ['photoswipe','photoswipe-ui'], '4.1.0', true);
    	}
    }
    
    public function wp_footer() {
        if(is_single()){
            //ob_start();
            include(__DIR__ . '/templates/photoswipe/template.php');
            //$content .= ob_get_clean();
            ?>
            <script>
                /* photoswipe */
                jQuery(function($){
                    if($('.gallery img').length<1) return;
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
                            var that = this;
                            if (img.complete) {
                                obj.width = img.width;
                                obj.height = img.height;
                                if(obj.width<200) return;
                                var str = '';
                    			str += '<figure><a href="'+this.src+'" data-size="'+obj.width+'x'+obj.height+'">';
                    			str += '<img src="'+this.src+'" alt="'+this.alt+'" title="'+this.title+'" />';
                    			str +='</a></figure>';
                    			$(this).replaceWith(str);
                            } else {
                                img.onload = function () {
                                    obj.width = img.width;
                                    obj.height = img.height;
                                    var str = '';
                        			str += '<figure><a href="'+that.src+'" data-size="'+obj.width+'x'+obj.height+'">';
                        			str += '<img src="'+that.src+'" alt="'+that.alt+'" title="'+that.title+'" />';
                        			str +='</a></figure>';
                        			$(that).replaceWith(str);
                                    
                                }
                            }
                			
                		});
                		initPhotoSwipeFromDOM('.gallery');
                	});
                });
            </script>
            <?php
        }

    }
}
