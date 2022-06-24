<?php
if(take('enable_list_top_ad')){
    echo '<div class="card">' . take('list_top_ad_code') . '</div>';
}
?>
<?php while($p = $article->first()): ?>
<div class="card">
  <div class="card-body">
	<h4 class="card-title">
        <?php if (take('enable_category_badge')): ?>
	        <a class="badge badge-custom" href="<?=$p->curl()?>"><?=$p->category()?></a>
	    <?php endif;?>
	    <?=($p->status() == 'private')?'<span class="badge badge-success">'._t('private').'</span>':''?>
	    <a href="<?=$p->url()?>" title="<?=$p->title()?>"><?=$p->title()?></a>
	</h4>
	<?=take('list_show_desc')?'<p class="card-text">'.$p->description().'</p>':''?>
	<div class="meta">
	    <span class="card-link"><?=$p->date()?></span>
        <?=take('list_show_author')?'<span class="card-link md-down-none">'.$p->user().'</span>':''?>
    	<?=take('list_show_views')?'<span class="card-link view">'.$p->views().'</span>':''?>
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
<?php
if(take('enable_list_bottom_ad')){
    echo '<div class="card">' . take('list_bottom_ad_code') . '</div>';
}
?>