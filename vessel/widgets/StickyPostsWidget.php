<?php
namespace vessel\widgets;

/**
 * Xenice_Widget_Sticky_Posts
 *
 * Sticky posts widget class.
 */
class StickyPostsWidget extends PostsWidget {

	/**
	 * Query args
	 *
	 * @var array
	 */
	public $query_args = array(
		'orderby'             => 'modified',
		'post__in'            => '',
		'no_found_rows'       => true,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
	);

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->title                  = __( 'Sticky Posts', 'onenice' );
		$this->query_args['post__in'] = get_option( 'sticky_posts' );
		parent::__construct( 'xenice-sticky-posts', __( 'Xenice Sticky Posts', 'onenice' ) );

	}

}
