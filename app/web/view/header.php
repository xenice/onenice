<!DOCTYPE html>
<html>
<head>
    <title><?=_t($title)?></title>
    <meta name="keywords" content="<?=$keywords??''?>"/>
    <meta name="description" content="<?=$description??''?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta name="baidu-site-verification" content="Qbrs7uy60v" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <link rel="shortcut icon" href="<?=take('site_icon')?>">
    <?=$template->head()?>
</head>
<body>
<?php 
if ( !take('fit_elementor') || ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
?>
    <header class="navbar navbar-expand-md">
    	<div class="container">
    		<!-- Brand -->
    		<a class="navbar-brand" href="<?=$option->info['url']?>"><?=$template->logo()?></a>
    
    		<!-- Toggler/collapsibe Button -->
    		<div class="menu-toggle d-md-none" data-toggle="collapse" data-target="#collapsibleNavbar">
    		<i class="fa fa-bars"></i>
    		</div>
    
    		<!-- Navbar links -->
    		<div class="collapse navbar-collapse d-md-flex justify-content-md-between" id="collapsibleNavbar">
    		     <?=$template->menu([
                    'theme_location'  => 'top-menu',
                    'container_class' => 'top-menu',
                    'menu_class'   => 'navbar-nav'
                ]); ?>
                <div class="d-md-flex justify-content-md-end">
    				<form class="search-form" method="get" onsubmit="return check()" action="<?=$option->info['url']?>/" >
    				    <div class="form-group search-form">
            				<input id="wd" type="text" name="s" class="form-control keywords" placeholder="<?=_t('Search keyword')?>" value="<?=$s??''?>" />
            				<button type="submit" class="rounded submit">
            					<i class="fa fa-search"></i>
            				</button>
        				</div>
    				</form>
    			</div>
    		</div> 
            <?php import('login') ?>
    	</div>
    </header>
<?php
$template->js .=<<<js
function check(){
    if($('#wd').val() == ''){
        return false;
    }
    return true;
}
js;
}
?>