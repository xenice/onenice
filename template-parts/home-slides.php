<?php
/**
 * Home slides
 *
 * @package Onenice
 */

?>

<style>
.carousel-caption{
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	bottom: 10px;
	top:10px;
}


@media screen and (min-width:768px){
	.carousel-caption h3{
		margin:15px;
		font-size:1.25rem;
	}
	.carousel-caption p{
		color:#eee;
	}
}
@media screen and (max-width:767px) {
	.carousel-caption h3{
		margin:0;
	}
}
</style>
<div id="demo" class="carousel slide" data-ride="carousel">
	<ul class="carousel-indicators">
		<?php
		for ( $i = 0;$i < 3;$i++ ) {
			$j   = $i + 1;
			$src = onenice_get( 'slides_image_' . $j ) ?? '';

			if ( empty( $src ) ) {
				continue;
			}

			if ( 0 === $i ) {
				?>
				<li data-target="#demo" data-slide-to="0" class="active"></li>
				<?php
			} else {
				?>
				<li data-target="#demo" data-slide-to="<?php echo esc_html( $i ); ?>"></li>
			<?php } ?>
		<?php } ?>
	</ul>
	<div class="carousel-inner rounded">
		<?php
		for ( $i = 0;$i < 3;$i++ ) {
			$j    = $i + 1;
			$src  = onenice_get( 'slides_image_' . $j ) ?? '';
			$titl = onenice_get( 'slides_title_' . $j ) ?? '';
			$url  = onenice_get( 'slides_url_' . $j ) ?? '';
			$desc = onenice_get( 'slides_description_' . $j ) ?? '';

			if ( empty( $src ) ) {
				continue;
			}

			if ( 0 === $i ) {
				?>
				<div class="carousel-item active">
				<?php
			} else {
				?>
				<div class="carousel-item">
		<?php } ?>
			<a href="<?php echo esc_html( $url ); ?>" title="<?php echo esc_html( $titl ); ?>" target="blank">
			<img src="<?php echo esc_html( $src ); ?>" alt="<?php echo esc_html( $titl ); ?>" />
			<?php if ( $desc ) { ?>
				<div class="carousel-caption"><h3><?php echo esc_html( $titl ); ?></h3><p class="md-down-none"><?php echo esc_html( $desc ); ?></p></div>
			<?php } ?>
			</a></div>
		<?php } ?>
	</div>
	<a class="carousel-control-prev" href="#demo" data-slide="prev">
		<span class="carousel-control-prev-icon"></span>
	</a>
	<a class="carousel-control-next" href="#demo" data-slide="next">
		<span class="carousel-control-next-icon"></span>
	</a>
</div>
