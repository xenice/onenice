<?php
/**
 * Single
 *
 * @package YYThemes
 */

get_header();

if ( !yy_import( 'single' ) ) {?>
<div class="yy-main">
    <div class="yy-group">
        <div class="breadcrumb">
        	<div class="container">
        		<?php yy_breadcrumb(); ?>
        	</div>
        </div>
    </div><!-- yy-group -->
    <div class="yy-group">
        <div class="container">
        	<div class="row">
        		<div class="col-md-8" >
        			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        				<h1 class="post-title"><?php the_title(); ?></h1>
        				<div class="post-meta">
        					<?php if ( yy_get( 'single_show_date' ) ) : ?>
        						<span><?php echo get_the_date('Y-m-d'); ?></span>
        					<?php endif; ?>
        					<?php if ( yy_get( 'single_show_author' ) ) : ?>
        						<span class="card-link md-down-none"><?php echo esc_html( get_the_author_meta( 'display_name', $post->post_author ) ); ?></span>
        					<?php endif; ?>
        					<?php if (current_user_can('edit_posts')) : ?>
                    			<a class="card-link" href="<?php echo esc_attr(get_edit_post_link())?>"><?php _e('Edit', 'onenice')?></a>
                    		<?php endif; ?>
        				</div>
        				<div class="post-content gallery">
        					<?php the_content(); ?>
        					<?php wp_link_pages(); ?>
        				</div>
        				<?php if ( yy_get( 'single_show_tags' ) ) : ?>
        					<div class="post-tags"><?php the_tags( __( 'Tags: ', 'onenice' ), '', '' ); ?></div>
        				<?php endif; ?>
        				<?php if(yy_get('enable_like')):?>
                        <div class="post-like">
                            <a href="javascript:;" class="btn btn-custom post-like-a" data-pid="<?php the_ID(); ?>">
                                <i class="fa fa-thumbs-o-up"></i>&nbsp;<?php echo esc_html__('Liked', 'onenice') ?>
                                (<span><?php echo get_post_meta(get_the_ID(),'xenice_likes', true)?:0?></span>)
                            </a>
                        </div>
                        <?php endif; ?>
        				<?php if ( yy_get( 'single_show_share' ) ) : ?>
        					<div class="share-component" style="text-align:center;margin-top:20px" data-disabled="<?php echo esc_attr( yy_get( 'single_disable_share_buttons' ) ); ?>"></div>
        				<?php endif; ?>
        				<?php if ( yy_get( 'single_show_previous_next' ) ) : ?>
        					<div class="adjacent d-flex justify-content-between">
        						<span class="previous"><?php previous_post_link( __( 'Previous Post', 'onenice' ) . '<br/>%link', '%title', true ); ?></span>
        						<span class="next"><?php next_post_link( __( 'Next Post', 'onenice' ) . '<br/>%link', '%title', true ); ?></span>
        					</div>
        				<?php endif; ?>
        			</article>
        			<?php
    				if ( yy_get( 'show_related_posts' ) ) {
    					get_template_part( 'template-parts/related', 'posts' );}
    				?>
    				<?php comments_template(); ?>
        		</div>
        	<?php get_sidebar(); ?>
        	</div><!-- row -->
        </div>
    </div><!-- yy-group -->
</div><!-- yy-main -->
	<?php
}

get_footer();
