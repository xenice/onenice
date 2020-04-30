<?php

namespace app\web\model;

use xenice\model\PageModel;

class Page extends PageModel
{
	protected function template()
	{
		return get_post_meta($this->id(),'_wp_page_template',true)?:'default';
	}
}