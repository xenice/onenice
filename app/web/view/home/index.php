<?php import('header'); ?>
<div class="main container">
	<div class="row">
	  <div class="col-md-8">
	    <?php take('enable_slide') && import('home/slide'); ?>
	    <h3><?=_t('Recent Articles')?></h3>
	    <?php import('cards-' . take('display_style')) ?>
		<ul class="pagination">
            <?php $article->paginate(); ?>
        </ul>
	  </div>
    <?php import('sidebar'); ?>
	</div><!-- row -->
</div>
<?php import('footer'); ?>