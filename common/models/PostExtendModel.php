<?php

namespace common\models;

use Yii;
use common\models\base\BaseModel;

/**
 * This is the model class for table "post_extends".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $browser
 * @property integer $collect
 * @property integer $praise
 * @property integer $comment
 */
class PostExtendModel extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_extends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'browser', 'collect', 'praise', 'comment'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'browser' => 'Browser',
            'collect' => 'Collect',
            'praise' => 'Praise',
            'comment' => 'Comment',
        ];
    }


    /*
    更新文章统计
    */
    public function upCounter($cond,$attibute,$num)
    {
        $counter = $this -> findOne($cond);
        //此模型不存在的话创建一个,存在的话进行更新
        if (!$counter) {
            $this -> setAttributes($cond);
            $this -> $attibute = $num;
            $this -> save();
        } else {
            $countData[$attibute] = $num;
            $counter -> updateCounters($countData);
        }
        
    }
}
