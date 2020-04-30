<?php

namespace app\web\controller;

use xenice\theme\Theme;
use xenice\theme\Controller;

class TagController extends Controller
{
    public function index()
    {
        $this->title = single_tag_title('', false) . ' - ' . get_bloginfo( 'name' );
        $this->keywords = single_tag_title( '', false );
        $this->description = tag_description();
        $this->tag = Theme::use('tag');
		$this->render();
    }
}