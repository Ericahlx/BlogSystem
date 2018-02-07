<?php
//前台资源控制文件
namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    //添加statics后在这里修改引用css的路径
    public $css = [
        'statics/css/site.css',
        'statics/css/font-awesome-4.4.0/css/font-awesome.min.css',
    ];
    public $js = [
        'statics/js/site.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
