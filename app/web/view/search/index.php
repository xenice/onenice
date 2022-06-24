<?php import('header'); ?>
<?php if ( !take('fit_elementor') || ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {?>
<div class="breadcrumb">
	<div class="container">
	    <a class="breadcrumb-item" href="<?=$option->info['url']?>"><?=_t('Home')?></a>
        <span class="breadcrumb-item"><?=_t('Search keyword'); ?></span>
        <span class="breadcrumb-item active"><?=$s?></span>
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