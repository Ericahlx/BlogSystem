<?php
/**
 * Created by PhpStorm.
 * User: moon
 * Date: 2017/12/25
 * Time: 16:09
 */

namespace frontend\widgets\chat;

//留言板

use frontend\models\FeedForm;
use yii\bootstrap\Widget;

class ChatWidget extends Widget
{
    public function run()
    {
        $feed = new FeedForm();
        $data['feed'] = $feed -> getList();
        return $this -> render('index',['data' => $data]);
    }
}
