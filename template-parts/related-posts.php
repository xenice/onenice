<div class="related">
    <h3><?=__('Related Posts', 'onenice')?></h3>
    <ul>
        <?php 
            $r = new WP_Query(
			apply_filters(
				'onenice_related_posts_args',
				array(
				    'tax_query'           => [['taxonomy' =>'category', 'terms' => wp_get_post_categories($post->ID)]],
				    //'category__in'        => wp_get_post_categories($post->ID), 
					'posts_per_page'      => 8,
					'post__not_in'        => [$post->ID],
					//'no_found_rows'       => true,
					'post_status'         => 'publish',
					//'ignore_sticky_posts' => true,
				)
			)
		);

		if ( ! $r->have_posts() ) {
			echo '<li>'.__('None ..', 'onenice').'<li>';
		}
		else{
		    foreach ( $r->posts as $recent_post ) : 
		        $post_title   = get_the_title( $recent_post->ID );
			    $title        = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)' );
		    ?>
        		<li>
                    <i class="fa fa-chevron-right"></i>
                    <a href="<?=the_permalink( $recent_post->ID )?>" title="<?=$title?>"><?=$title?></a>
                </li>
                
				
			<?php endforeach; ?>
		    
		<?php }?>
        
    </ul>
</div>