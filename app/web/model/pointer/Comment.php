<?php

namespace app\web\model\pointer;

use xenice\theme\Theme;
use xenice\model\pointer\CommentPointer;

class Comment extends CommentPointer
{
    public function __construct($mix)
    {
        parent::__construct($mix);
    }
    
	public function avatar($size = 32)
	{
	    return get_avatar( $this->authorEmail(), $size, '', '', ['class'=>'rounded-circle']);
	}
	
	public function userLink()
	{
	    return get_comment_author_link($this->id());
	}
	
	public function text()
	{
	    return get_comment_text($this->id());
	}
	
	public function replyLink($args = [])
	{
	    return get_comment_reply_link($args, $this->id());
	}
	
	public function articleLink()
	{
	    return get_permalink( $this->aid());
	}
}