<?php
/**
 * Thumbnail cards
 *
 * @package YYThemes
 */

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		$thumbnail_url = get_the_post_thumbnail_url();
		if ( ! $thumbnail_url) {
		    if(yy_get('use_post_first_image_as_thumbnail')){
		        $thumbnail_url = yy_get_post_first_image(get_post());
		    }
		}
		if ( ! $thumbnail_url ) {
			$thumbnail_url = yy_get( 'site_thumbnail' );
		}
		?>
<div class="card">
	<div class="card-body d-flex">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<img class="lazyload" src="<?php echo esc_attr( yy_get( 'site_loading_image' ) ); ?>" data-src="<?php echo esc_attr( $thumbnail_url ); ?>" alt="<?php the_title(); ?>" />
		</a>
		<div class="data">
			<h4 class="card-title">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
			</h4>
				<?php if ( yy_get( 'archive_show_date' ) ) : ?>
				<span class="card-link"><?php echo esc_html( get_the_date('Y-m-d') ); ?></span>
			<?php endif; ?>
				<?php if ( yy_get( 'archive_show_author' ) ) : ?>
				<span class="card-link md-down-none"><?php the_author(); ?></span>
			<?php endif; ?>
			<p class="card-text md-down-none"><?php the_excerpt(); ?></p>
		</div>
	</div>
</div>
	<?php endwhile; ?>

<?php else : ?>
<div class="card">
	<div class="card-body">
		<p class="card-text"><?php esc_html_e( 'No articles.', 'onenice' ); ?></p>
	</div>
</div>
<?php endif; ?>
