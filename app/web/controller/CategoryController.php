<?php

namespace app\web\controller;

use xenice\theme\Controller;

class CategoryController extends Controller
{

    public function index($view = 'index')
    {
        $this->title = single_cat_title('', false) . ' - ' . get_bloginfo( 'name' );
        $this->keywords = single_cat_title( '', false );
        $this->description = category_description();
		$this->render($view);
    }
	
}