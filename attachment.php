<?php
/**
 * Attachment
 *
 * @package YYThemes
 */

get_header();

if ( !yy_import( 'archive' ) ) {?>
<div class="yy-main">
    <div class="yy-group">
        <div class="container">
        	<div class="row">
        		<div class="col-md-12">
        			<h1 class="post-title"><a href="<?php the_permalink(); ?>"
        				title="<?php the_title(); ?>"><?php the_title(); ?></a>
        			</h1>
        			<div class="post-meta">
        				<?php if ( yy_get( 'single_show_date' ) ) : ?>
        					<span><?php echo get_the_date('Y-m-d'); ?></span>
        				<?php endif; ?>
        				<?php if ( yy_get( 'single_show_author' ) ) : ?>
        					<span class="card-link md-down-none"><?php echo esc_html( get_the_author_meta( 'display_name', $post->post_author ) ); ?></span>
        				<?php endif; ?>
        			</div>
        			<div class="post-content">
        				<?php echo wp_get_attachment_image( get_the_ID(), 'large' ); ?>
        			</div>
        		</div>
        	</div><!-- row -->
        </div>
    </div><!-- yy-group -->
</div><!-- yy-main -->
	<?php
}

get_footer();
