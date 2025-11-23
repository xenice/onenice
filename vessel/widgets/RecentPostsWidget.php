<?php
namespace vessel\widgets;

/**
 * Xenice_Widget_Recent_Posts
 *
 * Recent posts widget class.
 */
class RecentPostsWidget extends PostsWidget {

	/**
	 * Query args
	 *
	 * @var array
	 */
	public $query_args = array(
		'no_found_rows'       => true,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
	);

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->title = __( 'Recent Posts', 'onenice' );
		parent::__construct( 'xenice-recent-posts', __( 'Xenice Recent Posts', 'onenice' ) );

	}

}
