<?php
/**
 * Index
 *
 * @package YYThemes
 */

get_header();

if ( !yy_import( 'index' ) ) {?>
<div class="yy-main">
    <div class="yy-group">
        <div class="container">
        	<div class="row">
        		<div class="col-md-8">
        			<?php yy_get( 'enable_slides' ) && get_template_part( 'template-parts/home', 'slides' ); ?>
        			<?php do_action('yythemes_before_recent_posts'); ?>
        			<h3><?php esc_html_e( 'Recent Posts', 'onenice' ); ?></h3>
        			<?php get_template_part( 'template-parts/cards', yy_get( 'list_style' ) ); ?>
        			<ul class="pagination">
        				<?php echo paginate_links(); ?>
        			</ul>
        		</div>
        	<?php get_sidebar(); ?>
        	</div><!-- row -->
        </div>
    </div><!-- yy-group -->
</div><!-- yy-main -->

<?php
}

get_footer();
