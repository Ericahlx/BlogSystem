<?php
/**
 * Created by PhpStorm.
 * User: moon
 * Date: 2017/12/26
 * Time: 17:50
 */

namespace frontend\widgets\hot;


use common\models\PostExtendModel;
use common\models\PostModel;
use yii\bootstrap\Widget;
use yii\db\Query;



class HotWidget extends Widget
{

    public $title ='';

    public $limit =6;
    public function run()
    {//也可以在初始化文件中写run方法
        $res = (new Query())
            ->select('a.browser, b.id, b.title')
            ->from(['a' => PostExtendModel::tableName()])
            ->join('LEFT JOIN',['b' => PostModel::tableName()],'a.post_id = b.id')
            ->where('b.is_valid ='.PostModel::IS_VALID)
            ->orderBy(['browser' => SORT_DESC,'id' => SORT_DESC])
            ->limit($this->limit)
            ->all();

        $result['title'] = $this ->title ?: '热门浏览';
        $result['body'] = $res?:[];

        return $this->render('index',['data' =>$result]);
    }
}