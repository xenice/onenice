<?php 
if ( !take('fit_elementor') || function_exists( 'elementor_theme_do_location' ) || elementor_theme_do_location( 'footer' ) ) {
?>
<footer>
	<div class="container text-center">
		<div class="d-flex justify-content-center">
		    <?php if(take('site_footer')){echo take('site_footer');} else{?>
    		    <span>&copy; <?=date("Y")?> <a href="<?=$option->info['url']?>"><?=$option->info['name']?></a></span>
                <a href="https://www.xenice.com/article/onenice" target="_blank">theme by onenice</a>
            <?};?>
            <?php
                $icp = take('enable_site_icp');
                if($icp){
                    echo '<a href="https://beian.miit.gov.cn/" target="_blank">'.take('site_icp').'</a>';
                }
            ?>
        </div>
	</div>
</footer>
<?php }?>
<?=$template->footer()?>
</body>
</html>