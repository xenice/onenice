<?php
/**
 * Text cards
 *
 * @package YYThemes
 */

?>
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
		<div class="card">
			<div class="card-body">
			<h4 class="card-title">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
			</h4>
					<?php if ( yy_get( 'archive_show_date' ) ) : ?>
				<span class="card-link"><?php echo esc_html( get_the_date('Y-m-d') ); ?></span>
			<?php endif; ?>
					<?php if ( yy_get( 'archive_show_author' ) ) : ?>
				<span class="card-link md-down-none"><?php the_author(); ?></span>
			<?php endif; ?>
			<p class="card-text"><?php the_excerpt(); ?></p>
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
