<?php
/**
 * @name        Xenice Comment Pointer
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-17
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model\pointer;

use xenice\theme\Theme;

class CommentPointer extends Pointer
{

    public function __construct($row)
    {
        $this->row = $row;
    }

    public function id()
	{
		return $this->row->comment_ID;
	}
	
	public function pid()
	{
		return $this->row->comment_parent;
	}
	
	public function uid()
	{
	    return $this->row->user_id;
	}
	
	public function author()
	{
	    return $this->row->comment_author;
	}
	
	public function authorEmail()
	{
	    return $this->row->comment_author_email;
	}
	
	public function authorIP()
	{
	    return $this->row->comment_author_IP;
	}
	
	public function content()
	{
	    return $this->row->comment_content;
	}

	public function date()
	{
	    return Theme::call('comment_date', $this->row->comment_date, $this);
	}
	
	public function aid()
	{
	    return $this->row->comment_post_ID;
	}
}