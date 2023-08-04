<?php
/**
 * Index
 *
 * @package Onenice
 */

get_header();

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {?>

<div class="main container">
	<div class="row">
		<div class="col-md-8">
			<?php onenice_get( 'enable_slides' ) && get_template_part( 'template-parts/home', 'slides' ); ?>
			<h3><?php esc_html_e( 'Recent Posts', 'onenice' ); ?></h3>
			<?php get_template_part( 'template-parts/cards', onenice_get( 'list_style' ) ); ?>
			<ul class="pagination">
				<?php echo paginate_links(); ?>
			</ul>
		</div>
	<?php get_sidebar(); ?>
	</div><!-- row -->
</div>
	<?php
}

get_footer();
