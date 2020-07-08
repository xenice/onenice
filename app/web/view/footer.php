<footer>
	<div class="container text-center">
	    <?php 
		    // phrase
		    $p = $article->pointer('post_type=phrase&post_status=publish&numberposts=1&orderby=rand');
		    if($p){
		        echo $p->title();
		    }
		?>
		<p>&copy; 2020 
            <a href="<?=$option->info['url']?>"><?=$option->info['name']?></a>&nbsp;&nbsp;
            <a href="https://www.xenice.com/project/onenice" target="_blank">theme by onenice</a> 
        </p>
	</div>
</footer>
<?=$template->footer()?>
</body>
</html>