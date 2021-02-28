<footer>
	<div class="container text-center">
		<div class="d-flex justify-content-center">
		    <?php if(take('site_footer')){echo take('site_footer');} else{?>
    		    <span>&copy; 2020 <a href="<?=$option->info['url']?>"><?=$option->info['name']?></a></span>
                <a href="https://www.xenice.com/article/onenice" target="_blank">theme by onenice</a>
            <?};?>
            <?php
                $icp = take('site_icp');
                if($icp){
                    echo '<a href="https://beian.miit.gov.cn/" target="_blank">'.$icp.'</a>';
                }
            ?>
        </div>
	</div>
</footer>
<?=$template->footer()?>
</body>
</html>