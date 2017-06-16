<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AdminAccess */

$this->title = '修改权限项';
$this->params['breadcrumbs'][] = ['label' => '权限项管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '浏览权限项', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="admin-access-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_access_form', [
        'model' => $model,
        'parentAccess'=>$parentAccess,
    ]) ?>

</div>
