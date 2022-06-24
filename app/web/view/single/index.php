<?php import('header'); ?>
<?php 
if ( !take('fit_elementor') || ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
?>
<style>
    /* for block of numbers */
.hljs-ln-numbers {
    text-align: center;
    background-color: #fafafa;
    
    vertical-align: top;
    padding-right: 5px;
    /* your custom style here */
}
.hljs-ln{
    border: solid 1px #eee;
    width: 100%;
    padding:10px 0;
    
}

/* for block of code */
.hljs-ln td{
    border-right:solid 1px #eee;;
    border-bottom:none;
    padding-left: 5px;
}

.hljs-ln tr td:first-child{
    width:40px;
}

</style>
<div class="breadcrumb">
	<div class="container">
		<?=$article->breadcrumb()?>
	</div>
</div>
<div class="main container">
	<div class="row">
	  <div class="col-md-8">
            <h1 class="post-title"><a href="<?=$article->url()?>"
                title="<?=$article->title()?>"><?=$article->title()?></a>
            </h1>
            <div class="post-meta">
                <span><?=$article->date()?></span>
    			<span class="card-link md-down-none"><?=$article->user()?></span>
    			<span><?=$article->views()?></span>
    			<a href="<?=$article->url()?>#respond"><?=$article->comments()?></a>
			    <?php if($user->login() && $user->id() == $article->uid()):?>
			    <a href="<?=$article->editUrl()?>#respond"><?=_t('Edit')?></a>
                <?php endif;?>
            </div>
            <?php ad('single_top','','margin-top:10px');?>
    		<div class="post-content"><?=$article->content(); ?></div>
            <div class="post-tags"><?=($str=$article->tags())?_t('Tags:') . ' ' . $str:''?></div>
            <div class="share-component" style="text-align:center;margin-top:20px" data-disabled="tencent,linkedin,diandian,google,twitter,facebook"></div>
            <div class="adjacent d-flex justify-content-between">
                <span class="previous"><?=$article->previousLink(_t('Previous Page<br/>'), true)?></span>
                <span class="next"><?=$article->nextLink(_t('Next Page<br/>'), true)?></span>
            </div>
            <?php ad('single_bottom','','margin-top:10px');?>
            <?php import('single/related'); ?>
            <?php import('comments'); ?>
	  </div>
    <?php import('sidebar'); ?>
	</div><!-- row -->
</div>
<?php }?>
<?php import('footer'); ?>