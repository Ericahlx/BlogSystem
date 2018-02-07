<?php 
namespace frontend\models;

use yii;
use yii\base\Model;
use common\models\TagModel;



	/**
	*  标签的表单模型
	*/
class TagForm extends Model
{
	public $id;
	public $tags;

	public function rules()
	{

		return [
			['tags','required'],
			['tags','each','rule' => ['string']],
		];
	}

/*
	保存标签集合
*/
	public function saveTags()
	{
		$ids =[];
		if (!empty($this->tags)) {
			# code...
			foreach ($this ->tags as $tag ) {
				# 所以下面_saveTag里面只有一条数据，返回一个id
				$ids[] = $this -> _saveTag($tag);
			}
		}
		return $ids;
	}
/*
	保存单个标签，调用业务逻辑
*/
	private function _saveTag($tag)
	{
		$model = new TagModel();
		$res = $model -> find() -> where(['tag_name' => $tag]) -> one();

		//新建标签
		//判断是否有数据
		if (!$res) {
			# code...
			$model -> tag_name = $tag;
			$model -> post_num = 1;
			if (!$model -> save()) {
				# code...
				throw new Exception("保存标签失败！");
				
			}
			return $model -> id;
		}
		else{
				//给post_num+1的操作
				$res -> updateCounters(['post_num' => 1]);

		}
		return $res -> id;
	} 


}



 ?>