<?php 
/**
 * template name: Archives Page
 * description: template for onenice theme 
 */

import('header');

?>
<style>

.archives ul{
    padding-left:15px;
}

.archives li{
    list-style-type: none;
    line-height: 2;
}
.archives li .badge{
    display: inline-block;
    width:40px;
    margin-right: 8px;
}

@media screen and (max-width:767px) {
    .archives li{
        list-style-type: none;
        line-height: 2;
    }
}

</style>
<div class="breadcrumb">
	<div class="container">
	    <?=$page->breadcrumb()?>
	</div>
</div>
<div class="main container">

	<div class="archives">
            <?php
            $previous_year = $year = 0;
            $previous_month = $month = 0;
            $ul_open = false;

            while($p = $article->first('posts_per_page=-1&orderby=post_date&order=DESC')):
                $date = $p->row('post_date');
                $year = mysql2date('Y', $date);
                $month = mysql2date('n', $date);
                $day = mysql2date('j', $date);
                
                if($year != $previous_year || $month != $previous_month) :
                    if($ul_open == true) : 
                        echo '</ul></div>';
                    endif;
             
                    echo '<div class="card"><h3>'; echo mysql2date('F Y', $date); echo '</h3>';
                    echo '<ul class="archives-list">';
                    $ul_open = true;
             
                endif;
             
                $previous_year = $year; $previous_month = $month;

            ?>
                <li>
                    <span class="badge badge-custom"><?=$day; ?>日</span>
                    <a href="<?=$p->url(); ?>"><?=$p->title(); ?></a>
                </li>
            <?php endwhile; ?>
            </ul>
        </div>
	</div>
</div>


<?php

import('footer'); 