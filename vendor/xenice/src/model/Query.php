<?php
/**
 * @name        Xenice Query Model
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2020-07-12
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model;

use xenice\theme\Theme;
use xenice\cache\Cache;

class Query
{
    public $results;
    public $total;    // all records
    public $count;    // per page num
    public $page;     // current page
    public $pages;    // all pages
    public $index;    // current pointer index
    public $maxIndex; // max pointer index
    
    public function __construct($sql)
    {
        $key = 'query_' . md5($sql);
        $this->results = Cache::get($key);
        if(!$this->results){
            global $wpdb;
            $this->results = $wpdb->get_results($sql);
            Cache::set($key, $this->results, 24*3600);
        }
        $this->total = is_array($this->results)?count($this->results):0;
        $this->count = get_option('posts_per_page');
        $this->pages = ceil($this->total/$this->count);
        $this->page = get_query_var('paged')?:1;
        $this->index = ($this->page - 1) * $this->count;
        $this->maxIndex = $this->index + $this->count - 1;
    }
    
    public function has()
    {
        return $this->index<=$this->maxIndex && isset($this->results[$this->index]);
    }
    
    public function next()
    {
        if($this->index<=$this->maxIndex && isset($this->results[$this->index])){
            $id = $this->results[$this->index]->ID;
            $this->index ++;
            return $id;
        }
    }
}