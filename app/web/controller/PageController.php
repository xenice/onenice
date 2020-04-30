<?php

namespace app\web\controller;

use xenice\theme\Controller;
use app\web\model\Page;

class PageController extends Controller
{
    public function index()
    {	
		$this->title = $this->page->title() . ' - ' . $this->option->info['name'];
	    $this->render(Page::template());
    }
}