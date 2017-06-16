<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\bootstrap\ActiveForm;
use app\assets\LoginAsset;

LoginAsset::register($this);

$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="center">
    <h1>
        <i class="ace-icon fa fa-leaf green"></i>
        <span class="red">美骑网</span>
        <span class="grey" id="id-text2">美骑后台系统</span>
    </h1>
    <h4 class="blue" id="id-company-text">&copy; biketo.com</h4>
</div>

<div class="space-6"></div>

<div class="position-relative">
    <div id="login-box" class="login-box visible widget-box no-border">
        <div class="widget-body">
            <div class="widget-main">
                <h4 class="header blue lighter bigger">
                    <i class="ace-icon fa fa-coffee green"></i>
                    填写登录信息
                </h4>

                <div class="space-6"></div>

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{input}\n<span class=\"col-lg-8\">{error}</span>",
                    ],
                ]); ?>
                <fieldset>
                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => '用户名', 'class' => 'form-control']) ?>
                            <i class="ace-icon fa fa-user"></i>
                        </span>
                    </label>

                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <?= $form->field($model, 'password')->passwordInput(['placeholder' => '密码', 'class' => 'form-control']) ?>
                            <i class="ace-icon fa fa-lock"></i>
                        </span>
                    </label>

                    <div class="space"></div>

                    <div class="clearfix">
                        <label class="inline">
                            <?= $form->field($model, 'rememberMe')->checkbox([
                                'template' => "{input} {label}\n<div class=\"col-lg-8\">{error}</div>",
                            ]) ?>
                        </label>


                        <button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                            <i class="ace-icon fa fa-key"></i>
                            <span class="bigger-110">登录</span>
                        </button>
                    </div>

                    <div class="space-4"></div>
                </fieldset>
                <?php ActiveForm::end(); ?>
            </div>
            <!-- /.widget-main -->
        </div>
        <!-- /.widget-body -->
    </div>
    <!-- /.login-box -->

</div>
<!-- /.position-relative -->
