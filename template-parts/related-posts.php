<?php
/**
 * Related posts
 *
 * @package YYThemes
 */

?>
<div class="related">
	<h3><?php esc_html_e( 'Related Posts', 'onenice' ); ?></h3>
	<ul>
		<?php
			$r = new WP_Query(
				apply_filters(
					'yy_related_posts_args',
					array(
						'tax_query'      => array(
							array(
								'taxonomy' => 'category',
								'terms'    => wp_get_post_categories( $post->ID ),
							),
						),
						'posts_per_page' => 8,
						'post__not_in'   => array( $post->ID ),
						'post_status'    => 'publish',
					)
				)
			);

			if ( ! $r->have_posts() ) {
				echo '<li>' . esc_html__( 'None ..', 'onenice' ) . '<li>';
			} else {
				foreach ( $r->posts as $recent_post ) :
					$post_title = get_the_title( $recent_post->ID );
					$titl       = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)', 'onenice' );
					?>
				<li>
					<i class="fa fa-chevron-right"></i>
					<a href="<?php echo esc_html( the_permalink( $recent_post->ID ) ); ?>" title="<?php echo esc_html( $titl ); ?>"><?php echo esc_html( $titl ); ?></a>
				</li>
			<?php endforeach; ?>
			<?php } ?>
	</ul>
</div>
