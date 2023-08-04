<?php
/**
 * Page
 *
 * @package Onenice
 */

get_header();

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {?>

<div class="main container">
	<div class="row">
		<div class="col-md-12">
			<h1 class="post-title"><a href="<?php the_permalink(); ?>"
				title="<?php the_title(); ?>"><?php the_title(); ?></a>
			</h1>
			<div class="post-content"><?php the_content(); ?></div>

			<?php comments_template(); ?>
		</div>
	</div><!-- row -->
</div>

	<?php
}

get_footer();
