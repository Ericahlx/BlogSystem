<?php

namespace frontend\widgets\post\PostWidget;

use frontend\widgets\post\PostWidget;
use frontend\widgets\hot\HotWidget;
use frontend\widgets\tag\TagWidget;
use yii\helpers\Url;

//echo "应该调用的是views下的index";
?>

<div class="row">
    <div class="col-lg-9">
        <?=PostWidget::widget([]); ?>
        <!--widget([])中可以添加参数，控制分页数据如（'limit'=> 1）-->
    </div>

    <div class="col-lg-3">
        <div class="panel">
            <?php if (!\yii::$app ->user ->isGuest):?>
                <a class="btn btn-success btn-block btn-post" href="<?=Url::to(['post/create'])?>"> 创建文章 </a>
            <?php endif;?>
        </div>
        <!--调用热度浏览组件-->
        <?=HotWidget::widget() ?>
        <!--标签云-->
        <?=TagWidget::widget() ?>
    </div>

</div>
