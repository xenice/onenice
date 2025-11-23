<?php
/**
 * Archive
 *
 * @package YYThemes
 */

get_header();

if ( !yy_import( 'archive' ) ) {?>
<div class="yy-main">
    <div class="yy-group">
        <div class="breadcrumb">
        	<div class="container">
        		<?php yy_breadcrumb(); ?>
        	</div>
        </div>
    </div><!-- yy-group -->
    <div class="yy-group">
        <div class="main container">
        	<div class="row">
        		<div class="col-md-8">
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
