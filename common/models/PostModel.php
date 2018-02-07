<?php
//由gii生成了文章表的数据模型
namespace common\models;

use Yii;
use common\models\base\BaseModel;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property string $content
 * @property string $label_img
 * @property integer $cat_id
 * @property integer $user_id
 * @property string $user_name
 * @property integer $is_valid
 * @property integer $created_at
 * @property integer $updated_at
 */
class PostModel extends BaseModel//此处修改后默认此文件头部会自动加载相应命名空间，如果没加载需要手动加入
{
    const IS_VALID = 1; //已经发布
    const NO_VALID = 0; //未发布 
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        //映射一张posts表
        return 'posts';
    }

    //加一个关联关系
    public function getRelate()
    {

        return $this -> hasMany(RelationPostTagModel::className(),['post_id' => 'id']);

    }
    public function getExtend()
    {
        return $this ->hasOne(PostExtendModel::className(),['post_id' => 'id']);
    }

    //做一个分类的关联关系
    public function getCat()
    {
        return $this ->hasOne(CatModel::className(),['id' => 'cat_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['cat_id', 'user_id', 'is_valid', 'created_at', 'updated_at'], 'integer'],
            [['title', 'summary', 'label_img', 'user_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //如果作了语言包的映射会生成这种形式
            //'id' => yii::t('',''),
            'id' => 'ID',
            'title' => 'Title',
            'summary' => 'Summary',
            'content' => 'Content',
            'label_img' => 'Label Img',
            'cat_id' => 'Cat ID',
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'is_valid' => 'Is Valid',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
//生成好之后去创建一个文件夹名为base，创建基类模型