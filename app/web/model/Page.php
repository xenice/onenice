<?php

namespace app\web\model;

use xenice\model\PageModel;

class Page extends PageModel
{
	public function template()
	{
		return get_post_meta($this->id(),'_wp_page_template',true)?:'default';
	}
	
	public function breadcrumb()  
	{  
		$str = '<a class="breadcrumb-item" href="'. home_url() .'">'._t('Home').'</a>'; 
		$str .= '<a class="breadcrumb-item" href="'. $this->url() .'">'.$this->title().'</a>';
		return $str;
	}
}