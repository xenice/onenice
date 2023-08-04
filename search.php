<?php
/**
 * Search
 *
 * @package Onenice
 */

get_header();

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {?>

<div class="breadcrumb">
	<div class="container">
		<a class="breadcrumb-item" href="<?php echo esc_html( home_url() ); ?>"><?php esc_html_e( 'Home', 'onenice' ); ?></a>
		<span class="breadcrumb-item"><?php esc_html_e( 'Search', 'onenice' ); ?></span>
		<span class="breadcrumb-item active"><?php echo esc_html( $s ); ?></span>
	</div>
</div>
<div class="main container">
	<div class="row">
		<div class="col-md-8">
		<?php get_template_part( 'template-parts/cards', 'text' ); ?>
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
