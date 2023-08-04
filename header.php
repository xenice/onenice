<?php
/**
 * Header
 *
 * @package Onenice
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="<?php echo esc_attr( onenice_get( 'site_icon' ) ); ?>">
<?php
if ( is_singular() ) {
	wp_enqueue_script( 'comment-reply' );}
?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
	?>
	<header class="navbar navbar-expand-md">
		<div class="container">
			<!-- Brand -->
			<?php
			$logo = onenice_get( 'site_logo' );
			if ( $logo ) :
				?>
			<a class="navbar-brand" href="<?php echo esc_attr( home_url() ); ?>"><img class="logo" src="<?php echo esc_attr( $logo ); ?>"?></a>
			<?php else : ?>
			<a class="navbar-brand" href="<?php echo esc_attr( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a>
			<?php endif; ?>
			<!-- Toggler/collapsibe Button -->
			<div class="menu-toggle d-md-none" data-toggle="collapse" data-target="#collapsibleNavbar">
			<i class="fa fa-bars"></i>
			</div>

			<!-- Navbar links -->
			<div class="collapse navbar-collapse d-md-flex justify-content-md-between" id="collapsibleNavbar">
				<?php
					wp_nav_menu(
						array(
							'fallback_cb'     => false,
							'theme_location'  => 'main-menu',
							'container_class' => 'main-menu',
							'menu_class'      => 'navbar-nav',
						)
					);
				?>
				<?php if ( onenice_get( 'show_search' ) ) : ?>
				<div class="d-md-flex justify-content-md-end">
					<form class="search-form" method="get" onsubmit="return check()" action="<?php echo esc_attr( home_url() ); ?>/" >
						<div class="form-group search-form">
							<input id="wd" type="text" name="s" class="form-control keywords" placeholder="<?php esc_attr_e( 'Search', 'onenice' ); ?>" value="<?php echo $s ? esc_attr( $s ) : ''; ?>" />
							<button type="submit" class="rounded submit" onclick="return onenice_check_search()">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</form>
				</div>
				<?php endif; ?>
			</div> 
			<?php
			if ( onenice_get( 'show_login_button' ) ) {
				onenice_login();}
			?>
		</div>
	</header>
	<?php
}
?>
