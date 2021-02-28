<?php

namespace app\web\controller;

use xenice\theme\Theme;
use xenice\theme\Controller;

class SingleController extends Controller
{
    public function index($view = 'index')
    {
        Theme::bind('footer', [$this, 'footer']);
        add_action( 'wp_enqueue_scripts', [$this, 'scripts']);
        //add_action( 'wp_print_scripts', [$this, 'footer']);
        $article = Theme::use('article');
        $article->setViews();
        if(take('enable_article_seo') && $title = $article->get('title'))
	       $this->title = $title;
	    else
            $this->title = $article->title() . ' - ' . $this->option->info['name'];
        $this->description = $article->description();
        $this->keywords = $article->keywords();
	    $this->render($view);
    }
    
    public function scripts()
    {
        $cdn = take('enable_cdn');
        $cdn_url = take('cdn_url');
        if(take('enable_highlight')){
            if($cdn){
                wp_enqueue_style('highlight-css', $cdn_url . '/highlight.js/10.1.2/styles/vs.min.css', [], '10.1.2');
                wp_enqueue_script('highlight-js', $cdn_url . '/highlight.js/10.1.2/highlight.min.js', [], '10.1.2', true);
                wp_enqueue_script('line-numbers', $cdn_url . '/highlightjs-line-numbers.js/2.8.0/highlightjs-line-numbers.min.js', [], '2.8.0', true);
            }
            else{
                wp_enqueue_style('highlight-css', STATIC_URL . '/lib/highlight/styles/vs.css', [], '9.9.0');
                wp_enqueue_script('highlight-js', STATIC_URL . '/lib/highlight/highlight.pack.js', [], '9.9.0', true);
                wp_enqueue_script('line-numbers', STATIC_URL . '/lib/highlight/line-numbers.min.js', [], '1.0.0', true);
            }
            
        }
        
        if($cdn){
            wp_enqueue_style('share-css', $cdn_url . '/social-share.js/1.0.16/css/share.min.css', [], '1.0.16');
            wp_enqueue_script('share-js', $cdn_url . '/social-share.js/1.0.16/js/jquery.share.min.js', [], '1.0.16', true);
        }
        else{
            wp_enqueue_style('share-css', STATIC_URL . '/lib/share/css/share.min.css', [], '1.0.16');
            wp_enqueue_script('share-js', STATIC_URL . '/lib/share/js/jquery.share.min.js', [], '1.0.16', true);
        }
    }
    
    public function footer($footer)
    {
        if(take('enable_highlight')){
            $footer .= '<script>hljs.initHighlightingOnLoad();hljs.initLineNumbersOnLoad();</script>';
        }
        return $footer;
    }
}