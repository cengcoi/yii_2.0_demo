<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdminMenu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'menu_text')->textInput(['maxlength' => true,'placeholder'=>'']) ?>

    <?= $form->field($model, 'icon_alias')->textInput(['maxlength' => true,'placeholder'=>'使用fontawesomeicon中fa后面带的别名，不需要中横杠']) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true,'placeholder'=>'基本上是yii中生成路径带的参数，样式：controller/action或#']) ?>

    <?= $form->field($model, 'access_name')->textInput(['maxlength' => true,'placeholder'=>'由controller或者加action组成，样式：controller_action或controller']) ?>

    <?= $form->field($model, 'parent_id')->dropDownList($parentMenu) ?>

    <?= $form->field($model, 'is_display')->dropDownList([0=>'不显示',1=>'显示']) ?>

    <?= $form->field($model, 'rank')->textInput(['value'=>$model->rank ? $model->rank : 0]) ?>

    <?= $form->field($model, 'is_sys')->dropDownList([0=>'否',1=>'是']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '增加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
