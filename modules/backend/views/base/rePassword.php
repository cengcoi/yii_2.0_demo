<?php
/**
 * @author: xin
 * Date: 2016/8/15
 * Time: 11:48
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\backend\PasswordForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-access-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-4 form-group">
                <?= $form->field($model, 'oldPassword')->passwordInput() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 form-group">
                <?= $form->field($model, 'rePassword')->passwordInput() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 form-group">
                <?= $form->field($model, 'rePasswordConfirm')->passwordInput() ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>