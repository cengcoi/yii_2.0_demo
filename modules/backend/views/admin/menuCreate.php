<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AdminMenu */

$this->title = '增加菜单';
$this->params['breadcrumbs'][] = ['label' => '菜单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-menu-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_menu_form', [
        'model' => $model,
        'parentMenu' => $parentMenu,
    ]) ?>

</div>
