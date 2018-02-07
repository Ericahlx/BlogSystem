<?php
/**
 * Created by PhpStorm.
 * User: moon
 * Date: 2017/12/15
 * Time: 9:57
 */

namespace frontend\controllers;
/*
 文章控制器
 	*/
use yii;
use frontend\controllers\base\BaseController;

use frontend\models\PostForm;
use common\models\CatModel;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\PostExtendModel;



class PostController extends BaseController{
   

   //添加一个过滤的方法
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create','upload','ueditor'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                      //  'roles' => ['?'],//不登录就能访问，去掉之后无论是否登陆都可以访问index
                    ],
                    [
                        'actions' => ['upload','ueditor','create'],
                        'allow' => true,
                        'roles' => ['@'],//登陆才能访问
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    '*' => ['get','post'],//所有方法都只能用get方法访问
                   // 'create' => ['get','post'],//但是create只能用get、post访问
                ],
            ],
        ];
    }
/*
    图上传
*/
    public function actions()
    {
        return [
            'upload'=>[
                'class' => 'common\widgets\file_upload\UploadAction',     //这里扩展地址别写错
                'config' => [
                    'imageUrlPrefix' => "",/*图片访问路径前缀*/
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ],
            'ueditor'=>[
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ],//这里配置完成之后去配置view层
        ];
    }
/*
	文章列表
*/
    public function actionIndex()
    {

        return $this-> render('index');
    }
    //然后去修改view层

    /*
	创建一个添加文章的控制器
	创建文章
	@return string
    */
    public function actionCreate()
    {
    	$model = new PostForm();
        //定义分类
        $model -> setScenario(PostForm::SCENARIOS_CREATE);
        if ($model -> load(\yii::$app->request->post()) && $model->validate()) {
            if (!$model -> create()) {
                yii::$app -> session -> setFlash('warning',$model -> _lastError);
            } else {
                # code...
                //引用在postform记录的id
               // var_dump($model->_lastError);die;
                return $this -> redirect (['post/view','id'=>$model -> id]);
            }
            
        }
        
        //获取所有分类
        $cat = CatModel::getAllCats();
    	//作控制器生成
    	return $this->render('create',['model' => $model,'cat' => $cat]);
    }

//文章展示详情页面
    public function actionView($id){
        //获取数据
        $model = new PostForm();
        $data = $model -> getViewById($id);

        //统计文章访问次数
        $model = new PostExtendModel();
        //通过post_id查询到这个model
        $model -> upCounter(['post_id' => $id],'browser',1);

        //渲染页面
        return $this -> render('view',['data' => $data]);

    }



}
?>