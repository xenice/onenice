<?php

namespace app\web\model\pointer;

use xenice\theme\Theme;
use xenice\model\pointer\CategoryPointer;

class Category extends CategoryPointer
{
    public function __construct($mix)
    {
        parent::__construct($mix);
    }
    
    public function url()
    {
        return get_term_link($this->id(), Theme::get('taxonomy'));
    }
    
    /**
     * Root category ID
     */
    public function rid()
	{
		$id = $this->id();
		while ($id) {
			$cat = get_category($id);
			$id = $cat->category_parent; 
			$catParent = $cat->cat_ID;
		}
		return $catParent;
	}
}