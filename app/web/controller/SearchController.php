<?php

namespace app\web\controller;

use xenice\theme\Controller;

class SearchController extends Controller
{
    public function index()
    {
		$this->title = $this->article->s . ' - ' . $this->option->info['name'];
		$this->s = $this->article->s;
		$this->render();
    }
}