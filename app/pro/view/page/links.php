<?php 
/**
 * template name: Links Page
 * description: template for onenice theme 
 */

import('header');

?>
<style>
.h1{
    text-align: center;
}

h1{
    font-size: 26px;
    margin-bottom: 20px;
}

.h1-desc{
    font-size:16px;
}

.links{
    background-color: #fff;
    border-bottom: 1px solid #EAEAEA;
    box-shadow: 0 1px 3px #eee;
    padding:20px;
    margin-top:15px;
    margin-bottom:15px;
}

.links .cat{
    display: flex;
    align-items:flex-end;
    margin-bottom: 20px;
}

.links .title{
    font-size: 18px;
    font-weight: 500;
    margin-right:15px;
}
.links .row{
    border-left: 1px solid #f8f8f8;
    border-top: 1px solid #f8f8f8;
}
.links .link{
    padding:0;
    border-right: 1px solid #f8f8f8;
    border-bottom: 1px solid #f8f8f8;
}
.links a{
    padding:15px;
    display: flex;
}
.links a:hover{
    background-color: #f8f8f8;
}
.links img{
    width:40px;
    height:40px;
    margin-right:10px;
}
.links h5{
    font-size: 16px;
    margin-bottom:5px;
    color:#333;
}
.links .desc{
    font-size: 12px;
    color:#999;
}

@media screen and (max-width:767px) {
    body>.container{
        padding-left:0;
        padding-right:0;
    }
    .links{
        padding:15px;
    }
    
    .links img{
        width:30px;
        height:30px;
        margin-right:10px;
    }
    .links h5{
        font-size: 14px;
        margin-bottom:5px;
    }
}
</style>
<div class="container">
    <div class="links h1">
        <h1><?=$page->title()?></h1>
        <div class="h1-desc"><?=$page->content(); ?></div>
    </div>
	
	<?php 
	    function showLinks($cat){
        	$bookmarks = get_bookmarks( ['category'=>$cat->term_id]);
            $str = '<div class="links"><div class="cat"><div class="title">'.$cat->name.'</div><div class="cat-desc">'.$cat->description.'</div></div>';
    	    $str .= '<div class="container"><div class="row">';
            if ( ! empty( $bookmarks ) ) {
                foreach ( $bookmarks as $bookmark ){
                    $img = $bookmark->link_image?:STATIC_URL . '/images/default.png';
                    $str .= '<div class="col-6 col-sm-3 link"><a href="'.$bookmark->link_url.'" target="_blank"><img src="'.$img.'"></img><div><h5>'.$bookmark->link_name.'</h5><div class="desc" >'.$bookmark->link_description.'</div></div></a></div>';
                }
            }
            $str .= '</div></div></div>';
            echo $str;
	    }
	    
		$cats = get_categories(['taxonomy' => 'link_category', 'orderby' => 'category_count', 'order' => 'DESC', 'hierarchical' => 0]);
    	if ( $cats ) {
    		foreach ( (array) $cats as $cat ) {
    		    if($cat->name == '友情链接'){
    		        continue;
    		    }
    		    showLinks($cat);
    		}
    	
    	}

	?>
		
	</div>

</div>

<?php import('footer'); ?>