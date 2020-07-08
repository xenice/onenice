<?php

namespace app\web\controller;

use xenice\theme\Theme;
use xenice\theme\Controller;

class AuthorController extends Controller
{
    public function index()
    {
        global $wp_query;
        $this->author = Theme::new('user_pointer', $wp_query->get_queried_object_id());
        $this->title = _t('User articles') . ' - ' . $this->option->info['name'];
		$this->render();
    }
}