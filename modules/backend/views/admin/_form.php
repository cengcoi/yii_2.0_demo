<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php if($model->isNewRecord) {?>
        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    <?php }else { ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    <?php }?>

    <?= $form->field($model, 'role_id')->dropDownList($roleSelect) ?>

    <?= $form->field($model, 'is_lock')->dropDownList([0=>'正常',1=>'锁定']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '增加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
