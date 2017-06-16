<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AdminAccess */

$this->title = '权限项浏览';
$this->params['breadcrumbs'][] = ['label' => '权限项管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-access-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['access-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['access-delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除该权限项吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'access_name',
            'description',
            'parent_id',
        ],
    ]) ?>

</div>
