<?php

namespace app\web\model\part;

use xenice\theme\Theme;

trait Article
{
    use Model;
    use Paginate;
    
    public function breadcrumb()  
	{  
	    $category = Theme::use('category');
	    $str = '<a class="breadcrumb-item" href="'. home_url() .'">'._t('Home').'</a>'; 
	    if($cid = $this->cid()){
            $str .= $category->getBreadcrumb($cid);
	    }
        $str .= '<span class="breadcrumb-item active">' . $this->title() . '</span>';
		return $str;
	}
	
	public function previousLink($tag = '', $same_term = false)
    {
        $post = get_adjacent_post( $same_term, '', true, $this->taxonomy());
        if($post){
            $row = Theme::new('article_pointer', $post);
            return $tag . '<a href="' . $row->url() . '" title="' . $row->title() . '">' . $row->title() . '</a>';
        }
    }
    
    public function nextLink($tag = '', $same_term = false)
    {
        $post = get_adjacent_post( $same_term, '', false, $this->taxonomy());
        if($post){
            $row = Theme::new('article_pointer', $post);
            return $tag . '<a href="' . $row->url() . '" title="' . $row->title() . '">' . $row->title() . '</a>';
        }
    }
    
	public function setViews()
    {
        $id = $this->id();
        $count = $this->get('views');
        if($count == ''){
            $this->set('views', 0);
            
        }else{
            $count++;
            $this->set('views', $count);
        }
    }
    
    public function paginate($space = 5)
    {
        global $wp_rewrite, $paged;
        $home_root = parse_url(home_url());
        $home_root = ( isset($home_root['path']) ) ? $home_root['path'] : '';
        $home_root = preg_quote( trailingslashit( $home_root ), '|' );
        $request = remove_query_arg( 'paged' );
        $request = preg_replace('|^'. $home_root . '|', '', $request);
        $request = preg_replace('|^/+|', '', $request);
        $pos = strrpos($request, '?');
        if($pos !== false){
            $request = substr($request, 0, $pos);
        }
        $option = Theme::use('option');
        $pagination_base = '';
    	if ( $wp_rewrite->using_permalinks()){
    	    $pagination_base = $wp_rewrite->pagination_base;
    	    if($paged > 1){
        	   $pos = strrpos($request, $pagination_base);
        	   $request = substr($request, 0, $pos);
        	}
        	else{
        	    $request .= '/';
        	}
    	    $base_url = trailingslashit(trailingslashit($option->info['url']) . $request);
    	}
    	else{
    	    $base_url =rtrim(trailingslashit($option->info['url']) . $request, '//');
    	}
    	$this->paginateLinks($base_url, $pagination_base, $this->pages, $paged, $space);
    }
}