<?php ad('list_top','card');?>
<?php while($p = $article->first()): ?>
<div class="card">
  <div class="card-body d-flex">
    <img class="lazyload" src="<?=STATIC_URL?>/images/thumbnail.png" data-src="<?=$p->thumbnail()?>"/>
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
<?php ad('list_bottom','card');?>