<?php

namespace app\web\controller;

use xenice\theme\Controller;

class ArchiveController extends Controller
{
    public function index()
    {
    	if(is_day()) $this->title = get_the_time('Y-m-j');
		elseif(is_month()) $this->title = get_the_time('Y-m');
		elseif(is_year()) $this->title = get_the_time('Y');
		$this->render();
    }
}