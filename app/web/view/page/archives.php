<?php
/*
Template Name: Archive 归档
*/
get_header(); ?>
    <div id="primary" class="full-page">
        <div class="post-content">
            <?php $the_query = new WP_Query( 'posts_per_page=-1&ignore_sticky_posts=1' ); //update: 加上忽略置顶文章
            $year=0; $mon=0; $i=0; $j=0;
            $all = array();
            $output = '<div id="archives">';
            while ( $the_query->have_posts() ) : $the_query->the_post();
                $year_tmp = get_the_time('Y');
                $mon_tmp = get_the_time('n');
                //var_dump($year_tmp);
                $y=$year; $m=$mon;
                if ($mon != $mon_tmp && $mon > 0) $output .= '</div></div>';
                if ($year != $year_tmp) {
                    $year = $year_tmp;
                    $all[$year] = array();
                }

                if ($mon != $mon_tmp) {
                    $mon = $mon_tmp;
                    array_push($all[$year], $mon);
                    $output .= "<div class='archive-title' id='arti-$year-$mon'><h3>$year-$mon</h3><div class='archives archives-$mon' data-date='$year-$mon'>"; //输出月份
                }
                $output .= '<div class="brick"><a href="'.get_permalink() .'"><span class="time">'.get_the_time('n-d').'</span>'.get_the_title() .'<em>('. get_comments_number('0', '1', '%') .')</em></a></div>'; //输出文章日期和标题
            endwhile;
            wp_reset_postdata();
            $output .= '</div></div></div>';
            echo $output;

            $html = "";
            $year_now = date("Y");
            foreach($all as $key => $value){
                $html .= "<li class='year' id='year-$key'><a href='#' class='year-toogle' id='yeto-$key'>$key</a><ul class='monthall'>";
                for($i=12; $i>0; $i--){
                    if($key == $year_now && $i > $value[0]) continue;
                    $html .= in_array($i, $value) ? ("<li class='month monthed' id='mont-$key-$i'>$i</li>") : "";
                }
                $html .= "</ul></li>";
            }
            ?>
        </div>
        <div id="archive-nav">
            <ul class="archive-nav"><?php echo $html;?></ul>
        </div>
    </div>
    <style>
        .post-content {
            float: right;
            width: 550px;
        }
        #archive-nav {
            float: left;
            width: 50px
        }

        .archive-nav {
            display: block;
            position: fixed;
            background: #f9f9f9;
            width: 40px;
            text-align: center
        }

        .year {
            border-top: 1px solid #ddd
        }

        .month {
            color: #ccc;
            padding: 5px;
            cursor: pointer;
            background: #f9f9f9
        }

        .month.monthed {
            color: #777
        }

        .month.selected,.month:hover {
            background: #f2f2f2
        }

        .monthall {
            display: none
        }

        .year.selected .monthall {
            display: block
        }

        .year-toogle {
            display: block;
            padding: 5px;
            text-decoration: none;
            background: #eee;
            color: #333;
            font-weight: bold
        }

        .archive-title {
            padding-bottom: 40px
        }

        .brick {
            margin-bottom: 10px
        }

        .archives a {
            position: relative;
            display: block;
            padding: 10px;
            background-color: #f9f9f9;
            color: #333;
            font-style: normal;
            line-height: 18px
        }

        .time {
            color: #888;
            padding-right: 10px;
        }

        .archives a:hover {
            background: #eee
        }

        #archives h3 {
            padding-bottom: 10px;
        }

        .brick em {
            color: #aaa;
            padding-left: 10px;
        }

    </style>

<?php get_footer(); ?>