<?php

namespace app\web\model\part;

use xenice\theme\Theme;

trait Comment
{
    use Model;
    use Paginate;
    
    public function list($args = [])
    {
        global $comment_alt, $comment_depth, $comment_thread_alt, $overridden_cpage, $in_comment_loop;
        
    	$in_comment_loop = true;
    
    	$comment_alt = $comment_thread_alt = 0;
    	$comment_depth = 1;
    
    	$defaults = array(
    		'walker'            => null,
    		'max_depth'         => '',
    		'style'             => 'div',
    		'callback'          => [$this,'callback'],
    		'end-callback'      => [$this,'endCallback'],
    		'type'              => 'all',
    		'page'              => '',
    		'per_page'          => '',
    		'avatar_size'       => 32,
    		'reverse_top_level' => null,
    		'reverse_children'  => '',
    		'format'            => current_theme_supports( 'html5', 'comment-list' ) ? 'html5' : 'xhtml',
    		'short_ping'        => false
    	);
    
    	$r = wp_parse_args( $args, $defaults );
    
    	// Figure out what comments we'll be looping through ($_comments)
    	$this->query(['post_id'=>$this->post->ID, 'status' => 'approve']);
    	//$comments = get_comments(['post_id'=>$this->post->ID, 'status' => 'approve']);
		$comments = (array) $this->query;
		if ( empty($comments) )
			return;
		if ( 'all' != $r['type'] ) {
			$comments_by_type = separate_comments($comments);
			if ( empty($comments_by_type[$r['type']]) )
				return;
			$_comments = $comments_by_type[$r['type']];
		} else {
			$_comments = $comments;
		}

    
    	if ( '' === $r['per_page'] && get_option('page_comments') )
    		$r['per_page'] = get_query_var('comments_per_page');
    
    	if ( empty($r['per_page']) ) {
    		$r['per_page'] = 0;
    		$r['page'] = 0;
    	}
    
    	if ( '' === $r['max_depth'] ) {
    		if ( get_option('thread_comments') )
    			$r['max_depth'] = get_option('thread_comments_depth');
    		else
    			$r['max_depth'] = -1;
    	}
    
    	if ( '' === $r['page'] ) {
    		if ( empty($overridden_cpage) ) {
    			$r['page'] = get_query_var('cpage');
    		} else {
    			$threaded = ( -1 != $r['max_depth'] );
    			$r['page'] = ( 'newest' == get_option('default_comments_page') ) ? get_comment_pages_count($_comments, $r['per_page'], $threaded) : 1;
    			set_query_var( 'cpage', $r['page'] );
    		}
    	}
    	// Validation check
    	$r['page'] = intval($r['page']);
    	if ( 0 == $r['page'] && 0 != $r['per_page'] )
    		$r['page'] = 1;
    
    	if ( null === $r['reverse_top_level'] )
    		$r['reverse_top_level'] = ( 'desc' == get_option('comment_order') );
    
    	if ( empty( $r['walker'] ) ) {
    		$walker = new \Walker_Comment;
    	} else {
    		$walker = $r['walker'];
    	}
    
    	$output = $walker->paged_walk( $_comments, $r['max_depth'], $r['page'], $r['per_page'], $r );
    
    	$in_comment_loop = false;

    	return $output;

    }
    
    /**
     * Theme comment callback
     *
     * @param $comment
     * @param $args
     * @param $depth
     */
    public function callback( $comment, $args, $depth )
    {
        $page         = ( ! empty( $in_comment_loop ) ) ? get_query_var( 'cpage' ) - 1 : get_page_of_comment( $comment->comment_ID, $args ) - 1;
        $cpp          = get_option( 'comments_per_page' );
        //$this->commentcount = $this->commentcount??$cpp * $page;
        $this->commentcount = $this->commentcount??$this->count-1;
        $p = Theme::new('comment_pointer', $comment);
        if (!$p->pid()) {
            ?>
            <div id="comment-<?=$p->id()?>" class="media">
                <?=$p->avatar(50)?>
                <div class="media-body">
                    <div class="d-flex justify-content-between">
                        <span><?=$p->text()?></span>
                        <span class="comment-floor"><?php $this->commentcount --;
                            switch ( $this->commentcount ) {
                                case 1:
                                    echo _t( 'Sofa');
                                    break;
                                case 2:
                                    echo _t( 'Bench');
                                    break;
                                case 3:
                                    echo _t( 'Floor');
                                    break;
                                default:
                                    printf( _t('#%s'), $this->commentcount );
                            } ?>
                        </span>
                    </div>
                    <div class="comments-meta">
                        <span class="comments-author <?php if ( $p->uid() == 1 ) {
                            echo "comments-admin";
                        } ?>"><?=$p->userLink()?></span>
                         <span><?=$p->date()?></span>
                         <?=$p->replyLink( array_merge( $args,[
                            'depth'      => $depth,
                            'max_depth'  => $args['max_depth'],
                            'reply_text' => _t( 'Reply')
                        ]) ) ?>
                    </div>
               
            
        <?php } else {
            ?>
            <div id="comment-<?=$p->id()?>" class="media comments-sub">
                <?=$p->avatar(30)?>
                <div class="media-body">
                    <?php
                        $parent_id      = $comment->comment_parent;
                        $comment_parent = get_comment( $parent_id );
                    ?>
                    <span class="comment-to">
                        <a href="<?php echo "#comment-" . $parent_id; ?>"
                           title="<?php echo mb_strimwidth( strip_tags($comment_parent->comment_content ), 0, 100, "..." ); ?>">
                            @<?php echo $comment_parent->comment_author; ?>
                        </a>: 
                    </span>
                    <span><?=$p->text()?></span>
                    <div class="comments-meta">
                        <span class="comments-author <?php if ( $p->uid() == 1 ) {
                            echo "comments-admin";
                        } ?>"> <?=$p->userLink()?>
                            
                        </span>
                        <span ><?=$p->date()?></span>
                        <span ><?=$p->replyLink( array_merge( $args, [
                            'depth'      => $depth,
                            'max_depth'  => $args['max_depth'],
                            'reply_text' => _t('Reply')
                        ] ) ) ?></span>
                    </div>
       
        <?php }
    }

    public function endCallback()
    {
        echo "</div></div><!-- media -->";
    }
    
    public function paginate($space = 5)
    {
        if(!$num = get_option('comments_per_page')){
            return;
        }
        
        $paged = get_query_var('cpage')?:1;
        
        $threaded = get_option('thread_comments');
    	if ( $threaded ) {
        	$walker = new \Walker_Comment;
    		$total = ceil( $walker->get_number_of_root_elements( $this->query) / $num );
    	} else {
    		$total = ceil($this->post->comment_count / $num);
    	}
    	
    	global $wp_rewrite;
    	$pagination_base = '';
    	if ( $wp_rewrite->using_permalinks()){
    	    $pagination_base = $wp_rewrite->comments_pagination_base;
    		$base_url = trailingslashit(get_permalink());
    		$this->paginateLinks($base_url, $pagination_base, $total, $paged, $space,'-%#%', '#comments');
    	}
    }
}