<?php import('header'); ?>
<?php if ( !take('fit_elementor') || ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {?>
<style>
.main .author{
    padding:10px;
    text-align: center;
}
</style>
<div class="main container">
	<div class="row">
	  <div class="col-md-8">
	    <div class="card author">
    		<div><?=$author->avatar(48)?></div>
    		<div><?=sprintf('%s Articles', $author->nicename())?></div>
        </div>
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