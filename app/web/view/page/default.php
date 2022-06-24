<?php import('header'); ?>
<?php if ( !take('fit_elementor') || ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {?>
<div class="breadcrumb">
	<div class="container">
	    <?=$page->breadcrumb()?>
	</div>
</div>
<div class="main container">
	<div class="row">
	  <div class="col-md-8">
            <h1 class="post-title"><a href="<?=$page->url()?>"
                title="<?=$page->title()?>"><?=$page->title()?></a>
            </h1>
    		<div class="post-content"><?=$page->content(); ?></div>
        <?php import('comments'); ?>
	  </div>
    <?php import('sidebar'); ?>
	</div><!-- row -->
</div>
<?php }?> 
<?php import('footer'); ?>