<?php
/**
 * Home slides
 *
 * @package YYThemes
 */

?>

<div id="demo" class="carousel slide" data-ride="carousel">
	<ul class="carousel-indicators">
		<?php
		$slides = yy_get( 'slides');
		if($slides){
		    $i = 0;
    		foreach ($slides as $slide) {
    			$src  = $slide['src']??'';
    
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
			    <?php }
			    $i ++;
    		}
		} ?>
	</ul>
	<div class="carousel-inner rounded">
		<?php
		if($slides){
		    $i = 0;
    		foreach ($slides as $slide) {
    		    
    			$i ++;
    			$src  = $slide['src']??'';
    			$titl = $slide['title']??'';
    			$url  = $slide['url']??'';
    			$desc = $slide['desc']??'';
    
    			if ( empty( $src ) ) {
    				continue;
    			}
    			if ( 1 === $i ) {
    				?>
    				<div class="carousel-item active">
    				<?php
    			} else {
    				?>
    				<div class="carousel-item">
            		    <?php } ?>
            			<a href="<?php echo esc_html( $url ); ?>" title="<?php echo esc_html( $titl ); ?>" target="blank">
            			<img src="<?php echo esc_html( $src ); ?>" alt="<?php echo esc_html( $titl ); ?>" />
            			<div class="slide-shade"></div>
            			<?php if ( $desc ) { ?>
            				<div class="carousel-caption"><h3><?php echo esc_html( $titl ); ?></h3><p class="md-down-none"><?php echo esc_html( $desc ); ?></p></div>
            			<?php } ?>
            			</a>
        			</div>
    		<?php } ?>
    	<?php } ?>
	</div>
	<a class="carousel-control-prev" href="#demo" data-slide="prev">
		<span class="carousel-control-prev-icon"></span>
	</a>
	<a class="carousel-control-next" href="#demo" data-slide="next">
		<span class="carousel-control-next-icon"></span>
	</a>
</div>
