<?php
//点击登陆后所引用的页面
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

//$this->title = 'Login';
//注册界面左上角信息修改为中文
$this->title = '登陆';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
<!-- 将下面提示信息修改为中文 -->
   <!--  <p>Please fill out the following fields to login:</p> -->
   <p>请填写您的用户名和密码进行登陆：</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#999;margin:1em 0">
                    <!-- If you forgot your password you can -->如果您忘记密码可以 
                    <?= Html::a('重置', ['site/request-password-reset']) ?>.
                </div>

                <div class="form-group">
                    <!-- 将按钮上的提示信息修改为中文 -->
                    <!-- </?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?> -->
                    <?= Html::submitButton('登陆', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
