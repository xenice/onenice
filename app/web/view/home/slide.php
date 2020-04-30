<?php
    $img1 = take('slide_image_1');
    $img2 = take('slide_image_2');
    $img3 = take('slide_image_3');
?>
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
      <a href="<?=$img1['url']?>" title="<?=$img1['title']?>"><img src="<?=$img1['path']?>" /></a>
    </div>
    <div class="carousel-item">
      <a href="<?=$img2['url']?>" title="<?=$img2['title']?>"><img src="<?=$img2['path']?>" /></a>
    </div>
    <div class="carousel-item">
      <a href="<?=$img3['url']?>" title="<?=$img3['title']?>"><img src="<?=$img3['path']?>" /></a>
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
