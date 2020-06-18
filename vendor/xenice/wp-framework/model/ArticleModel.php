<?php
/**
 * @name        Xenice Article Model
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-13
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model;

use xenice\theme\Theme;

class ArticleModel extends Model
{
    public $query;
    public $pages;
    public $type;
    
    public function __construct()
    {
        $this->type = Theme::get('type');
        switch($this->type){
            case 'single':
                global $post;
                $this->pointer = Theme::new('article_pointer', $post);
                break;
            case 'category':
                global $cat;
                $this->defaults['cat'] = $cat;
                break;
            case 'tag':
                $term = get_term_by('name',single_tag_title('', false),'post_tag');
                $this->defaults['tag'] = $term->slug;
                break;
            case 'tax':
                $this->defaults['tax_query'] =[
                    [
                        'taxonomy' => Theme::get('taxonomy'),
                        'terms' => Theme::get('cid'),
                    ]
                ];
                break;
            case 'search':
                global $s;
                $this->s = $s;
                $this->defaults['s'] = $s;
                break;
        }
    }
    
    public function query($args = '')
    {
        $defaults = [
            'ignore_sticky_posts' => 1,
        ];
        $args = wp_parse_args($args, $defaults);
        $this->query = new \WP_Query( $args );
    }
    
    public function has()
    {
        if($this->query){
            $this->query->have_posts();
        }
    }
    
    
    public function pointer($args = '')
    {
        if(!$this->query){
            // The number of displays per page defaults to 10
            $defaults = [
                'paged' => 1,
                'posts_per_page' => 8,
                'no_found_rows' => true
            ];
            $args = wp_parse_args($args, $defaults);
            $this->query($args);
        }
        return $this->createPointer();
    }
    
    public function first($args = '')
    {
        if(!$this->query){
            $this->defaults['paged'] = get_query_var('paged')?:1;
            $args = wp_parse_args($args, $this->defaults);
            $this->query($args); 
            $this->pages = $this->query->max_num_pages;
        }
        return $this->createPointer();
    }
    
    private function createPointer()
    {
        $query = $this->query;
        if($query->have_posts() && $post = $query->next_post()){
            return Theme::new('article_pointer', $post);
        }
        else{
             $this->query = null;
        }
    }
}