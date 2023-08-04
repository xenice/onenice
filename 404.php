<?php
/**
 * Not found
 *
 * @package Onenice
 */

get_header();

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {?>
	<style>
	.errorDiv{
		margin: 0 auto;
		text-align: center;
	}
	.main{
		padding-top:60px;
	}
	</style>
	<div id="primary" class="main full-page">
		<div class="errorDiv">
			<p><h1><?php echo esc_html__( 'Not Found', 'onenice' ); ?></h1></p>
			<p><?php echo esc_html__( 'Sorry, the page you visited has migrated or does not exist', 'onenice' ); ?></p>
			<p><span id="timedown" style="font-size:2em;color:#EB4444"></span> s </p>
		</div>
	</div>
	<script type="text/javascript">  
	var t = 15;  
	function showTime(){  
		t -= 1;  
		document.getElementById('timedown').innerHTML= t;  
		if(t==0){  
			location.href='<?php echo esc_html( home_url() ); ?>';  
		}  
		setTimeout("showTime()",1000);  
	}  

	showTime();  
	</script>  

	<?php
}

get_footer();
