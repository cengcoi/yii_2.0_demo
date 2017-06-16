<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AdminRole */

$this->title = '修改角色';
$this->params['breadcrumbs'][] = ['label' => '角色管理', 'url' => ['role-index']];
$this->params['breadcrumbs'][] = ['label' => '浏览角色', 'url' => ['role-view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="admin-role-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_role_form', [
        'model' => $model,
        'access_tree' => $access_tree,
    ]) ?>

</div>
