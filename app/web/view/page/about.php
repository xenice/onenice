<?php
/*
Template Name: About
*/
import('header'); ?>
    <div  id="primary" class="full-page">
        <div class="aboutDiv">
            <div class="aboutDiv">
                <?php echo get_avatar( 'xenice@qq.com', 128, '', ''); ?>
            </div>
            <br>
            <div class="aboutDiv">
            <span>
                <a href="https://github.com/AgateLee" target="_blank"><i class="fa fa-github fa-2x icon-github" onclick=""></i></a>&nbsp;&nbsp;
                <a href="http://weibo.com/agatelee/" target="_blank"><i class="fa fa-weibo fa-2x icon-weibo" onclick=""></i></a>&nbsp;&nbsp;
                <span class="weixin">
                    <span class="weixin_box">
                        <span class="fa fa-weixin fa-2x icon-weixin" onclick="">
                            <div class="weixin_pic">
                                <img src="http://agatelee.cn/wp-content/uploads/2016/06/weixin.png">
                            </div>
                        </span>
                    </span>
                </span>&nbsp;&nbsp;
                <a href="mailto:liyi5133@126.com"><i class="fa fa-envelope fa-2x icon-mail" onclick=""></i></a>
            </span>
            </div>
            <div class="aboutDiv">
                <pre class="hollow" onclick="">北京邮电大学在读</pre>
                <pre class="hollow" onclick="">文档&nbsp;美工&nbsp;程序员</pre>
            </div>
                
        </div>
    </div>
    <!-- #primary -->
    <style>
    .aboutDiv{
        margin: 0 auto;
        width:80%;
        height:80%;
        text-align: center;
    }
    .icon-github{
        font-family: 'xenice-pure';
        color:#bbb;
    }
    .icon-github:hover{
        color:#50abf1;
    }
    .icon-weibo{
        color:#bbb;
    }
    .icon-weibo:hover{
        color:#eb4444;
    }
    .icon-weixin{
        color:#bbb;
    }
    .icon-weixin:hover{
        color:#7fd321;
    }
    .icon-mail{
        color:#bbb;
    }
    .icon-mail:hover{
        color:#ff9200;
    }

    .hollow {
        display: block;
        -webkit-transition-duration: 0.3s;
        transition-duration: 0.3s;
        -webkit-transition-property: background;
        transition-property: background;
        -webkit-transform: translateZ(0);
        -ms-transform: translateZ(0);
        transform: translateZ(0);
        box-shadow: inset 0 0 0 3px #f8f8f8, 0 0 1px rgba(0, 0, 0, 0);
        /* Hack to improve aliasing on mobile/tablet devices */
    }

    .hollow:hover {
        background: none;
    }

    .weixin {
        padding:0
    }
    .weixin .weixin_box {
        margin:30px 0 10px
    }
    .weixin .weixin_box .fa {
        position:relative;
        margin:0 5px;
        font-size:30px
    }
    .weixin .weixin_box .fa .weixin_pic {
        position:absolute;
        display:none;
        margin-left:-50px;
        left:50%;
        bottom:130%;
        width:100px;
        height:100px;
        background-color:#fff;
        box-shadow:0 2px 4px rgba(0,0,0,.5)
    }

    .weixin .weixin_box .fa .weixin_pic img {
        width:100%
    }
    .weixin .weixin_box .fa:hover .weixin_pic {
        display:inline-block
    }
    #bottom-bar .wf-td p fa fa-weixin{
        display: none;
    }
    </style>

<?php import('footer'); ?>
