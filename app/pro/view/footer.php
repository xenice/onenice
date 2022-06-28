<?php 
if ( !take('fit_elementor') || !function_exists( 'elementor_theme_do_location' ) || !elementor_theme_do_location( 'footer' ) ) {
?>
<footer>
	<div class="container text-center">
	    <?php 
		    // phrase
		    $p = $article->pointer('post_type=phrase&post_status=publish&numberposts=1&orderby=rand');
		    if($p){
		        echo $p->title();
		    }
		?>
		<div class="d-flex justify-content-center">
		    <?php if(take('site_footer')){echo take('site_footer');} else{?>
    		    <span>&copy; 2020 <a href="<?=$option->info['url']?>"><?=$option->info['name']?></a></span>
                <a href="https://www.xenice.com/" target="_blank">theme by onenice</a>
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
<?php import('modal')?>
<?php }?>
<?=$template->footer()?>
</body>
</html>
