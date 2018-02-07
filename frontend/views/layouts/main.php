<?php
//这是前台框架的布局文件
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        //主页标题
        'brandLabel' => yii::t('common','Blog'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
   /* $menuItems = [

        ///更换菜单栏提示语言
        ['label' => yii::t('yii','Home'), 'url' => ['/site/index']],
        ['label' => yii::t('common','About'), 'url' => ['/site/about']],
        ['label' => yii::t('common','Contact'), 'url' => ['/site/contact']],

        //['label' => 'Home', 'url' => ['/site/index']],
       /* ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],*/
  //  ];
    //将右上的首页 关于 等信息改到左上角并换名
    $leftMenus = [

        ///更换菜单栏提示语言
        ['label' => yii::t('yii','Home'), 'url' => ['/site/index']],
        ['label' => '文章', 'url' => ['/post/index']],
       

        //['label' => 'Home', 'url' => ['/site/index']],
       /* ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],*/
    ];
    if (Yii::$app->user->isGuest) {
        //修改右上角提示信息语言
        $rightMenus[] = ['label' => yii::t('common','Signup'), 'url' => ['/site/signup']];
        $rightMenus[] = ['label' => yii::t('common','Login'), 'url' => ['/site/login']];
        //$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
       // $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        //修改menuItems为rightMenus
       /* $rightMenus[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',

                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';*/

         $rightMenus[] = [
            'label' =>'<img src= "'.yii::$app->params['avatar']['small'].'" alt = "'.yii::$app -> user ->identity -> username.'">',
            //加入头像样式
            'linkOptions' =>['class' => 'avatar'],
            'items' => [
                ['label' =>'<i class="fa fa-sign-out"></i>  退出','url' => ['/site/logout'],'linkOptions' =>['data-method' => 'post']]
            ],
         ];
    }
    //添加一个左侧菜单样式
        echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $leftMenus,
    ]);

    //将原来菜单栏改为了右侧菜单栏
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        //添加encodelabels使得图片可以显示
        'encodeLabels' => false,
        'items' => $rightMenus,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
