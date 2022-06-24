<div class="related left-card">
    <h3><?=take('related_articles_alias')?:_t('Related Articles')?></h3>
    <ul>
        <?php 
        $args = array(
            'category__in'        => $article->cid(), 
            'post__not_in'        => [$article->id()],
            'ignore_sticky_posts' => 1,
            'posts_per_page'      => 8
        );
        while($p = $article->pointer($args)): 
        ?>
        <li>
            <i class="fa fa-chevron-right"></i>
            <a href="<?=$p->url()?>" title="<?=$p->title()?>"><?=$p->title()?></a>
        </li>
        <?php endwhile;?>
    </ul>
</div>