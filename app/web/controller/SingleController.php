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
        if(take('enable_article_seo') && $title = $article->get('title'))
	       $this->title = $title;
	    else
            $this->title = $article->title() . ' - ' . $this->option->info['name'];
        $this->description = $article->description();
        $this->keywords = $article->keywords();
	    $this->render();
    }
    
    public function scripts()
    {
        $cdn = take('enable_cdn');
        
        if(take('enable_highlight')){
            if($cdn){
                wp_enqueue_style('highlight-css', 'https://cdn.staticfile.org/highlight.js/10.1.2/styles/vs.min.css', [], '10.1.2');
                wp_enqueue_script('highlight-js', 'https://cdn.staticfile.org/highlight.js/10.1.2/highlight.min.js', [], '10.1.2', true);
                wp_enqueue_script('line-numbers', 'https://cdn.staticfile.org/highlightjs-line-numbers.js/2.8.0/highlightjs-line-numbers.min.js', [], '2.8.0', true);
            }
            else{
                wp_enqueue_style('highlight-css', STATIC_URL . '/lib/highlight/styles/vs.css', [], '9.9.0');
                wp_enqueue_script('highlight-js', STATIC_URL . '/lib/highlight/highlight.pack.js', [], '9.9.0', true);
                wp_enqueue_script('line-numbers', STATIC_URL . '/lib/highlight/line-numbers.min.js', [], '1.0.0', true);
            }
            
        }
        
        if($cdn){
            wp_enqueue_style('share-css', 'https://cdn.staticfile.org/social-share.js/1.0.16/css/share.min.css', [], '1.0.16');
            wp_enqueue_script('share-js', 'https://cdn.staticfile.org/social-share.js/1.0.16/js/social-share.min.js', [], '1.0.16', true);
        }
        else{
            wp_enqueue_style('share-css', STATIC_URL . '/lib/share/css/share.min.css', [], '1.0.16');
            wp_enqueue_script('share-js', STATIC_URL . '/lib/share/js/social-share.min.js', [], '1.0.16', true);
        }
    }
    
    public function footer($footer)
    {
        $footer .= '<script>hljs.initHighlightingOnLoad();hljs.initLineNumbersOnLoad();</script>';
        return $footer;
    }
}