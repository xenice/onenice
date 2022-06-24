<?php
namespace app\web\widget;

use xenice\theme\Theme;

class StickyArticles extends \WP_Widget
{
    public function __construct()
    {
        $widget_ops = array( 'description' => _t('Xenice Sticky Articles') );
        parent::__construct( 'xenice_sticky_article', _t('Sticky Articles'), $widget_ops );
    }

    public function widget( $args, $instance )
    {
        extract( $args );
        ?>
        <div class="right-group">
            <h3><?=$instance['name']?></h3>
            <ul class="list">
                <?php
                $args  = array(
                    'orderby'             => 'modified',
                    'post__in' => get_option('sticky_posts'),
                    'post_type'           => Theme::get('post_type')??'post',
                    'post_status'         => 'publish',
                    'showposts'           => $instance['limit']
                );
                $article = Theme::use('article');
                
                while($p = $article->pointer($args)):?>
                    <?php if(take('display_style') == 'text'): ?>
                        <li class="d-flex justify-content-between text">
                            <a href="<?=$p->url()?>" rel="bookmark" title="<?=$p->title()?>"><?=$p->title()?></a>
                            <span><?=$p->date()?></span>
                        </li>
                    <?php else: ?>
                        <li class="d-flex thumbnail">
                            <a href="<?=$p->url()?>" title="<?=$p->title()?>">
                                <img class="lazyload" src="<?=take('default_loading_image')?>" data-src="<?=$p->thumbnail()?>" alt="<?=$p->title()?>"/>
                            </a>
                            <div class="data">
                                <a href="<?=$p->url()?>" rel="bookmark" title="<?=$p->title()?>"><?=$p->title()?></a>
                                <span><?=$p->date()?></span>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endwhile;?>
            </ul>
        </div>
    <?php
    }

    function form( $instance )
    {
        $instance = wp_parse_args( (array) $instance, ['name'=>_t( 'Sticky Articles'), 'limit' => 8] );
        $limit    = strip_tags( $instance['limit'] );
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
                    value="<?php echo $limit; ?>"/>
            </label>
        </p>
    <?php
    }
}