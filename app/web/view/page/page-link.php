<?php
/*
Template Name: Friends 友情链接
*/
get_header(); ?>
    <div  id="primary" class="full-page">
    <div class="linkDiv">
        <?php
            $bookmarks = get_bookmarks();
            if ( !empty($bookmarks) ){
                echo '<ul class="link-content clearfix">';
                foreach ($bookmarks as $bookmark) {
                    echo '<li><a href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" >'. get_avatar($bookmark->link_notes,80) . '<span class="sitename">'. $bookmark->link_name .'</span></a></li>';
                }
                echo '</ul>';
            }
        ?>
    </div>
    </div>
    <!-- #primary -->
    <style>
    .linkDiv{
        margin: 0 auto;
        width:80%;
        height:80%;
        text-align: center;
    }

    .sitename{
        color : #39f;
        font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;
        font-size: 14px;
    }
    </style>
<?php get_footer(); ?>
