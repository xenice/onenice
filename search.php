<?php
get_header();

if (!function_exists( 'elementor_theme_do_location' ) || !elementor_theme_do_location( 'archive' ) ) {?>

<div class="breadcrumb">
	<div class="container">
	    <a class="breadcrumb-item" href="<?=home_url()?>"><?=__('Home', 'onenice')?></a>
        <span class="breadcrumb-item"><?=__('Search', 'onenice'); ?></span>
        <span class="breadcrumb-item active"><?=$s?></span>
	</div>
</div>
<div class="main container">
	<div class="row">
	  <div class="col-md-8">
	    <?php get_template_part('template-parts/cards', 'text' ); ?>
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