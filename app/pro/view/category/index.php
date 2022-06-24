<?php import('header'); ?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {?>
<div class="breadcrumb">
	<div class="container">
		<?=$category->breadcrumb()?>
	</div>
</div>
<div class="main container">
	<div class="row">
	  <div class="col-md-8">
	    <?php import('cards-' . take('display_style')) ?>
		<ul class="pagination">
            <?php $article->paginate(); ?>
        </ul>
	  </div>
    <?php import('sidebar'); ?>
	</div><!-- row -->
</div>
<?php }?>
<?php import('footer'); ?>