<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdminRole */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-role-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php if($model->isNewRecord) { ?>
        <?= $form->field($model, 'role_name')->textInput(['maxlength' => true]) ?>
    <?php }else { ?>
        <h2>角色名称：<?= $model->role_name ?></h2>
    <?php } ?>
    <?php foreach($access_tree as $key=>$val){
        if(($key+1)%2 != 0) : echo '<div class="col-xs-12">'; endif;
        echo '<div class="col-xs-6">';
        echo Html::checkbox('access[]',in_array($val['id'],explode(',',$model['access'])),['value'=>$val['id']]).$val['description'].'</br>';
        if(isset($val['children'])){
            foreach($val['children'] as $v){
                echo Html::checkbox('access[]',in_array($v['id'],explode(',',$model['access'])),['value'=>$v['id']]).$v['description'].'</br>';
            }
        }
        echo '</div>';
        if(($key+1)%2 == 0) : echo '</div>'; endif;
    }?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '增加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
