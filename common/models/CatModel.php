<?php

namespace common\models;

use Yii;
use common\models\base\BaseModel;
/**
 * This is the model class for table "cats".
 *
 * @property integer $id
 * @property string $cat_name
 */
class CatModel extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cats';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_name' => 'Cat Name',
        ];
    }

/*
获取所有分类
*/
    public static function getAllCats()
    {
        //避免取不到数据时报错
        $cat = ['0' =>'暂无分类'];
        //取到所有分类
        $res = self::find() -> asArray() ->all();
        //打印相关信息检测取到的值
       // var_dump($res);exit();

        //判断是否取到
        if($res){
            foreach ($res as $k => $list) {
                $cat[$list['id']] = $list['cat_name'];
            }
        }
        //打印查看是否获取到正确信息
        //print_r($cat);exit();
        return $cat;


    }
}
