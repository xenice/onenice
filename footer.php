<?php
/**
 * Footer
 *
 * @package YYThemes
 */

if ( !yy_import( 'footer' ) ) {
	?>
<div class="yy-footer">
    <div class="yy-group">
    	<div class="container text-center">
    		<div class="d-flex justify-content-center">
    			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <a href="<?php echo esc_attr( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a></span>
    			<?php
    			if ( ! yy_get( 'delete_theme_copyright' ) ) {
    				echo '<a href="https://www.xenice.com/" target="_blank">theme by xenice</a>';
    			}
    			if ( 'zh_CN' === get_locale() ) {
    				$icp = yy_get( 'icp_number' );
    				if ( $icp ) {
    					echo '<a href="https://beian.miit.gov.cn/" target="_blank">' . esc_html( $icp ) . '</a>';
    				}
    			}
    			?>
    		</div>
    	</div>
	</div><!-- yy-group -->
</div><!-- yy-footer -->
<?php } ?>
<?php wp_footer(); ?>
</div><!-- yy-site -->
</body>
</html>
