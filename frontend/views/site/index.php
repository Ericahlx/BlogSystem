<?php
error_reporting(0);
use frontend\widgets\banner\BannerWidget;
use frontend\widgets\post\PostWidget;
use frontend\widgets\chat\ChatWidget;
use frontend\widgets\hot\HotWidget;
use frontend\widgets\tag\TagWidget;

$this->title = '博客-首页';
?>

<div class="row">
    <div class="col-lg-9">
        <!--调用轮播组件-->
        <?=BannerWidget::widget() ?>
        <!--调用文章列表组件-->
        <?=PostWidget::widget() ?>
    </div>


    <div class="col-lg-3">
        <!--调用留言板组件-->
        <?=ChatWidget::widget() ?>

        <!--调用热度浏览组件-->
        <?=HotWidget::widget() ?>

        <!--标签云-->
        <?=TagWidget::widget()?>
    </div>

</div>