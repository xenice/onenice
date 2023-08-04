<?php
/**
 * Single
 *
 * @package Onenice
 */

get_header();

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {?>
<div class="breadcrumb">
	<div class="container">
		<?php onenice_breadcrumb(); ?>
	</div>
</div>
<div class="main container">
	<div class="row">
		<div class="col-md-8" >
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1 class="post-title"><a href="<?php the_permalink(); ?>"
					title="<?php the_title(); ?>"><?php the_title(); ?></a>
				</h1>
				<div class="post-meta">
					<?php if ( onenice_get( 'single_show_date' ) ) : ?>
						<span><?php echo get_the_date(); ?></span>
					<?php endif; ?>
					<?php if ( onenice_get( 'single_show_author' ) ) : ?>
						<span class="card-link md-down-none"><?php echo esc_html( get_the_author_meta( 'display_name', $post->post_author ) ); ?></span>
					<?php endif; ?>
				</div>
				<div class="post-content">
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>
				</div>
				<?php if ( onenice_get( 'single_show_tags' ) ) : ?>
					<div class="post-tags"><?php the_tags( __( 'Tags: ', 'onenice' ), '', '' ); ?></div>
				<?php endif; ?>
				<?php if ( onenice_get( 'single_show_share' ) ) : ?>
					<div class="share-component" style="text-align:center;margin-top:20px" data-disabled="<?php echo esc_attr( onenice_get( 'single_disable_share_buttons' ) ); ?>"></div>
				<?php endif; ?>
				<?php if ( onenice_get( 'single_show_previous_next' ) ) : ?>
					<div class="adjacent d-flex justify-content-between">
						<span class="previous"><?php previous_post_link( __( 'Previous Post', 'onenice' ) . '<br/>%link', '%title', true ); ?></span>
						<span class="next"><?php next_post_link( __( 'Next Post', 'onenice' ) . '<br/>%link', '%title', true ); ?></span>
					</div>
				<?php endif; ?>
				<?php
				if ( onenice_get( 'show_related_posts' ) ) {
					get_template_part( 'template-parts/related', 'posts' );}
				?>
				<?php comments_template(); ?>
			</article>
		</div>
	<?php get_sidebar(); ?>
	</div><!-- row -->
</div>

	<?php
}

get_footer();
