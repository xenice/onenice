<?php
if(!defined('ABSPATH')) exit;

?>
<style>
.yy-main .hot{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    margin-bottom: 15px;
}

.yy-main .hot ul{
    padding:0;
    margin:0;
    width:48%;
}

.yy-main .hot li{
    list-style: none;
    margin:0;
    padding:5px 0;
    display: flex;
    justify-content: space-between;
}

.yy-main .hot .hot-title{
    overflow: hidden;
    text-overflow:ellipsis;
    white-space: nowrap;
}

.yy-main .hot .hot-date{
    color:#999;
    font-size: 13px;
    width:100px;
    text-align: right;
    white-space: nowrap;
}

.c-index {
    display: inline-block;
    padding: 1px 0;
    color: #fff;
    width: 14px;
    line-height: 100%;
    font-size: 13px;
    text-align: center;
    background-color: #8eb9f5;
}
.c-gap-icon-right-small {
    margin-right: 6px;
}
.c-index-hot, .c-index-hot1 {
    background-color: #f54545;
}
.c-index-hot2 {
        background-color: #ff8547;
}
.c-index-hot3 {
    background-color: #ffac38;
}

@media screen and (max-width:767px) {
    .yy-main .hot{
        flex-direction: column;
    }
    .yy-main .hot ul{
        width:100%;
    }
    .yy-main .hot .hot-date{
        width:120px;
    }
}
</style>
<?php
    $args  = [
        'orderby'             => 'modified',
        'post__in' => get_option('sticky_posts'),
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'showposts'           => 8
    ];
    $arr = [];
    $i = 0;
    $r = new WP_Query($args);
    foreach ( $r->posts as $recent_post ){
        $i++;
        $arr[] = '<li><div class="hot-title"><span class="c-index c-index-hot'.$i.' c-gap-icon-right-small">'.$i.'</span><a href="'.get_the_permalink($recent_post->ID).'" >'.get_the_title( $recent_post->ID ).'</a></div><div class="hot-date">'.get_the_date('Y-m-d',$recent_post->ID).'</div></li>';
        
    }
    $str1 = '';
    $str2 = '';
    if($i){
        $j = ceil($i/2);
        $i = 0;
        foreach($arr as $value){
            $i++;
            if($j>=$i){
                $str1 .= $value;
            }
            else{
                $str2 .= $value;
            }
        }
        echo '<h3>'.esc_html__('Sticky Posts', 'onenice').'</h3>';
        echo '<div class="card hot"><ul>' . $str1 . '</ul><ul>' . $str2 . '</ul></div>';
    }
    
?>
