<?php

namespace app\web\controller;

use xenice\theme\Theme;
use xenice\theme\Controller;

class PageController extends Controller
{
    public function index()
    {	
		$this->title = $this->page->title() . ' - ' . $this->option->info['name'];
	    $this->render(Theme::use('page')->template());
    }
}