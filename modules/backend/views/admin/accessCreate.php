<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AdminAccess */

$this->title = '增加权限项';
$this->params['breadcrumbs'][] = ['label' => '权限项管理', 'url' => ['access-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-access-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_access_form', [
        'model' => $model,
        'parentAccess'=>$parentAccess,
    ]) ?>

</div>
