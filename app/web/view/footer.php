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
                <a href="https://www.xenice.com/project/onenice" target="_blank">theme by onenice</a>
            <?};?>
        </div>
	</div>
</footer>
<?=$template->footer()?>
</body>
</html>