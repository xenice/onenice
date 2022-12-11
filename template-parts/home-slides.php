<?php

$str1 = '<ul class="carousel-indicators">'; 
$str2 = '<div class="carousel-inner rounded">';

/*
var_dump(onenice_get('slides_title_1'));
exit;*/
for($i=0;$i<3;$i++){
    $j = $i + 1;
    $src = onenice_get('slides_image_'.$j)??'';
    $title = onenice_get('slides_title_'.$j)??'';
    $url = onenice_get('slides_url_'.$j)??'';
    $desc = onenice_get('slides_description_'.$j)??'';
    
    if(empty($src)) continue;

    if($i == 0){
        $str1 .= '<li data-target="#demo" data-slide-to="0" class="active"></li>';
        $str2 .= '<div class="carousel-item active">';
    }
    else{
        $str1 .= '<li data-target="#demo" data-slide-to="'.$i.'"></li>';
        $str2 .= '<div class="carousel-item">';
        
    }
    $str2 .= '<a href="'. $url .'" title="' . $title .'" target="blank">';
    $str2 .= '<img src="' . $src . '" alt="'.$title.'" />';
    if($desc){
        $str2 .= '<div class="carousel-caption"><h3>'.$title.'</h3><p class="md-down-none">'.$desc.'</p></div>';
    }
    $str2 .= '</a></div>';
}

$str1 .= '</ul>';
$str2 .= '</div>';

?>
<style>
.carousel-caption{
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    bottom: 10px;
    top:10px;
}


@media screen and (min-width:768px){
    .carousel-caption h3{
        margin:15px;
        font-size:1.25rem;
    }
    .carousel-caption p{
        color:#eee;
    }
}
@media screen and (max-width:767px) {
    .carousel-caption h3{
        margin:0;
    }
}
</style>
<div id="demo" class="carousel slide" data-ride="carousel">
  <?php echo $str1 . $str2; ?>
 
  <!-- 左右切换按钮 -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>
