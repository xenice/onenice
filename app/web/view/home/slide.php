<?php
    $img1 = take('slide_image_1');
    $img2 = take('slide_image_2');
    $img3 = take('slide_image_3');
?>
<style>
@media screen and (min-width:768px){
    .carousel-caption{
        bottom: 100px;
    }
    .carousel-caption h3{
        font-size:1.25rem;
    }
    .carousel-caption p{
        color:#eee;
    }
}
@media screen and (max-width:767px) {
    .carousel-caption{
        bottom: 40px;
    }
}
</style>
<div id="demo" class="carousel slide" data-ride="carousel">
  <!-- 指示符 -->
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>
 
  <!-- 轮播图片 -->
  <div class="carousel-inner rounded">
    <div class="carousel-item active">
      <a href="<?=$img1['url']?>" title="<?=$img1['title']?>">
          <img src="<?=$img1['path']?>" alt="<?=$img1['title']?>" />
          <?php if(take('display_slide_title')):?>
          <div class="carousel-caption">
            <h3><?=$img1['title']?></h3>
            <p class="md-down-none"><?=$img1['desc']?></p>
          </div>
          <?php endif;?>
      </a>
    </div>
    <div class="carousel-item">
      <a href="<?=$img2['url']?>" title="<?=$img2['title']?>">
          <img src="<?=$img2['path']?>" alt="<?=$img2['title']?>" />
          <?php if(take('display_slide_title')):?>
          <div class="carousel-caption">
            <h3><?=$img2['title']?></h3>
            <p class="md-down-none"><?=$img2['desc']?></p>
          </div>
          <?php endif;?>
      </a>
    </div>
    <div class="carousel-item">
      <a href="<?=$img3['url']?>" title="<?=$img3['title']?>">
          <img src="<?=$img3['path']?>" alt="<?=$img3['title']?>" />
          <?php if(take('display_slide_title')):?>
          <div class="carousel-caption">
            <h3><?=$img3['title']?></h3>
            <p class="md-down-none"><?=$img3['desc']?></p>
          </div>
          <?php endif;?>
      </a>
    </div>
  </div>
 
  <!-- 左右切换按钮 -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>
