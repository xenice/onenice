<?php import('header');?>
<?php if ( !take('fit_elementor') || ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {?>
<div class="main container">
	<div class="row">
	  <div class="col-md-8">
	    <?php take('enable_slide') && import('home/slide'); ?>
	    <?php take('enable_sticky_articles') && import('home/hot'); ?>
	    <h3><?=take('recent_articles_alias')??_t('Recent Articles')?></h3>
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