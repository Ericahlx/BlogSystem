<?php 

namespace frontend\widgets\post;
use common\models\PostModel;
use YII;
use yii\base\Widget;
use yii\data\Pagination;
use yii\helpers\Url;
use frontend\models\PostForm;


/**
* 文章列表组件
*/
class PostWidget extends Widget
{
    //文章标题
	public $title = '';
    //显示条数
	public $limit = 4;
    //是否显示更多选项
	public $more = true;
    //是否显示分页
	public $page = true;
	public function run()
	{

	    $curPage = yii::$app -> request -> get('page',1);
	    //查询条件
        $cond = ['=','is_valid',PostModel::IS_VALID];
        $res = PostForm::getList($cond,$curPage,$this -> limit);
        $result['title'] = $this -> title?:"最新文章";//调用此组件不配置title时默认显示“最新文章”
		$result['more'] = Url::to(['post/index']);
		$result['body'] = $res['data']?:[];

		//是否显示分页
        if ($this -> page){
            $pages = new Pagination(['totalCount' => $res['count'],'pageSize' => $res['pageSize']]);
            $result['page'] = $pages;
        }

        //渲染页面
		return $this -> render ('index',['data' => $result]);

	}
}


