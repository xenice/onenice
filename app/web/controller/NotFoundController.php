<?php

namespace app\web\controller;

use xenice\theme\Controller;

class NotFoundController extends Controller
{
    public function index()
    {
        $this->title = '404 - ' . get_bloginfo( 'name' );
		$this->render();
    }
}