<?php
get_header();

if (!function_exists( 'elementor_theme_do_location' ) || !elementor_theme_do_location( 'archive' ) ) {?>

<div class="breadcrumb">
	<div class="container">
		<?php echo onenice_breadcrumb()?>
	</div>
</div>
<div class="main container">
	<div class="row">
	  <div class="col-md-8">
	    <?php get_template_part('template-parts/cards', onenice_get('list_style')); ?>
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