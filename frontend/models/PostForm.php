<?php

namespace frontend\models;
/*
文章表单模型
*/
use yii;
use yii\base\Model;
use common\models\PostModel;
use common\models\RelationPostTagModel;
use yii\db\Query;

class PostForm extends Model
{

	public $id;
	public $title;
	public $content;
	public $label_img;
	public $cat_id;
	public $tags;

	public $_lastError ="";
//创建一个新建文章的场景

/*
	SCENARIOS_CREATE,创建
	SCENARIOS_UPDATE,更新
*/
	const SCENARIOS_CREATE ='create';
	const SCENARIOS_UPDATE ='update';
/*
	定义事件
*/
	const EVENT_AFTER_CREATE = "eventAfterCreate";
	const EVENT_AFTER_UPDATE = "eventAfterUpdate";


/*
 * 获取文章列表数据
 * */
    /**
     * @param $cond
     * @param int $curPage
     * @param int $pageSize
     * @param array $orderBy
     * @return array
     */
    public static function getList($cond, $curPage =1 , $pageSize = 5, $orderBy =['id' => SORT_DESC])
    {

        $model = new PostModel();
        //查询语句
        $select = ['id','title','summary','label_img','cat_id','user_id','user_name','is_valid','created_at','updated_at'
        ];
        //用query存一句sql
        $query = $model ->find()
                        ->select($select)
                        ->where($cond)
                        ->with('relate.tag','extend')
                        ->orderBy($orderBy);
        //query的实现，获取分页数据
        $res = $model -> getPages($query,$curPage,$pageSize);
        //格式化
        //print_r($res);die;
        $res['data'] = self::_formatList($res['data']); //静态方法才可以直接用self调用

        return $res;
    }
    //实现数据格式化
    public static function _formatList($data)
    {
        foreach ($data as &$list){
            $list['tags'] = [];
            if (isset($list['relate']) && !empty($list['relate'])){
                foreach ($list['relate'] as $lt){
                    $list['tags'][] =  $lt ['tag']['tag_name'];
                }
            }
            unset($list['relate']);
        }

        return $data;
    }
/*
	场景设置

*/
	public function scenarios()
	{

		$scenarios =[
			self::SCENARIOS_CREATE => ['title','content','label_img','cat_id','tags'],
			self::SCENARIOS_UPDATE => ['title','content','label_img','cat_id','tags'],
		];
		return array_merge(parent::scenarios(),$scenarios);
	}
	public function rules(){
		//定义字段的rule规则
		return[
			[['id','title','content','cat_id'],'required'],
			[['id','cat_id'],'integer'],
			['title','string','min'=>4,'max' => 50],
			//[['tags','_lastError'],'safe'],
		];		
	}

	public function attributeLabels()
	{

		return[
			'id' => yii::t('common','ID'),
			'title' => '标题',
			'content' => '内容',
			'label_img' => '标签图',
			'tags' => '标签', 
			'cat_id' => '分类',
		];
	}

    /**
     * @return bool
     * @throws yii\db\Exception
     */
    public function create()
	{

		//事务
		$transaction = yii::$app -> db -> beginTransaction();
		try {
			//新建一个model
			$model = new PostModel();
			//将数据加载到新建的model里
			$model -> setAttributes($this->attributes);
			$model -> summary = $this->_getSummary();
			$model -> user_id = yii::$app -> user -> identity -> id;
			$model -> user_name = yii::$app -> user -> identity -> username;
			$model -> is_valid = PostModel:: IS_VALID;
			$model -> created_at = time();
			$model -> updated_at = time();

			if (!$model -> save()) {
				# code...
				throw new \Exception('文章保存失败！');
				
			}
			//如果文章保存成功，那么记录id
			$this -> id = $model -> id;
			

			//调用事件,(1220)暂未实现
			//已实现 通过变量获取文章数据 传入方法
			$data = array_merge($this -> getAttributes(),$model -> getAttributes());
			$this -> _eventAfterCreate($data);

			
			$transaction -> commit();
			return true;
		} catch (\Exception $e) {
			$transaction -> rollBack();
			$this -> _lastError = $e -> getMessage();
			return false;
		}
	}


	public function getViewById($id)
	{
		//单层调用
		//$res = PostModel::find() -> with('relate') ->where(['id' =>  $id]) -> asArray() -> one();
		//二层调用,相当于是sql的嵌套语句
		$res = PostModel::find() -> with('relate.tag','extend') ->where(['id' =>  $id]) -> asArray() -> one();
		if (!$res) {
			# code...
			throw new \NotFoundHttpException('文章不存在!');
			
		}
		//在view.php页面打印res这句sql,查看输出结果
		//print_r($res);

		//处理标签,整理格式
		$res['tags'] = [];
		//判断一下标签内信息
		if (isset($res['relate']) && !empty($res['relate'])) {
			# code...
			foreach ($res['relate'] as $list) {
				# code...将list中的数据组合存入数组
				$res['tags'][] = $list['tag']['tag_name'];
			}
		}
		unset($res['relate']);//在输出结果中去掉relate字段,为了数组整洁
		//print_r($res);
		return $res;


	}
	/*
	截取文章摘要
	*/
	private function _getSummary($s = 0,$e = 90,$char = 'utf-8')
	{
		if(empty($this -> content))
		{
			return null;
		}
		return (mb_substr(str_replace('&nbsp;', '', strip_tags($this -> content)), $s,$e,$char));
	}

/*
 创建完成后调用事件方法
*/
	public function _eventAfterCreate($data)
	{
		//添加事件,将_eventAddTag作为一个事件注册到EVENT_AFTER_CREATE中
		$this -> on(self::EVENT_AFTER_CREATE,[$this,'_eventAddTag'], $data);
		//触发事件
		$this -> trigger(self::EVENT_AFTER_CREATE);
	}

	public function _eventAddTag($event)
	{
		//保存标签
		$tag = new TagForm();
		$tag -> tags = $event -> data ['tags'];
		$tagids = $tag -> saveTags();

		//删除原先关联
		RelationPostTagModel::deleteAll(['post_id' => $event -> data['id']]);


		//批量保存文章和标签的关联关系
		if(!empty($tagids)){
			foreach ($tagids as $k => $id) {
				# code...
				$row[$k]['post_id'] = $this -> id;
				$row[$k]['tag_id'] = $id;

			}
			//批量插入
			$res = (new Query()) -> createCommand()
			->batchInsert(RelationPostTagModel::tableName(),['post_id','tag_id'],$row)
			->execute();
			//返回结果
			if(!$res)
				throw new Exception("关联关系保存失败！");
				
		}

	}









}