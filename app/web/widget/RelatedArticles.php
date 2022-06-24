<?php
namespace app\web\widget;

use xenice\theme\Theme;

class RelatedArticles extends \WP_Widget
{
    public function __construct()
    {
        $widget_ops = array( 'description' => _t('Xenice Related Articles') );
        parent::__construct( 'xenice_related_articles', _t('Related Articles'), $widget_ops );
    }

    function widget( $args, $instance )
    {
        extract( $args );
        ?>
        <div class="right-group">
            <h3><?=$instance['name']?></h3>
            <ul class="list">
                <?php
                $article = Theme::use('article');
                $args  = array(
                    'tax_query'           => [['taxonomy' => $article->taxonomy(), 'terms' => $article->cid()]],
                    'post__not_in'        => [$article->id()],
                    'post_status'         => 'publish',
                    'showposts'           => $instance['limit']
                );
                $none = true;
                while($p = $article->pointer($args)):$none=false?>
                    <?php if(take('display_style') == 'text'): ?>
                        <li class="d-flex justify-content-between text">
                            <a href="<?=$p->url()?>" rel="bookmark" title="<?=$p->title()?>"><?=$p->title()?></a>
                            <span><?=$p->views()?></span>
                        </li>
                    <?php else: ?>
                        <li class="d-flex thumbnail">
                            <a href="<?=$p->url()?>" title="<?=$p->title()?>">
                                <img class="lazyload" src="<?=take('default_loading_image')?>" data-src="<?=$p->thumbnail()?>" alt="<?=$p->title()?>"/>
                            </a>
                            <div class="data">
                                <a href="<?=$p->url()?>" rel="bookmark" title="<?=$p->title()?>"><?=$p->title()?></a>
                                <span><?=$p->views()?></span>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endwhile;?>
                <?php if($none): ?>
                    <li class="d-flex justify-content-between text">
                        <?=_t("暂无 ..")?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    <?php
    }

    function form( $instance )
    {
        $instance = wp_parse_args( (array) $instance, ['name'=>_t( 'Related Articles'),'limit' => 8 ]);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'name' ); ?>"><?=_t('Name:')?>
                <input class="widefat" type="text"
                    id="<?php echo $this->get_field_id( 'name' ); ?>"
                    name="<?php echo $this->get_field_name( 'name' ); ?>"
                    value="<?php echo $instance['name']; ?>"/>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?=_t('Article Count:')?>
            <input class="tiny-text" type="number" step="1"
                    id="<?php echo $this->get_field_id( 'limit' ); ?>"
                    name="<?php echo $this->get_field_name( 'limit' ); ?>" 
                    value="<?php echo $instance['limit']; ?>"/>
            </label>
        </p>
    <?php
    }
}
