<?php

namespace app\web\model\pointer;

use xenice\theme\Theme;
use xenice\model\pointer\PagePointer;

class Page extends PagePointer
{
    public function __construct($mix)
    {
        parent::__construct($mix);
    }
    
    public function url()
	{
	    return get_permalink($this->id());
	}

	public function editUrl()
	{
	    return get_edit_post_link($this->id());
	}
}