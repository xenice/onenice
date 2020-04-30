<?php
namespace app\web\widget;

use xenice\theme\Theme;

class TagsCloud extends \WP_Widget
{
    public function __construct()
    {
        $widget_ops = ['description' => _t('Xenice Tags Cloud')];
        parent::__construct( 'xenice_tags_cloud', _t('Tags Cloud'), $widget_ops );
    }

    function widget( $args, $instance )
    {
        extract( $args );
        ?>
        <div class="right-group tags-cloud">
            <h3><?=$instance['name']?></h3>
            <div class="items">
            <?php
        		$tags = get_tags('orderby=count&order=DESC&number='.$instance['limit']);
        		if ($tags) { 
        			foreach($tags as $tag) {
        				echo '<a href="'.get_tag_link($tag).'">'. $tag->name .' ('. $tag->count .')</a>'; 
        			} 
        		}else{
        			echo _t('No tags');
        		}
    		?>
    		</div>
    		<div style="clear:both"></div>
        </div>
    <?php
        Theme::use('template')->js .=<<<js
len = $(".tags-cloud .items a").length - 1;
$(".tags-cloud .items a").each(function(i) {
    var let = new Array( '27ea80','3366FF','ff5473','df27ea', '31ac76', 'ea4563', '31a6a0', '8e7daa', '4fad7b', 'f99f13', 'f85200', '666666');
    var random1 = Math.floor(Math.random() * 12) + 0;
    var num = Math.floor(Math.random() * 5 + 12);
    $(this).attr('style', 'background:#' + let[random1] + '; opacity: 0.6;'+'');
    if ($(this).next().length > 0) {
        last = $(this).next().position().left
    }
});
js;
    }

    function form( $instance )
    {
        $default = [
            'name'=>_t('Tags Cloud'),
            'limit' => 30
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
            <label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?=_t('Count:')?>
            <input class="tiny-text" type="number" step="1"
                    id="<?php echo $this->get_field_id( 'limit' ); ?>"
                    name="<?php echo $this->get_field_name( 'limit' ); ?>" 
                    value="<?php echo $instance['limit']; ?>"/>
            </label>
        </p>
    <?php
    }
}
