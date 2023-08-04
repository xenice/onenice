<?php
/**
 * Footer
 *
 * @package Onenice
 */

if ( ! function_exists( 'elementor_theme_do_location' ) || elementor_theme_do_location( 'footer' ) ) {
	?>
<footer>
	<div class="container text-center">
		<div class="d-flex justify-content-center">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <a href="<?php echo esc_attr( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a></span>
			<?php
			if ( ! onenice_get( 'delete_theme_copyright' ) ) {
				echo '<a href="https://www.xenice.com/article/onenice" target="_blank">theme by onenice</a>';
			}
			if ( 'zh_CN' === get_locale() ) {
				$qq = onenice_get( 'service_qq' );
				if ( $qq ) {
					echo '<a target="_blank"  href="http://wpa.qq.com/msgrd?v=3&uin=' . esc_html( $qq ) . '&site=qq&menu=yes">QQ' . esc_html( $qq ) . '</i></a>';
				}
				$icp = onenice_get( 'icp_number' );
				if ( $icp ) {
					echo '<a href="https://beian.miit.gov.cn/" target="_blank">' . esc_html( $icp ) . '</a>';
				}
			}
			?>
		</div>
	</div>
</footer>
<?php } ?>
<?php wp_footer(); ?>
</body>
</html>
