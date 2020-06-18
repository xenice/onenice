<div class="related">
    <h3><?=_t('Related Articles')?></h3>
    <ul>
        <?php 
        $args = [
            'tax_query'           => [['taxonomy' => $article->taxonomy(), 'terms' => $article->cid()]],
            //'category__in'        => $article->cid(), 
            'post__not_in'        => [$article->id()],
            'posts_per_page'      => 8
        ];
        while($p = $article->pointer($args)): 
        ?>
        <li>
            <i class="fa fa-chevron-right"></i>
            <a href="<?=$p->url()?>" title="<?=$p->title()?>"><?=$p->title()?></a>
        </li>
        <?php endwhile;?>
    </ul>
</div>