<?php

namespace app\web\controller;

use xenice\theme\Theme;
use xenice\theme\Controller;
use app\web\model\Category;
use app\web\model\Article;
use app\web\model\User;

class SingleController extends Controller
{
    public function index()
    {
        Theme::bind('footer', [$this, 'footer']);
        add_action( 'wp_enqueue_scripts', [$this, 'scripts']);
        //add_action( 'wp_print_scripts', [$this, 'footer']);
        $article = Article::instance();
        $article->setViews();
        $this->title = $article->title() . ' - ' . $this->option->info['name'];
        $this->description = $article->description();
        $this->keywords = $article->keywords();
	    $this->render();
    }
    
    public function scripts()
    {
        wp_enqueue_style('highlight-css', STATIC_URL . '/lib/highlight/styles/vs.css', [], '9.9.0');
        wp_enqueue_script('highlight-js', STATIC_URL . '/lib/highlight/highlight.pack.js', [], '9.9.0', true);
        wp_enqueue_script('line-numbers', STATIC_URL . '/lib/highlight/line-numbers.min.js', [], '1.0.0', true);
        
        wp_enqueue_style('share-css', STATIC_URL . '/lib/share/css/share.min.css', [], THEME_VER);
        wp_enqueue_script('share-js', STATIC_URL . '/lib/share/js/social-share.min.js', [], THEME_VER, true);
    }
    
    public function footer($footer)
    {
        $footer .= '<script>hljs.initHighlightingOnLoad();hljs.initLineNumbersOnLoad();</script>';
        return $footer;
    }
}