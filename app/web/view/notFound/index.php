<?php

/**
 * The template for displaying 404 pages (Not Found)
 *
 */
import('header'); ?>
    <div id="primary" class="full-page">
        <div class="errorDiv">
            <p><h1><?=_t('Not Found')?></h1></p>
            <p><?=_t('Sorry, the page you visited has migrated or does not exist')?></p>
            <p><span id="timedown" style="font-size:2em;color:#EB4444"></span> s </p>
        </div>
    </div>
    <!-- #primary -->
    <style>
    .errorDiv{
        margin: 0 auto;
        text-align: center;
    }
    </style>
    <script type="text/javascript">  
    //设定倒数秒数  
    var t = 15;  
    //显示倒数秒数  
    function showTime(){  
        t -= 1;  
        document.getElementById('timedown').innerHTML= t;  
        if(t==0){  
            location.href='<?=$option->info['url']?>';  
        }  
        //每秒执行一次,showTime()  
        setTimeout("showTime()",1000);  
    }  

    //执行showTime()  
    showTime();  
    </script>  
<?php import('footer'); ?>