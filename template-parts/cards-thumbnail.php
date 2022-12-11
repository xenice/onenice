<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<div class="card">
    <div class="card-body d-flex">
    <a href="<?php the_permalink()?>" title="<?php the_title() ?>">
        <img class="lazyload" src="<?=onenice_get('site_loading_image')?>" data-src="<?=get_the_post_thumbnail_url()?:onenice_get('site_thumbnail')?>" alt="<?php the_title() ?>" />
    </a>
    <div class="data">
    	<h4 class="card-title">
    	    <a href="<?php the_permalink()?>" title="<?php the_title() ?>"><?php the_title() ?></a>
    	</h4>
    	<?php if(onenice_get('archive_show_date')):?>
            <span class="card-link"><?php echo get_the_date() ?></span>
        <?php endif;?>
        <?php if(onenice_get('archive_show_author')):?>
            <span class="card-link md-down-none"><?php the_author()?></span>
        <?php endif;?>
	    <p class="card-text md-down-none"><?php the_excerpt() ?></p>
	</div>
  </div>
</div>
<?php endwhile;?>

<?php else: ?>
<div class="card">
    <div class="card-body">
        <p class="card-text"><?=__('No articles.', 'onenice')?></p>
    </div>
</div>
<?php endif; ?>