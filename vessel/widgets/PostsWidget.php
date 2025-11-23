<?php

namespace vessel\widgets;

/**
 * Xenice_Widget_Posts
 *
 * Posts widget basics class.
 */
class PostsWidget extends \WP_Widget {

	/**
	 * Widget title
	 *
	 * @var string
	 */
	public $title = '';

	/**
	 * Constructor
	 *
	 * @param string $id    widget id.
	 * @param string $name  widget name.
	 */
	public function __construct( $id, $name ) {
		$widget_ops = array(
			'classname'                   => 'widget_recent_entries',
			'customize_selective_refresh' => true,
			'show_instance_in_rest'       => true,
		);
		parent::__construct( $id, $name, $widget_ops );
		$this->alt_option_name = 'widget_recent_entries';
	}

	/**
	 * Widget
	 *
	 * @param array $args       An array of relevant information for the widget area.
	 * @param array $instance   An array containing widget settings.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$default_title = $this->title;
		$title         = ( ! empty( $instance['title'] ) ) ? $instance['title'] : $default_title;

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}

		$show_thumbnail = isset( $instance['show_thumbnail'] ) ? $instance['show_thumbnail'] : false;
		$show_date      = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		$query_args                   = $this->query_args;
		$query_args['posts_per_page'] = $number;

		if ( $instance['category'] ) {
			$query_args['cat'] = $instance['category'];
		}

		$r = new \WP_Query(
			/**
			 * Filters the arguments for the Recent Posts widget.
			 *
			 * @since 3.4.0
			 * @since 4.9.0 Added the `$instance` parameter.
			 *
			 * @see WP_Query::get_posts()
			 *
			 * @param array $args     An array of arguments used to retrieve the recent posts.
			 * @param array $instance Array of settings for the current widget.
			 */
			apply_filters(
				'widget_posts_args',
				$query_args,
				$instance
			)
		);

		if ( ! $r->have_posts() ) {
			return;
		}
		?>

		<?php echo '<li class="widget widget_recent_entries">'; ?>

		<?php
		if ( $title ) {
			echo '<h3>' . esc_html( $title ) . '</h3>';
		}

		$format = current_theme_supports( 'html5', 'navigation-widgets' ) ? 'html5' : 'xhtml';

		/** This filter is documented in wp-includes/widgets/class-wp-nav-menu-widget.php */
		$format = apply_filters( 'navigation_widgets_format', $format );

		if ( 'html5' === $format ) {
			// The title may be filtered: Strip out HTML and make sure the aria-label is never empty.
			$title      = trim( wp_strip_all_tags( $title ) );
			$aria_label = $title ? $title : $default_title;
			echo '<nav aria-label="' . esc_attr( $aria_label ) . '">';
		}
		?>

		<?php if ( ! $show_thumbnail ) : ?>
			<ul>
			<?php foreach ( $r->posts as $recent_post ) : ?>
				<?php
				$post_title   = get_the_title( $recent_post->ID );
				$title        = ( ! empty( $post_title ) ) ? $post_title : esc_html__( '(no title)', 'onenice');
				$aria_current = '';

				if ( get_queried_object_id() === $recent_post->ID ) {
					$aria_current = ' aria-current="page"';
				}
				?>
				<li>
					<a href="<?php the_permalink( $recent_post->ID ); ?>"<?php echo esc_html( $aria_current ); ?>><?php echo esc_html( $title ); ?></a>
					<?php if ( $show_date ) : ?>
						<span class="post-date"><?php echo get_the_date( '', $recent_post->ID ); ?></span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<ul class="thumbnail">
			<?php foreach ( $r->posts as $recent_post ) : ?>
				<?php
				$post_title    = get_the_title( $recent_post->ID );
				$title         = ( ! empty( $post_title ) ) ? $post_title : esc_html__( '(no title)', 'onenice');
				$aria_current  = '';
				$thumbnail_url = get_the_post_thumbnail_url( $recent_post->ID );
				if ( ! $thumbnail_url) {
        		    if(yy_get('use_post_first_image_as_thumbnail')){
        		        $thumbnail_url = yy_get_post_first_image(get_post($recent_post->ID));
        		    }
        		}
				if ( ! $thumbnail_url ) {
					$thumbnail_url = apply_filters( 'post_thumbnail_url', $thumbnail_url, null, null );
				}

				if ( get_queried_object_id() === $recent_post->ID ) {
					$aria_current = ' aria-current="page"';
				}

				?>
				<li>
					<a href="<?php the_permalink( $recent_post->ID ); ?>" title="<?php echo esc_html( $title ); ?>">
						<img src="<?php echo esc_html( $thumbnail_url ); ?>" alt="<?php echo esc_html( $title ); ?>"/>
					</a>
					<div class="data">
						<a href="<?php the_permalink( $recent_post->ID ); ?>"<?php echo esc_html( $aria_current ); ?>><?php echo esc_html( $title ); ?></a>
						<?php if ( $show_date ) : ?>
							<span class="post-date"><?php echo esc_html( get_the_date( 'Y-m-d', $recent_post->ID ) ); ?></span>
						<?php endif; ?>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php
		if ( 'html5' === $format ) {
			echo '</nav>';
		}

		echo '</li>';
	}

	/**
	 * Handles updating the settings for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                   = $old_instance;
		$instance['title']          = sanitize_text_field( $new_instance['title'] );
		$instance['category']       = (int) $new_instance['category'];
		$instance['number']         = (int) $new_instance['number'];
		$instance['show_thumbnail'] = isset( $new_instance['show_thumbnail'] ) ? (bool) $new_instance['show_thumbnail'] : false;
		$instance['show_date']      = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		return $instance;
	}

	/**
	 * Outputs the settings form for the Recent Posts widget.
	 *
	 * @since 2.8.0
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title          = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : $this->title;
		$category       = isset( $instance['category'] ) ? absint( $instance['category'] ) : 0;
		$number         = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_thumbnail = isset( $instance['show_thumbnail'] ) ? (bool) $instance['show_thumbnail'] : false;
		$show_date      = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;

		?>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'onenice'); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_html( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Category:', 'onenice' ); ?></label>
			<select class="tiny-text" id="<?php echo esc_html( $this->get_field_id( 'category' ) ); ?>"
				name="<?php echo esc_html( $this->get_field_name( 'category' ) ); ?>">
				<?php
				if ( 0 === $instance['category'] ) {
					echo '<option value ="0" selected>' . esc_html__( 'Default', 'onenice' ) . '</option>';
				} else {
					echo '<option value ="0">' . esc_html__( 'Default', 'onenice' ) . '</option>';
				}
					$arr = get_categories();
				foreach ( $arr as $category ) {
					if ( $category->cat_ID === $instance['category'] ) {
						echo '<option value ="' . esc_html( $category->cat_ID ) . '" selected>' . esc_html( $category->cat_name ) . '</option>';
					} else {
						echo '<option value ="' . esc_html( $category->cat_ID ) . '">' . esc_html( $category->cat_name ) . '</option>';
					}
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'onenice'); ?></label>
			<input class="tiny-text" id="<?php echo esc_html( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_html( $number ); ?>" size="3" />
		</p>
		<p>
			<input class="checkbox" type="checkbox"<?php checked( $show_thumbnail ); ?> id="<?php echo esc_html( $this->get_field_id( 'show_thumbnail' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'show_thumbnail' ) ); ?>" />
			<label for="<?php echo esc_html( $this->get_field_id( 'show_thumbnail' ) ); ?>"><?php esc_html_e( 'Display post thumbnail?', 'onenice' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo esc_html( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'show_date' ) ); ?>" />
			<label for="<?php echo esc_html( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Display post date?', 'onenice'); ?></label>
		</p>
		<?php
	}
}
