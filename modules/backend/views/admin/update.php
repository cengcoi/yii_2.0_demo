<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Admin */

$this->title = '修改后台用户 ';
$this->params['breadcrumbs'][] = ['label' => '后台用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '后台用户浏览', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改后台用户';
?>
<div class="admin-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'roleSelect'=>$roleSelect,
    ]) ?>

</div>
