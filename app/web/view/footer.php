<footer>
	<div class="container text-center">
	    <?php 
		    // phrase
		    $p = $article->pointer('post_type=phrase&post_status=publish&numberposts=1&orderby=rand');
		    if($p){
		        echo $p->title();
		    }
		?>
		<p>&copy; Copyright 2020 
            <a href="<?=$option->info['url']?>"><?=$option->info['name']?></a> All Rights Reserved. Powered by 
            <a href="https://wordpress.org/" target="_blank">WordPress</a>
        </p>
	</div>
</footer>
<?=$template->footer()?>
</body>
</html>