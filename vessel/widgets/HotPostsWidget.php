<?php
namespace vessel\widgets;

/**
 * Xenice_Widget_Hot_Posts
 *
 * Hot posts widget class.
 */
class HotPostsWidget extends PostsWidget {

	/**
	 * Query args
	 *
	 * @var array
	 */
	public $query_args = array(
		'meta_key'            => 'xenice_views',
		'orderby'             => 'meta_value_num',
		'no_found_rows'       => true,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
	);

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->title = __( 'Hot Posts', 'onenice' );
		parent::__construct( 'xenice-hot-posts', __( 'Xenice Hot Posts', 'onenice' ) );

	}

}
