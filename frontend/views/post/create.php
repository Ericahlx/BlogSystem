<?php


use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use fronted\controllers\PostController;
use common\widgets\file_upload;
$this->title = '创建';
//加入一个面包屑
$this->params['breadcrumbs'][] = ['label' => '文章','url'=>['post/index']];
$this->params['breadcrumbs'][] = $this->title;

?> 

<div class="row">
	<div class="col-lg-9">
		<div class="panel-title box-title">
			<span>创建文章</span>
		</div>
		<div class="panel-body">
			<?php $form = ActiveForm::begin() ?>

			<?=$form ->field($model,'title')->textinput(['maxlength' => true])?>
			<!-- <?//=$form ->field($model,'id')->textinput(['maxlength' => true])?> -->


			<!-- <?//=$form ->field($model,'content')->textinput(['maxlength' => true])?> -->
			<!-- content修改为如下百度编辑器格式 -->
			<?= $form->field($model, 'content')->widget('common\widgets\ueditor\Ueditor',[
			    'options'=>[
			        //'initialFrameWidth' => 850,//文本框宽度
			    ]
			]) ?>

			<!-- <?//=$form ->field($model,'label_img')->textinput(['maxlength' => true])?> -->
			<!-- 用主键的方式去加载标签图 -->
			<?= $form->field($model, 'label_img')->widget('common\widgets\file_upload\FileUpload',[
		        'config'=>[
		        	//图片上传后的保存路径在
		            //图片上传的一些配置，不写调用默认配置
		            //'domain_url' => 'http://www.yii-china.com',
		        ]
		    ]) ?>

			<!-- <?//=$form ->field($model,'tags')->textinput(['maxlength' => true])?> -->
			<?=$form ->field($model,'tags')->widget('common\widgets\tags\tagWidget')?>


			<!-- 数据库取分类信息，填充到下拉列表 -->
		<!-- 	<?//=$form ->field($model,'cat_id')->dropDownList(['1' => '分类1','1' => '分类1','2' => '分类2'])?> -->
			<!-- 将原有死数据替换成cat -->
			<?=$form ->field($model,'cat_id')->dropDownList($cat)?>


			<div class="form-group">
				<?= Html::submitButton("发布",['class' => 'btn btn-success'])?>
			</div>


			<?php ActiveForm::end() ?>

		</div>
	</div>
	<div class="col-lg-3">
		<div class="panel-title box-title">
			<span>注意事项</span>
		</div>
		<div class="panel-body">
			<p>1、kajflkjafakfjafj得到</p>
			<p>2、kajflkjafakfjafj得到</p>
			<p>3、kajflkjafakfjafj得到</p>

		</div>
	</div>
</div>