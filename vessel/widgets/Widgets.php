<?php
namespace vessel\widgets;

class Widgets {
    /**
	 * Constructor
	 */
	public function __construct() {

		add_action(
			'widgets_init',
			function() {
				register_widget( 'vessel\widgets\RecentPostsWidget');
				register_widget( 'vessel\widgets\HotPostsWidget');
				register_widget( 'vessel\widgets\StickyPostsWidget');
			}
		);

		// Add posts views.
		add_filter(
			'the_content',
			function( $content ) {
				if ( is_single() ) {
					global $post;
					$views = get_post_meta( $post->ID, 'xenice_views', true );
					if ( $views && is_numeric( $views ) ) {
						$views ++;
					} else {
						$views = 1;
					}
					update_post_meta( $post->ID, 'xenice_views', $views );
				}
				return $content;
			}
		);

	}
	
}
