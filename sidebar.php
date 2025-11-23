<?php
/**
 * Sidebar
 *
 * @package YYThemes
 */

?>
	<div class="col-md-4 right">
		<ul role="navigation">
		<?php
			/* Widgetized sidebar, if you have the plugin installed. */
			$page_type = 'home';
		if ( is_single() ) {
			$page_type = 'single';
		} elseif ( is_archive() ) {
			$page_type = 'archive';
		}
		if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( $page_type ) ) :
			?>
			<li class="widget widget_tag_cloud" ><h3><?php esc_html_e( 'Tag Cloud', 'onenice' ); ?></h3>
				<div class="tagcloud">
				<?php
				wp_tag_cloud(
					array(
						'number'     => 30,
						'show_count' => 1,
						'taxonomy'   => 'post_tag',
						'orderby'    => 'count',
						'order'      => 'DESC',
					)
				);
				?>
				</div>
			</li>
			<?php if ( is_single() ) : ?>
			<li class="widget widget_recent_entries" ><h3><?php esc_html_e( 'Recent Posts', 'onenice' ); ?></h3>
				<ul>
					<?php
					$r = new WP_Query(
						array(
							'posts_per_page'      => 8,
							'post_status'         => 'publish',
							'ignore_sticky_posts' => true,
						)
					);

					if ( $r->have_posts() ) :
						?>
						<?php foreach ( $r->posts as $recent_post ) : ?>
							<?php
							$post_title   = get_the_title( $recent_post->ID );
							$titl         = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)', 'onenice' );
							$aria_current = '';

							if ( get_queried_object_id() === $recent_post->ID ) {
								$aria_current = ' aria-current="page"';
							}
							?>
						<li>
							<a href="<?php the_permalink( $recent_post->ID ); ?>"<?php echo esc_html( $aria_current ); ?>><?php echo esc_html( $titl ); ?></a>
							<span class="post-date"><?php echo get_the_date( 'Y-m-d', $recent_post->ID ); ?></span>
						</li>
							<?php
					endforeach;
					endif;
					?>
				</ul>
			</li>
			<?php endif; ?>
			<?php if ( is_home() ) : ?>
				<li class="widget" ><h3><?php esc_html_e( 'Archives', 'onenice' ); ?></h3>
					<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
					</ul>
				</li>
			<?php endif; ?>
				<?php
				wp_list_categories(
					array(
						'show_count' => 1,
						'title_li'   => '<h3>' . __( 'Categories', 'onenice' ) . '</h3>',
					)
				);
				?>
		</ul>
		<ul>
			<?php if ( is_home() || is_page() ) { /* If this is the frontpage */ ?>
					<?php wp_list_bookmarks(); ?>
			<?php } ?>
			<?php endif; ?>
		</ul>
	</div>
