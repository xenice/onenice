<?php

namespace app\web\model;

use xenice\theme\Theme;
use xenice\model\CommentModel;

class Comment extends CommentModel
{
    
    use \app\web\model\part\Comment;
    
    public function __construct()
    {
        parent::__construct();
        Theme::bind('comment_date',[$this, 'alterDate']);
    }
    
    public function alterDate($date)
    {
        return $this->since($date);
    }

    
}