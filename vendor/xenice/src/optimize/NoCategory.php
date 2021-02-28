<?php
/**
 * @name        xenice no category
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-15
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\optimize;

class NoCategory
{
    public function __construct()
    {
        add_action( 'load-themes.php', [$this, 'no_category_base_refresh_rules']);
        add_action('created_category', [$this, 'no_category_base_refresh_rules']);
        add_action('edited_category', [$this, 'no_category_base_refresh_rules']);
        add_action('delete_category', [$this, 'no_category_base_refresh_rules']);
        
        // Remove category base
        add_action('init', [$this, 'no_category_base_permastruct']);
        // Add our custom category rewrite rules
        add_filter('category_rewrite_rules', [$this, 'no_category_base_rewrite_rules']);
        // Add 'category_redirect' query variable
        add_filter('query_vars', [$this, 'no_category_base_query_vars']);
        // Redirect if 'category_redirect' is set
        add_filter('request', [$this, 'no_category_base_request']);
    }
    
    public function no_category_base_refresh_rules() 
    {
        global $wp_rewrite;
        $wp_rewrite -> flush_rules();
    }
    
    public function no_category_base_permastruct()
    {
        global $wp_rewrite, $wp_version;
        if (version_compare($wp_version, '3.4', '<')) {
        // For pre-3.4 support
        $wp_rewrite -> extra_permastructs['category'][0] = '%category%';
        } else {
        $wp_rewrite -> extra_permastructs['category']['struct'] = '%category%';
        }
    }
    
    public function no_category_base_rewrite_rules($category_rewrite)
    {
        //var_dump($category_rewrite); // For Debugging
        $category_rewrite = array();
        $categories = get_categories(array('hide_empty' => false));
        foreach ($categories as $category) {
        $category_nicename = $category -> slug;
        if ($category -> parent == $category -> cat_ID)// recursive recursion
        $category -> parent = 0;
        elseif ($category -> parent != 0)
        $category_nicename = get_category_parents($category -> parent, false, '/', true) . $category_nicename;
        $category_rewrite['(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
        $category_rewrite['(' . $category_nicename . ')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
        $category_rewrite['(' . $category_nicename . ')/?$'] = 'index.php?category_name=$matches[1]';
        }
        // Redirect support from Old Category Base
        global $wp_rewrite;
        $old_category_base = get_option('category_base') ? get_option('category_base') : 'category';
        $old_category_base = trim($old_category_base, '/');
        $category_rewrite[$old_category_base . '/(.*)$'] = 'index.php?category_redirect=$matches[1]';
        //var_dump($category_rewrite); // For Debugging
        return $category_rewrite;
    }
    
    public function no_category_base_query_vars($public_query_vars)
    {
        $public_query_vars[] = 'category_redirect';
        return $public_query_vars;
    }
    
    public function no_category_base_request($query_vars)
    {
        //print_r($query_vars); // For Debugging
        if (isset($query_vars['category_redirect'])) {
        $catlink = trailingslashit(get_option('home')) . user_trailingslashit($query_vars['category_redirect'], 'category');
        status_header(301);
        header("Location: $catlink");
        exit();
        }
        return $query_vars;
    }
}