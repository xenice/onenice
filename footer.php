<?php 
if (!function_exists( 'elementor_theme_do_location' ) || elementor_theme_do_location( 'footer' ) ) {
?>
<footer>
	<div class="container text-center">
		<div class="d-flex justify-content-center">
		    <span>&copy; <?=date("Y")?> <a href="<?=home_url()?>"><?php bloginfo('name');?></a></span>
            <?php
                if(!onenice_get('delete_theme_copyright')){
                    echo '<a href="https://www.xenice.com/article/onenice" target="_blank">theme by onenice</a>';
                    
                }
                if(get_locale() == 'zh_CN'){
                    if($icp = onenice_get('icp_number')){
                        echo '<a href="https://beian.miit.gov.cn/" target="_blank">'.$icp.'</a>';
                    }
                }
            ?>
        </div>
	</div>
</footer>
<?php }?>
<?php wp_footer(); ?>
</body>
</html>