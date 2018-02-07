<?php

use yii\helpers\Url;

?>



<div id="myCarousel" class="carousel slide">

    <!-- 轮播（Carousel）指标 -->

    <ol class="carousel-indicators">

        <?php foreach ($data['items'] as $k=>$list):?>

            <li data-target="#myCarousel" data-slide-to=<?=$k ?> class="<?=$list['active']?>"></li>

        <?php endforeach;?>

    </ol>
    <div class="carousel-inner home-banner" role='listbox'>

        <?php foreach ($data['items'] as $k=>$list):?>
        <div class="item <?=$list['active']?>">
            <a href="<?=Url::to($list['url']) ?>">
                <img style="width:848px;height:300px" src="<?=$list['image_url']?>" alt="<?=$list['label']?>">
            </a>
        </div>
        <?php endforeach;?>
    </div>

    <!-- 轮播（Carousel）导航 -->

    <a class="carousel-control left" href="#myCarousel"

       data-slide="prev">&lsaquo;</a>

    <a class="carousel-control right" href="#myCarousel"

       data-slide="next">&rsaquo;</a>

</div>