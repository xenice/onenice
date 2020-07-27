<?php
/**
 * @name        Xenice Article Model
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-13
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\model;

use xenice\theme\Theme;

class CommentModel extends Model
{
    protected $post;
    protected $query;
    protected $index = 0;
    protected $count = 0;
    
    public function __construct()
    {
        global $post;
        $this->post = $post;
    }
    
    public function has()
    {
        return $this->post->comment_count?true:false;
    }
    
    public function open()
    {
        return $this->status()=='open';
    }
    
    public function register()
    {
        return get_option( 'comment_registration' );
    }
    
    public function status()
    {
        return $this->post->comment_status;
    }
    
    
    public function count($parentCount = false)
    {
        if($parentCount){
            $count = 0;
            foreach($this->query as $p){
                if($p->comment_parent == 0){
                    $count ++;
                }
            }
            return $count;
        }
        return $this->post->comment_count;
    }
    
    public function tip()
    {
        return isset($_GET['replytocom'])?'@' . get_comment_author($_GET['replytocom']):_t("Comment");
    }
    
    public function fields()
    {
        return get_comment_id_fields();
    }
    
    public function cancelReplyLink($str = null)
    {
        return get_cancel_comment_reply_link($str);
    }
    
    public function query($args)
    {
        $this->query = (new \WP_Comment_Query)->query($args);
        //var_dump($this->query);
        $this->index = 0;
        $this->count = count($this->query);
    }
    
    
    public function pointer($args = '')
    {
        if(!$this->query){
            $this->query($args);
        }
        $query = $this->query;
        if($this->index < $this->count){
            $pointer = Theme::new('comment_pointer', $this->query[$this->index]);
            $this->index ++;
            return $pointer;
        }
        else{
            $this->query = null;
            $this->count = 0;
            $this->index = 0;
        }
    }
}