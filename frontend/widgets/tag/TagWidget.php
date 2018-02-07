<?php
/**
 * Created by PhpStorm.
 * User: moon
 * Date: 2017/12/27
 * Time: 14:46
 */
namespace frontend\widgets\tag;

use common\models\TagModel;
use yii\bootstrap\Widget;

class TagWidget extends Widget
{

    public $title ='';

    public $limit=20;

    public function run()
    {
        $res = TagModel::find()
            ->orderBy(['post_num' => SORT_DESC])
            ->limit($this ->limit)
            ->all();

        $result ['title'] = $this->title?:'标签云';
        $result ['body'] = $res?:[];

        return $this->render('index',['data' =>$result]);
    }
}