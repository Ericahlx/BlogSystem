<?php
/**
 * Created by PhpStorm.
 * User: moon
 * Date: 2017/12/25
 * Time: 15:15
 */
namespace frontend\widgets\banner;



use yii\bootstrap\Widget;

class BannerWidget extends Widget
{
    public $items = [];


    public function init()//获取数据
    {
        if(empty($this -> items)) {
            $this->items = [
                ['label' => 'demo1',
                    'image_url' => '/statics/images/banner/b_0.png',
                    'url' => ['site/index'],
                    'html' =>"",
                    'active' =>'active',
                ],
                ['label' => 'demo2',
                    'image_url' => '/statics/images/banner/b_1.png',
                    'url' => ['site/index']],
                ['label' => 'demo3',
                    'image_url' => '/statics/images/banner/b_2.png',
                    'url' => ['site/index']],
            ];
        }
    }

    public function run()//运行
    {
        $data['items'] = $this -> items;
        return $this ->render('index',['data' => $data]);
    }
}