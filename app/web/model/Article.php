<?php

namespace app\web\model;

use xenice\theme\Theme;
use xenice\model\ArticleModel;

class Article extends ArticleModel
{
    use \app\web\model\part\Article;
    
    public function __construct()
    {
        parent::__construct();
        Theme::bind('article_date',[$this, 'alterDate']);
        Theme::bind('article_comments',[$this, 'alterComments']);
        Theme::bind('article_views',[$this, 'alterViews']);
        take('first_image_thumbnail') && Theme::bind('article_thumbnail',[$this, 'alterThumbnail']);
    }
    
    public function alterDate($date)
    {
        return $this->since($date);
    }
    
    public function alterComments($count, $p)
    {
        $comments = $count . ' ';
        if($count >1 ){
            $comments .= _t('comments');
        }
        else{
            $comments .= _t('comment');
        }
        return $comments;
    }
    
    public function alterViews($count)
    {
        if($count >1 ){
            return $count . ' ' . _t('views');
        }
        else{
            return $count . ' ' . _t('view');
        }
    }
    
    public function alterThumbnail($src, $p)
    {
        if(!$src){
            preg_match_all( '/\<img.+?src="(.+?)".*?\/>/is', $p->row('post_content'), $matches, PREG_SET_ORDER );
            if(isset($matches[0][1])){
                return $matches[0][1];
            }
            else{
                return take('default_thumbnail');
            }
        }
        else{
            return $src;
        }
    }
}