<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdminAccess */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-access-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'access_name')->textInput(['maxlength' => true,'placeholder'=>'一般是：controller_action 的格式']) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true,'placeholder'=>'中文描述名称']) ?>

    <?= $form->field($model, 'parent_id')->dropDownList($parentAccess) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '增加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
