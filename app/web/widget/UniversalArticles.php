<?php
namespace app\web\widget;

use xenice\theme\Theme;

class UniversalArticles extends \WP_Widget
{
    public function __construct()
    {
        $widget_ops = array( 'description' => _t('Xenice Universal Articles') );
        parent::__construct( 'xenice_universal_articles', _t('Universal Articles'), $widget_ops );
    }

    function widget( $args, $instance )
    {
        extract( $args );
        ?>
        <div class="right-group">
            <?php
                $args  = [
                    'orderby'             => 'modified',
                    'ignore_sticky_posts' => 1,
                    'post_type'           => Theme::get('post_type')??'post',
                    'post_status'         => 'publish',
                    'showposts'           => $instance['limit']
                ];
                $name = '';
                if($instance['category']){
                    $args['cat'] = $instance['category'];
                    $name = $instance['name'];
                }
                else{
                    if(Theme::get('type') == 'category'){
                        $cat = Theme::use('category');
                        $args['cat'] = $cat->id();
                        $name = $cat->name() . $instance['name'];
                    }
                    if(!$name){
                        $name = _t('Recent Articles');
                    }
                }
                $article = Theme::use('article');
            ?>
            <h3><?=$name?></h3>
            <ul class="list">
                <?php while($p = $article->pointer($args)):?>
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
        $default = [
            'name' =>_t( 'Universal Articles'),
            'limit' => 8,
            'category' => 0
        ];
        $instance = wp_parse_args( (array) $instance, $default);
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
        <p>
            <label for="<?php echo $this->get_field_id( 'category' ); ?>"><?=_t('Category:')?>
                <select class="tiny-text" id="<?php echo $this->get_field_id( 'category' ); ?>"
                    name="<?php echo $this->get_field_name( 'category' ); ?>">
                    <?php
                        if(0 == $instance['category']){
                            echo '<option value ="0" selected>['. _t('Auto') .']</option>';
                        }
                        else{
                            echo '<option value ="0">['._t('Auto').']</option>';
                        }
                        $arr = get_categories();
                    	foreach ($arr as $category){
                            if($category->cat_ID == $instance['category']){
                                echo '<option value ="'. $category->cat_ID .'" selected>'.$category->cat_name.'</option>';
                            }
                            else{
                                echo '<option value ="'. $category->cat_ID .'">'.$category->cat_name .'</option>';
                            }
                    	}
                      ?>
				</select>
            </label>
        </p>
    <?php
    }
}
