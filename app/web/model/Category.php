<?php

namespace app\web\model;

use xenice\theme\Theme;
use xenice\model\CategoryModel;

class Category extends CategoryModel
{
    public function __construct()
    {
        parent::__construct();
    }
    
	public function breadcrumb()  
	{  
		$str = '<a class="breadcrumb-item" href="'. home_url() .'">'._t('Home').'</a>'; 
        $str .= $this->getBreadcrumb( $this->id());  
		return $str;
	}
	
    function getBreadcrumb($id)
    {
        $str = '';
        $p = Theme::new('category_pointer', $id);
        $pid = $p->pid();
        if($pid){
            $str .= $this->getBreadcrumb($pid);
        }
        $str .= '<a class="breadcrumb-item" href="'. $p->url() .'">'.$p->name().'</a>';
        return $str;
    }
}