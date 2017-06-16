<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AdminMenu */

$this->title = '修改菜单';
$this->params['breadcrumbs'][] = ['label' => '菜单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '浏览菜单', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改菜单';
?>
<div class="admin-menu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_menu_form', [
        'model' => $model,
        'parentMenu' => $parentMenu,
    ]) ?>

</div>
