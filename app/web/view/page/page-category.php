<?php
/*
Template Name: Category 分类
*/
get_header(); ?>

    <div id="primary" class="full-page">
        <div class="catDiv">
            <div class="areaName"><span class="fa fa-paperclip" style="color:#666"></span>
            Categories
            </div>
            <div class="tab-categories">
                    <?php wp_list_categories( '&title_li=' ); ?>
            </div>
            <br>
            <div class="areaName"><span class="fa fa-tags" style="color:#666"></span>
            Tags
            </div>
            <div class="tab-tags">
                <?php wp_tag_cloud( array(
                    'unit'     => 'px',
                    'smallest' => 12,
                    'largest'  => 12,
                    'number'   => mutheme_settings( 'tag_number' ),
                    'format'   => 'flat',
                    'orderby'  => 'count',
                    'order'    => 'DESC'
                ) ); ?>
            </div>
        </div>
    </div>
    
    <style>
        .catDiv{
            margin: 0 auto;
            width:80%;
            height:80%;
            text-align: left;
            background-color:#fff;
        }

        .areaName{
            display: inline-block;
            color : #36c;
            font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;
            font-size: 2em;
        }
    </style>
<?php get_footer(); ?>