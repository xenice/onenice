<?php
/**
 * Comments
 *
 * @package Onenice
 */

// Do not delete these lines.
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' === basename( sanitize_text_field( wp_unslash( $_SERVER['SCRIPT_FILENAME'] ) ) ) ) {
	esc_html_e( 'Please do not load this page directly. Thanks!', 'onenice' );
	exit;
}

if ( post_password_required() ) { ?>
		<p class="nocomments"><?php esc_html_e( 'This post is password protected. Enter the password to view comments.', 'onenice' ); ?></p>
	<?php
	exit;
}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	<div id="comments">
		<?php
		// translators: %s is the comments number.
		echo esc_html( sprintf( __( 'Comments (%s)', 'onenice' ), get_comments_number() ) );
		?>
	</div>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link(); ?></div>
		<div class="alignright"><?php next_comments_link(); ?></div>
	</div>

	<ol class="commentlist">
	<?php wp_list_comments(); ?>
	</ol>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link(); ?></div>
		<div class="alignright"><?php next_comments_link(); ?></div>
	</div>
<?php else : // This is displayed if there are no comments so far. ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	<?php else : // Comments are closed. ?>
		<!-- If comments are closed. -->
		<p class="nocomments"></p>

	<?php endif; ?>
<?php endif; ?>

<?php comment_form(); ?>
