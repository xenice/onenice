<?php
namespace app\web\widget;

use xenice\theme\Theme;

class Advertise extends \WP_Widget
{
    public function __construct()
    {
        $widget_ops = array( 'description' => _t('Xenice Advertise') );
        parent::__construct( 'xenice_advertise', _t('Advertise'), $widget_ops );
    }

    function widget( $args, $instance )
    {
        extract( $args );
        ?>
        <div class="right-group text-center md-down-none">
            <?=$instance['code']?>
        </div>
    <?php
    }

    function form( $instance )
    {
        $instance = wp_parse_args( (array) $instance, ['code'=>'']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'code' ); ?>"><?=_t('AD code:')?>
                <textarea class="widefat" rows="10"
                    id="<?php echo $this->get_field_id( 'code' ); ?>"
                    name="<?php echo $this->get_field_name( 'code' ); ?>"
                    ><?php echo $instance['code']; ?></textarea>
            </label>
        </p>
    <?php
    }
}
