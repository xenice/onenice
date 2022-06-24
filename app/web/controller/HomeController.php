<?php

namespace app\web\controller;

use xenice\theme\Controller;

class HomeController extends Controller
{
    public function index($view = 'index')
    {
        
        $this->title = $this->option->info['name'] . ' - ' . $this->option->info['description'];
        $this->description = take('description');
        $this->keywords = take('keywords');	
		$this->render($view);
    }
}