<?php

class YYThemes_Optimize
{
    public function __construct()
    {
        add_filter('yythemes_ext_optimize_fields', [$this, 'fields']);
        
        yy_ext_get('enable_classic_editor') && add_filter('use_block_editor_for_post', '__return_false');
        if(yy_ext_get('enable_classic_widget')){
            add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
            add_filter( 'use_widgets_block_editor', '__return_false' );
        }
        yy_ext_get('enable_avatar_acc') && add_filter('get_avatar_url', [$this,'getAvatarUrl']);
        
        
		yy_ext_get('disable_post_revision') && remove_action('post_updated','wp_save_post_revision' );
		yy_ext_get('disable_update_remind') && add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );
		
		if(yy_ext_get('remove_image_attribute')){
    		add_filter( 'post_thumbnail_html', [$this, 'removeImageAttribute'], 10 );
            add_filter( 'image_send_to_editor', [$this, 'removeImageAttribute'], 10 );
		}
		yy_ext_get('extend_class_editor_buttons') && add_action('after_wp_tiny_mce', [$this, 'tinyMceButtons']);
		
		yy_ext_get('disable_admin_bar') && add_filter('show_admin_bar', '__return_false');
    }
    
    public function fields($fields)
    {
        $fields = array_merge($fields, [
            [
                'id'   => 'enable_classic_editor',
                'type'  => 'checkbox',
                'value' => true,
                'label' => esc_html__('Enable', 'onenice'),
                'name'  => esc_html__('Enable classic editor', 'onenice')
            ],
            [
                'id'   => 'enable_classic_widget',
                'type'  => 'checkbox',
                'value' => true,
                'label' => esc_html__('Enable', 'onenice'),
                'name'  => esc_html__('Enable classic widget', 'onenice')
            ],
            [
                'id'   => 'enable_avatar_acc',
                'type'  => 'checkbox',
                'value' => false,
                'label' => esc_html__('Enable', 'onenice'),
                'name'  => esc_html__('Enable gravatar acceleration', 'onenice')
            ],
            [
                'id'   => 'disable_post_revision',
                'type'  => 'checkbox',
                'value' => true,
                'label' => esc_html__('Enable', 'onenice'),
                'name'  => esc_html__('Disable revision', 'onenice')
            ],
            [
                'id'   => 'disable_update_remind',
                'type'  => 'checkbox',
                'value' => false,
                'label' => esc_html__('Enable', 'onenice'),
                'name'  => esc_html__('Disable update reminders', 'onenice')
            ],
            [
                'id'   => 'remove_image_attribute',
                'type'  => 'checkbox',
                'value' => true,
                'label' => esc_html__('Enable', 'onenice'),
                'name'  => esc_html__('Remove image attributes while editing posts', 'onenice')
            ],
            [
                'id'   => 'extend_class_editor_buttons',
                'type'  => 'checkbox',
                'value' => false,
                'label' => esc_html__('Enable', 'onenice'),
                'name'  => esc_html__('Extend the classic editor buttons', 'onenice')
            ],
            [
                'id'   => 'disable_admin_bar',
                'type'  => 'checkbox',
                'value' => false,
                'label' => esc_html__('Enable', 'onenice'),
                'name'  => esc_html__('Disable the front admin bar', 'onenice')
            ],
        ]);
        return $fields;
    }
    
    public function getAvatarUrl($url){
        $pos = strpos($url,'/avatar/');
        if($pos>0){
            $new_url = 'https://cravatar.cn';
            $slug = substr($url, $pos);
            return $new_url . $slug;
        }
        return $url;
    }
    
    public function removeImageAttribute( $html ) {
    	$html = preg_replace('/<img.+(src="?[^"]+"?)[^\/]+\/>/i',"<img \${1} />",$html);
    	return $html;
    }
    
    public function tinyMceButtons(){
        ?>
        <script>
            QTags.addButton( 'h4', 'h4', "<h4>", "</h4>");
            QTags.addButton( 'h5', 'h5', "<h5>", "</h5>");
            QTags.addButton( 'strong', 'strong', "<strong>", "</strong>");
            QTags.addButton( 'pre', 'pre', "<pre>", "</pre>");
            QTags.addButton( 'pre/code', 'pre/code', "<pre><code>", "</code></pre>");
        </script>
        
        <script>

            jQuery(document).ready(function($) {

                // 创建自定义按钮
                var customButton = '<input type="button" id="add_ul_li" class="ed_button button button-small" value="ul/li">';

                // 将按钮添加到工具栏
                $(customButton).appendTo('#ed_toolbar');

                // 按钮点击事件
                $(document).on('click', '#add_ul_li', function(e) {
                    e.preventDefault();
                    
                    // 获取编辑器对象
                    var editor = document.getElementById('content');

                    // 获取选定的文本
                    var selectedText = '';
                    if (window.getSelection) {
                        selectedText = window.getSelection().toString();
                    } else if (document.selection && document.selection.type != "Control") {
                        selectedText = document.selection.createRange().text;
                    }
    
                    // 按行分割文本
                    var lines = selectedText.split('\n');
    
                    // 添加li标签到每一行
                    var formattedText = '';
                    for (var i = 0; i < lines.length; i++) {
                        formattedText += '<li>' + lines[i] + '</li>\n';
                    }
    
                    // 替换选中的文本
                    if (document.execCommand) {
                        document.execCommand('insertText', false, '<ul>\n' + formattedText + '</ul>');
                    } else {
                        editor.setRangeText('<ul>\n' + formattedText + '</ul>');
                    }
                });
            });
        </script>
        <?php
    }
    
}