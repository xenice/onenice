<?php
namespace app\web\widget;

class Links extends \WP_Widget
{
    public function __construct()
    {
        $widget_ops = array( 'description' => _t('Xenice Links') );
        parent::__construct( 'xenice_links', _t('Links'), $widget_ops );
    }

    public function widget( $args, $instance ) {
        extract( $args );
        $limit = strip_tags( $instance['limit'] );
        $limit = $limit ? $limit : 10;
        ?>
        <div class="right-group">
            <h3><?=_t('Links'); ?></h3>
            <ul class="list links">
                <?php $bookmarks = get_bookmarks( ['limit'=>$limit,'category_name'=>'友情链接'] );
                if ( ! empty( $bookmarks ) ) {
                    foreach ( $bookmarks as $bookmark ) {
                    ?>
                        <li>
                            <a href="<?php echo $bookmark->link_url; ?>" target="_blank"
                               title="<?php echo $bookmark->link_description != '' ? $bookmark->link_description : $bookmark->link_name; ?>"><?php echo $bookmark->link_name; ?></a>
                        </li>
                    <?php
                    }
                } ?></ul>
            </ul>
        </div>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        if ( ! isset( $new_instance['submit'] ) ) {
            return false;
        }
        $instance          = $old_instance;
        $instance['limit'] = strip_tags( $new_instance['limit'] );

        return $instance;
    }

    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'limit' => 10 ) );
        $limit    = strip_tags( $instance['limit'] );
        ?>

        <p><label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?=_t('Links Count')?> &nbsp; <input
                    id="<?php echo $this->get_field_id( 'limit' ); ?>"
                    name="<?php echo $this->get_field_name( 'limit' ); ?>" type="text"
                    value="<?php echo $limit; ?>"/></label></p>
        <input type="hidden" id="<?php echo $this->get_field_id( 'submit' ); ?>"
            name="<?php echo $this->get_field_name( 'submit' ); ?>" value="1"/>
    <?php
    }
}