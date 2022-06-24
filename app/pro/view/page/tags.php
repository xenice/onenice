<?php 
/**
 * template name: Tags Page
 * description: template for onenice theme 
 */

import('header');

?>
<style>
.tag-title{
    font-size:16px;
    margin:10px 0;
}
.tags{
    display: flex;
    flex-wrap: wrap;
}
.tags span{
    width:100px;
    text-align: center;
    margin:6px;
    padding:5px;
    font-size:13px;
    background-color: #fff;
    border-radius: 5px;
}
.tags span small{
    color:#ccc;
}
</style>
<div class="container">
    <h1 class="tag-title">
        <a href="<?=$page->url()?>" title="<?=$page->title()?>"><?=$page->title()?></a>
    </h1>
	<div class="tags">
		<?php 
			$tags_count = 120;
			$tagslist = get_tags('orderby=count&order=DESC&number='.$tags_count);
			foreach($tagslist as $tag) {
				echo '<span><a class="name" href="'.get_tag_link($tag).'">'. $tag->name .'</a><small>&times;'. $tag->count .'</small></span>'; 
			} 
	
		?>
	</div>

</div>

<?php import('footer'); ?>