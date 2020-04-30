<?php

namespace app\web\controller;

use xenice\theme\Controller;
use app\web\model\Article;
//use app\web\model\Tag;

class HomeController extends Controller
{
    public function index()
    {
        
        $this->title = $this->option->info['name'] . ' - ' . $this->option->info['description'];
        $this->description = take('description');
        $this->keywords = take('keywords');	
		$this->render();
    }
}