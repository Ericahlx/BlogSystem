<?php
//点击注册后所引用的页面
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

//$this->title = 'Signup';
//注册界面左上角信息修改为中文
$this->title = '注册';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>Please fill out the following fields to signup:</p> -->
    <!-- 将提示语修改为中文 -->
    <p>请填写以下相关信息进行注册</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <!-- 此处的语言替换方法，需要在models相应的signupform文件写相应的替换函数 -->
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>
                <!-- 仿照上面增加两个表单来实现重复密码功能 -->
                <?= $form->field($model, 'rePassword')->passwordInput() ?>
                <?= $form->field($model, 'verifyCode')->widget(Captcha::className()) ?>

                <div class="form-group">
                    <!-- <//?= //Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) //?> -->
                    <!-- 将按钮上的提示信息修改为中文 -->
                    <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
