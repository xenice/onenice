<?php
/**
 * @name        xenice user optimize
 * @description Admin optimize
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-02
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\optimize;

use xenice\theme\Theme;

class UserOptimize
{
    public $id;
    public $commentCount;
    
    public function __construct()
    {
        $this->id = get_current_user_id();
        $this->commentCount = $this->commentCount();
        // except for administrators
        if(!current_user_can( 'manage_options' ) ) {
            add_action('add_admin_bar_menus',[$this, 'barCommentCount']);
            add_filter('views_edit-post', [$this,'showArticlesCount']);
            add_filter( 'months_dropdown_results', '__return_empty_array' );
            //add_filter( 'disable_categories_dropdown', '__return_empty_array' );
            add_filter( 'parse_query', [$this,'showArticlesTable']);
            add_filter('views_edit-comments', [$this,'showCommentsCount']);
            add_filter( 'comments_list_table_query_args', [$this,'showCommentsTable']);
            add_action('admin_menu',[$this, 'filterMenu']);
        }
        
    }
    public function barCommentCount()
    {
        remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu',60);
        add_action( 'admin_bar_menu', function($wp_admin_bar){
            if ( ! current_user_can( 'edit_posts' ) ) {
        		return;
        	}
        
        	$awaiting_mod  = $this->commentCount;
        	$awaiting_mod  = $awaiting_mod->moderated;
        	$awaiting_text = sprintf(
        		/* translators: %s: Number of comments. */
        		_n( '%s Comment in moderation', '%s Comments in moderation', $awaiting_mod ),
        		number_format_i18n( $awaiting_mod )
        	);
        
        	$icon   = '<span class="ab-icon"></span>';
        	$title  = '<span class="ab-label awaiting-mod pending-count count-' . $awaiting_mod . '" aria-hidden="true">' . number_format_i18n( $awaiting_mod ) . '</span>';
        	$title .= '<span class="screen-reader-text comments-in-moderation-text">' . $awaiting_text . '</span>';
        
        	$wp_admin_bar->add_menu(
        		array(
        			'id'    => 'comments',
        			'title' => $icon . $title,
        			'href'  => admin_url( 'edit-comments.php' ),
        		)
        	);
            
        }, 60 );
        
    }
    
    public function showArticlesCount($views)
    {
        $views = [];
        $items = [
            ['all',_t('All'),'edit.php?post_type=post'],
            ['publish',_t('Publish'),'edit.php?post_status=publish&post_type=post'],
            ['draft',_t('Draft'),'edit.php?post_status=draft&post_type=post'],
            ['pending',_t('Pending'),'edit.php?post_status=pending&post_type=post'],
            ['trash',_t('trash'),'edit.php?post_status=trash&post_type=post'],
        ];
        foreach($items as $item){
            if((empty($_REQUEST['post_status'])&&$item[0]=='all') || $_REQUEST['post_status'] == $item[0]){
                $views[$item[0]] ='<a class="current" aria-current="page" href="'.$item[2].'">'.$item[1].'<span class="count">'._t('(').$this->postCount($item[0])._t(')'). '</span></a>';
            }
            else{
                $views[$item[0]] ='<a href="'.$item[2].'">'.$item[1].'<span class="count">'._t('(').$this->postCount($item[0])._t(')').'</span></a>';
            }
        }
        return $views;
    }
    
    public function showArticlesTable($wp_query)
    {
        if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/edit.php' ) !== false ) {
            $wp_query->set( 'author', $this->id );
        }
    }
    
    public function showCommentsCount($views)
    {
        $views = [];
        $items = [
            ['all',_t('All'),'edit-comments.php?comment_status=mine&user_id=' . $this->id]
        ];
        foreach($items as $item){
            $views[$item[0]] ='<a class="current" aria-current="page" href="'.$item[2].'">'.$item[1].'<span class="count">（'.$this->commentCount.'）</span></a>';
        }
        return $views;
    }
    
    public function showCommentsTable($args)
    {
        $args['user_id'] = $this->id;
        return $args;
    }
    
    public function filterMenu()
    {
        global $menu;
        $restricted = array(__('Dashboard'), __('Tools'));
        end ($menu);
        while (prev($menu)){
            $value = explode('　',$menu[key($menu)][0]);
            if(!isset($value[0])){
                continue;
            }
            if(in_array($value[0], $restricted)){unset($menu[key($menu)]);}
            elseif(strpos($value[0], __('Comments')) === 0)
            {
                $menu[key($menu)][0] = preg_replace('/\d+/', $this->commentCount, $menu[key($menu)][0]);
            }
        }
    }
    
    private function postCount( $poststatus )
    {
        global $wpdb;
        if( $poststatus == 'all' ){
            $count = $wpdb->get_var( "SELECT COUNT(1) FROM $wpdb->posts WHERE post_author={$this->id} AND post_type='post' AND post_status<>'auto-draft'" );
        }else{
            $count = $wpdb->get_var( "SELECT COUNT(1) FROM $wpdb->posts WHERE post_author={$this->id} AND post_type='post' AND post_status='{$poststatus}'" );
        }
        return (int)$count;
    }
    
    private function commentCount()
    {
        global $wpdb;
    	$count = $wpdb->get_var( "SELECT COUNT(1) FROM $wpdb->comments WHERE user_id={$this->id}" );
      	return (int)$count;
    }
}