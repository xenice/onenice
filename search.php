<?php
/**
 * Search
 *
 * @package YYThemes
 */

get_header();

if ( !yy_import( 'search' ) ) {?>
<div class="yy-main">
    <div class="yy-group">
        <div class="breadcrumb">
        	<div class="container">
        		<a class="breadcrumb-item" href="<?php echo esc_html( home_url() ); ?>"><?php esc_html_e( 'Home', 'onenice' ); ?></a>
        		<span class="breadcrumb-item"><?php esc_html_e( 'Search', 'onenice' ); ?></span>
        		<span class="breadcrumb-item active"><?php echo esc_html( $s ); ?></span>
        	</div>
        </div>
    </div><!-- yy-group -->
    <div class="yy-group">
        <div class="main container">
        	<div class="row">
        		<div class="col-md-8">
        		<?php get_template_part( 'template-parts/cards', 'text' ); ?>
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
