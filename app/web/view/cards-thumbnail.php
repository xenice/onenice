<?php ad('list_top','card');?>
<?php while($p = $article->first()): ?>
<div class="card">
  <div class="card-body d-flex">
    <a href="<?=$p->url()?>" title="<?=$p->title()?>">
        <img class="lazyload" src="<?=take('default_loading_image')?>" data-src="<?=$p->thumbnail()?>" alt="<?=$p->title()?>" />
    </a>
    <div class="data">
    	<h4 class="card-title">
    	    <?php if (take('enable_category_badge')): ?>
    	        <a class="badge badge-custom" href="<?=$p->curl()?>"><?=$p->category()?></a>
    	    <?php endif;?>
    	    <a href="<?=$p->url()?>" title="<?=$p->title()?>"><?=$p->title()?></a>
    	</h4>
    	<span class="card-link"><?=$p->date()?></span>
    	<span class="card-link md-down-none"><?=$p->user()?></span>
    	<span class="card-link"><?=$p->views()?></span>
    	<p class="card-text"><?=$p->description(); ?></p>
	</div>
  </div>
</div>
<?php endwhile;?>
<?php if(!$article->has()):?>
<div class="card">
    <div class="card-body">
        <p class="card-text"><?=_t('No articles.')?></p>
    </div>
</div>
<?php endif;?>
<?php ad('list_bottom','card');?>