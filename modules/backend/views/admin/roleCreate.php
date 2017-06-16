<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AdminRole */

$this->title = '增加角色';
$this->params['breadcrumbs'][] = ['label' => '角色管理', 'url' => ['role-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-role-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_role_form', [
        'model' => $model,
        'access_tree' => $access_tree,
    ]) ?>

</div>
