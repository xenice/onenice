<?php

namespace app\web\model;

//use censky\cache\Cache;
use xenice\model\TagModel;

class Tag extends TagModel
{
    public function breadcrumb()  
	{  
		$str = '<a class="breadcrumb-item" href="'. home_url() .'">'._t('Home').'</a>'; 
		$str .= '<span class="breadcrumb-item active">' . $this->name() . '</span>';
		return $str;
	}
}