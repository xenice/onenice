<?php

class YYThemes_Sticky_Posts
{
    public function __construct(){
        add_filter('yythemes_ext_more_fields', [$this, 'fields']);
        yy_ext_get('enable_sticky_posts') && add_action('yythemes_before_recent_posts', [$this, 'template']);
    }
    
    public function fields($fields)
    {
        $fields[] = [
            'id'   => 'enable_sticky_posts',
            'name'  => esc_html__('Sticky posts', 'onenice'),
            'type'  => 'checkbox',
            'value' => false,
            'label'  => esc_html__('Add a sticky posts to the homepage', 'onenice')
        ];
        return $fields;
    }
    
    public function template(){
        include(__DIR__ . '/templates/sticky-posts.php');
    }
}
