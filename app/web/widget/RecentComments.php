<?php
namespace app\web\widget;

use xenice\theme\Theme;

class RecentComments extends \WP_Widget
{
    public function __construct()
    {
        $widget_ops = array( 'description' => _t('Xenice Recent Comments') );
        parent::__construct( 'xenice_recent_comments', _t('Recent Comments'), $widget_ops );
    }

    public function widget( $args, $instance )
    {
        extract( $args );
        $limit = strip_tags( $instance['limit'] );
        $limit = $limit ? $limit : 5;
        ?>
        <div class="right-group right-comments">
            <h3><?=_t( 'Recent Comments'); ?></h3>
            <ul>
                <?php
                $args = "number={$limit}&status=approve&type=comment";
                Theme::use('comment')->query($args);
                while($p = Theme::use('comment')->pointer($args)):?>
                    <li class="d-flex justify-content-between">
                        <span><?=$p->avatar()?> <?=$p->author()?></span>
                        <span><?=$p->date()?></span>
                    </li>
                    <li>
                        <a href="<?=$p->articleLink()?>#comment-<?=$p->id()?>">
                            <?=$p->content()?>
                        </a>
                    </li>
                <?php endwhile;?>
            </ul>
        </div>
    <?php
    }

    public function update( $new_instance, $old_instance )
    {
        if ( ! isset( $new_instance['submit'] ) ) {
            return false;
        }
        $instance          = $old_instance;
        $instance['limit'] = strip_tags( $new_instance['limit'] );

        return $instance;
    }

    function form( $instance )
    {
        $instance = wp_parse_args( (array) $instance, ['limit' => 8] );
        $limit    = strip_tags( $instance['limit'] );
        ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?=_t('Comment Count:')?>
                <input class="tiny-text" type="number" step="1"
                    id="<?php echo $this->get_field_id( 'limit' ); ?>"
                    name="<?php echo $this->get_field_name( 'limit' ); ?>"
                    value="<?php echo $limit; ?>"/>
            </label>
        </p>
        <input type="hidden" id="<?php echo $this->get_field_id( 'submit' ); ?>"
            name="<?php echo $this->get_field_name( 'submit' ); ?>" value="1"/>
    <?php
    }
}